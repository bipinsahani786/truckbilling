<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\TripBilling;
use App\Models\TripTransaction;
use App\Models\Vehicle;
use App\Models\Wallet;
use App\Models\Dealer;
use App\Models\User;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * TripService
 *
 * Core service for managing the complete trip lifecycle: creation,
 * data loading, status management, profit/loss calculation, PDF
 * generation, and filtered trip listing.
 */
class TripService
{
    /**
     * Create a new trip and mark the assigned vehicle as 'maintenance' (on-road).
     *
     * Validates that the vehicle belongs to the owner, is active, and
     * optionally validates the dealer ownership. Runs inside a DB transaction
     * to ensure atomicity.
     *
     * @param array $data    Trip attributes (vehicle_id, driver_id, dealer_id, from_location, to_location, start_date)
     * @param int   $ownerId The fleet owner's user ID
     * @return Trip The newly created trip instance
     *
     * @throws \InvalidArgumentException If vehicle or dealer validation fails
     */
    public function createTrip(array $data, int $ownerId): Trip
    {
        // Validate that the selected vehicle belongs to this owner and is available
        $vehicle = Vehicle::where('owner_id', $ownerId)
            ->where('id', $data['vehicle_id'])
            ->where('status', 'active')
            ->first();

        if (!$vehicle) {
            throw new \InvalidArgumentException('This vehicle is not available or is already on a trip.');
        }

        // Validate dealer ownership if a dealer was selected
        if (!empty($data['dealer_id'])) {
            $dealer = Dealer::where('owner_id', $ownerId)
                ->where('id', $data['dealer_id'])
                ->first();

            if (!$dealer) {
                throw new \InvalidArgumentException('Invalid dealer selected.');
            }
        }

        $trip = null;

        DB::transaction(function () use ($data, $ownerId, &$trip) {
            // Get the next trip number for this owner
            $latestTrip = Trip::where('owner_id', $ownerId)->orderBy('trip_number', 'desc')->first();
            $nextTripNumber = $latestTrip ? $latestTrip->trip_number + 1 : 1;

            // Create the trip record with uppercase locations for consistency
            $trip = Trip::create([
                'owner_id' => $ownerId,
                'trip_number' => $nextTripNumber,
                'vehicle_id' => $data['vehicle_id'],
                'driver_id' => $data['driver_id'],
                'dealer_id' => ($data['dealer_id'] ?? '') === '' ? null : $data['dealer_id'],
                'from_location' => strtoupper($data['from_location']),
                'to_location' => strtoupper($data['to_location']),
                'start_date' => $data['start_date'],
                'status' => 'in_transit',
            ]);

            // Mark the vehicle as 'maintenance' (on-road/unavailable)
            Vehicle::where('id', $data['vehicle_id'])->update(['status' => 'maintenance']);

            // Send notification to driver
            $driver = User::find($data['driver_id']);
            if ($driver) {
                $driver->notify(new \App\Notifications\NewTripNotification($trip));
            }

        });

        return $trip;
    }

    /**
     * Update an existing trip's core details.
     *
     * @param int   $tripId  The trip ID to update
     * @param array $data    Updated attributes
     * @param int   $ownerId The fleet owner's user ID
     * @return Trip The updated trip instance
     */
    public function updateTrip(int $tripId, array $data, int $ownerId): Trip
    {
        $trip = Trip::where('owner_id', $ownerId)->findOrFail($tripId);

        DB::transaction(function () use ($trip, $data) {
            // If vehicle is changing, handle status updates
            if ($trip->vehicle_id != $data['vehicle_id']) {
                // Release old vehicle
                Vehicle::where('id', $trip->vehicle_id)->update(['status' => 'active']);
                // Occupy new vehicle
                Vehicle::where('id', $data['vehicle_id'])->update(['status' => 'maintenance']);
            }

            $trip->update([
                'vehicle_id' => $data['vehicle_id'],
                'driver_id' => $data['driver_id'],
                'dealer_id' => ($data['dealer_id'] ?? '') === '' ? null : $data['dealer_id'],
                'from_location' => strtoupper($data['from_location']),
                'to_location' => strtoupper($data['to_location']),
                'start_date' => $data['start_date'],
            ]);
        });

        return $trip;
    }

    /**
     * Delete a trip and all its associated data.
     *
     * @param int $tripId  The trip ID to delete
     * @param int $ownerId The fleet owner's user ID
     * @return void
     */
    public function deleteTrip(int $tripId, int $ownerId): void
    {
        $trip = Trip::where('owner_id', $ownerId)->findOrFail($tripId);

        DB::transaction(function () use ($trip) {
            // Release the vehicle associated with this trip if it was in maintenance
            if ($trip->status !== 'completed' && $trip->status !== 'settled') {
                Vehicle::where('id', $trip->vehicle_id)->update(['status' => 'active']);
            }

            // Cascade deletion for transactions and billings
            TripTransaction::where('trip_id', $trip->id)->delete();
            TripBilling::where('trip_id', $trip->id)->delete();

            $trip->delete();
        });
    }

    /**
     * Load complete trip data including the financial ledger summary.
     *
     * Returns the trip details along with categorized transactions,
     * driver wallet balance, billing summary, and profit/loss calculations.
     *
     * @param int      $tripId   The trip ID to load
     * @param int|null $driverId If provided, restricts query to this driver's trips (security for driver role)
     * @return array Associative array with trip details, ledger data, and billing summary
     */
    public function loadTripData(int $tripId, ?int $driverId = null): array
    {
        // Build the trip query with eager-loaded relationships
        $query = Trip::with(['vehicle', 'driver', 'dealer'])->where('id', $tripId);
        if ($driverId) {
            $query->where('driver_id', $driverId);
        }
        $tripDetails = $query->firstOrFail();

        // Get the driver's current wallet balance
        $wallet = Wallet::where('driver_id', $tripDetails->driver_id)->first();
        $driverWalletBalance = $wallet ? $wallet->balance : 0;

        // Fetch all transactions for this trip, categorized by type and payment mode
        $txs = TripTransaction::with('category')
            ->where('trip_id', $tripId)
            ->latest()
            ->get();

        // Categorize transactions into four ledger columns:
        // 1. Driver Expenses (paid from driver's wallet)
        $driverExp = $txs->where('transaction_type', 'expense')->where('payment_mode', 'wallet');
        // 2. Owner Expenses (paid from owner's bank or FASTag)
        $ownerExp = $txs->where('transaction_type', 'expense')->whereIn('payment_mode', ['owner_bank', 'fastag']);
        // 3. Driver Recoveries (received into driver's wallet)
        $driverRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'wallet');
        // 4. Owner Recoveries (received into owner's bank)
        $ownerRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'owner_bank');

        // Calculate ledger totals
        $sumDriverExp = $driverExp->sum('amount');
        $sumOwnerExp = $ownerExp->sum('amount');
        $sumDriverRec = $driverRec->sum('amount');
        $sumOwnerRec = $ownerRec->sum('amount');

        // Driver's net position (positive = driver owes money, negative = owner owes driver)
        $driverHisab = $sumDriverRec - $sumDriverExp;

        // Load multi-party billing data
        $tripBillings = TripBilling::where('trip_id', $tripId)->get();
        $totalPartyFreight = $tripBillings->sum('freight_amount');
        $totalPartyReceived = $tripBillings->sum('received_amount');
        $partyDues = $totalPartyFreight - $totalPartyReceived;

        // Overall profit/loss calculation
            // Overall profit/loss calculation
        $totalRevenue = $sumDriverRec + $sumOwnerRec;
        $totalExpense = $sumDriverExp + $sumOwnerExp;
        $netProfit = $totalRevenue - $totalExpense;
        return [
            'tripDetails' => $tripDetails,
            'driverWalletBalance' => $driverWalletBalance,
            'driverExp' => $driverExp,
            'ownerExp' => $ownerExp,
            'driverRec' => $driverRec,
            'ownerRec' => $ownerRec,
            'sumDriverExp' => $sumDriverExp,
            'sumOwnerExp' => $sumOwnerExp,
            'sumDriverRec' => $sumDriverRec,
            'sumOwnerRec' => $sumOwnerRec,
            'driverHisab' => $driverHisab,
            'totalRevenue' => $totalRevenue,
            'totalExpense' => $totalExpense,
            'netProfit' => $netProfit,
            'tripBillings' => $tripBillings,
            'totalPartyFreight' => $totalPartyFreight,
            'totalPartyReceived' => $totalPartyReceived,
            'partyDues' => $partyDues,
        ];
    }

    /**
     * Update a trip's lifecycle status.
     *
     * @param Trip   $trip   The trip model instance to update
     * @param string $status New status: scheduled|loaded|in_transit|unloaded|completed|settled
     * @return void
     *
     * @throws \InvalidArgumentException If the status value is not valid
     */
    public function updateStatus(Trip $trip, string $status): void
    {
        $validStatuses = ['scheduled', 'loaded', 'in_transit', 'unloaded', 'completed', 'settled'];
        if (!in_array($status, $validStatuses)) {
            throw new \InvalidArgumentException('Invalid status!');
        }

        $trip->update(['status' => $status]);
    }

    /**
     * End a trip: mark it as 'completed' and release the vehicle back to 'active'.
     *
     * @param Trip $trip The trip to end
     * @return void
     *
     * @throws \InvalidArgumentException If the trip is already completed or settled
     */
    public function endTrip(Trip $trip): void
    {
        if ($trip->status === 'completed' || $trip->status === 'settled') {
            throw new \InvalidArgumentException('Trip is already ended!');
        }

        DB::transaction(function () use ($trip) {
            // Mark the trip as completed with today's date
            $trip->update([
                'status' => 'completed',
                'end_date' => now()->format('Y-m-d'),
            ]);

            // Release the vehicle back to 'active' status so it can be assigned to new trips
            Vehicle::where('id', $trip->vehicle_id)->update(['status' => 'active']);
        });
    }

    /**
     * Get a filtered and paginated list of trips with calculated profit per trip.
     *
     * @param int         $ownerId   The fleet owner's user ID
     * @param int|null    $driverId  If set, restricts to this driver's trips only
     * @param string|null $search    Search term for trip ID, locations, or truck number
     * @param string|null $fromDate  Filter trips starting on or after this date
     * @param string|null $toDate    Filter trips starting on or before this date
     * @return LengthAwarePaginator Paginated trips with a 'calculated_profit' attribute appended
     */
    public function getFilteredTrips(int $ownerId, ?int $driverId = null, ?string $search = null, ?string $fromDate = null, ?string $toDate = null, ?string $status = null): LengthAwarePaginator
    {
        $tripQuery = Trip::with(['vehicle', 'driver', 'dealer'])->where('owner_id', $ownerId);

        // Restrict to a specific driver if applicable (security for driver role)
        if ($driverId) {
            $tripQuery->where('driver_id', $driverId);
        }

        // Apply status filter if provided (Dispatch vs History)
        if (!empty($status)) {
            $tripQuery->where('status', $status);
        }

        // Apply search filter across trip ID, locations, vehicle, driver, and dealer
        if (!empty($search)) {
            $tripQuery->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('from_location', 'like', "%{$search}%")
                    ->orWhere('to_location', 'like', "%{$search}%")
                    ->orWhereHas('vehicle', fn($v) => $v->where('truck_number', 'like', "%{$search}%"))
                    ->orWhereHas('driver', fn($d) => $d->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('dealer', fn($de) => $de->where('company_name', 'like', "%{$search}%"));
            });
        }

        // Apply date range filters on the trip start_date
        if (!empty($fromDate)) {
            $tripQuery->whereDate('start_date', '>=', $fromDate);
        }
        if (!empty($toDate)) {
            $tripQuery->whereDate('start_date', '<=', $toDate);
        }

        $trips = $tripQuery->latest()->paginate(10);

        // Calculate accurate profit for each trip (Total Freight - Total Expenses)
        foreach ($trips as $t) {
            $exp = TripTransaction::where('trip_id', $t->id)->where('transaction_type', 'expense')->sum('amount');
            $billingSum = TripTransaction::where('trip_id', $t->id)->where('transaction_type', 'recovery')->sum('amount');
            $rev = $billingSum;
            $t->calculated_profit = $rev - $exp;
        }

        return $trips;
    }

    /**
     * Generate a PDF bill/ledger document for a specific trip.
     *
     * Includes trip details, party billing entries, and all categorized
     * transactions (driver expenses, owner expenses, driver recoveries, owner recoveries).
     *
     * @param int $tripId The trip ID to generate the PDF for
     * @return \Illuminate\Http\Response Streamable PDF download response
     */
    public function generateBillPdf(int $tripId)
    {
        $trip = Trip::with(['vehicle', 'driver', 'dealer'])->findOrFail($tripId);
        $billings = TripBilling::where('trip_id', $tripId)->get();

        // Fetch and categorize all transactions for the PDF
        $txs = TripTransaction::with('category')
            ->where('trip_id', $tripId)
            ->latest()
            ->get();

        $driverExp = $txs->where('transaction_type', 'expense')->where('payment_mode', 'wallet');
        $ownerExp = $txs->where('transaction_type', 'expense')->whereIn('payment_mode', ['owner_bank', 'fastag']);
        $driverRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'wallet');
        $ownerRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'owner_bank');

        $pdf = Pdf::loadView('pdf.trip-bill', [
            'trip' => $trip,
            'billings' => $billings,
            'driverExp' => $driverExp,
            'ownerExp' => $ownerExp,
            'driverRec' => $driverRec,
            'ownerRec' => $ownerRec,
        ]);

        return $pdf->download('Trip-Ledger-T' . $trip->trip_number . '.pdf');
    }

    /**
     * Get dropdown data needed for trip creation forms.
     *
     * @param int $ownerId The fleet owner's user ID
     * @return array Associative array with 'vehicles', 'drivers', 'dealers', 'categories'
     */
    public function getFormDropdownData(int $ownerId): array
    {
        return [
            'vehicles' => Vehicle::where('owner_id', $ownerId)->where('status', 'active')->get(),
            'drivers' => User::role('driver')->where('owner_id', $ownerId)->get(),
            'dealers' => Dealer::where('owner_id', $ownerId)->get(),
            'categories' => ExpenseCategory::where('owner_id', $ownerId)->get(),
        ];
    }

    /**
     * Create a new expense category inline (from the trip management screen).
     *
     * @param string $name    Category name (stored in uppercase)
     * @param int    $ownerId The fleet owner's user ID
     * @return ExpenseCategory The newly created category
     *
     * @throws \InvalidArgumentException If a category with the same name already exists
     */
    public function createQuickCategory(string $name, int $ownerId): ExpenseCategory
    {
        $exists = ExpenseCategory::withoutGlobalScopes()
            ->where('owner_id', $ownerId)
            ->where('name', strtoupper($name))
            ->exists();

        if ($exists) {
            throw new \InvalidArgumentException('This category already exists!');
        }

        return ExpenseCategory::create([
            'owner_id' => $ownerId,
            'name' => strtoupper($name),
        ]);
    }
}
