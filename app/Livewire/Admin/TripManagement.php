<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\TripBilling;
use App\Models\TripTransaction;
use App\Models\ExpenseCategory;
use App\Services\TripService;
use App\Services\TripBillingService;
use App\Services\TripTransactionService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

/**
 * TripManagement Livewire Component
 *
 * Manages the complete trip lifecycle UI: listing trips, creating new trips,
 * and managing an individual trip's ledger (transactions, party billing, PDF export).
 *
 * Business logic is delegated to TripService, TripBillingService, and TripTransactionService.
 * This component only handles UI state, validation, and flash messaging.
 */
class TripManagement extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    /** @var string Current view mode: 'list', 'create', or 'manage' */
    public $currentView = 'list';

    // --- Search & Filter Properties ---
    /** @var string Search query for filtering trips by ID, location, or truck number */
    public $search = '';
    /** @var string Status filter (in_transit, completed, etc) */
    public $statusFilter = '';
    /** @var string Start date filter for trip listing */
    public $filter_from_date = '';
    /** @var string End date filter for trip listing */
    public $filter_to_date = '';

    // --- Sub-list Search Properties (Manage View) ---
    public $searchTxDriver = '';
    public $searchTxOwner = '';
    public $searchRecDriver = '';
    public $searchRecOwner = '';

    // --- Create Trip Form Inputs ---
    /** @var string Selected vehicle ID for new trip */
    public $vehicle_id = '';
    /** @var string Selected driver ID for new trip */
    public $driver_id = '';
    /** @var string Selected dealer ID for new trip (optional) */
    public $dealer_id = '';
    /** @var string Starting location for new trip */
    public $from_location = '';
    /** @var string Destination location for new trip */
    public $to_location = '';
    /** @var string Trip start date */
    public $start_date = '';

    /** @var int|null ID of the trip being edited (null for new trips) */
    public $editingTripId = null;

    // --- Manage Trip State ---
    /** @var int|null Currently managed trip's ID */
    public $manageTripId = null;
    /** @var object|null Full trip details with relationships loaded */
    public $tripDetails = null;
    /** @var string Current trip status (for status update dropdown) */
    public $trip_status = '';
    /** @var float Driver's current wallet balance */
    public $driverWalletBalance = 0;
    /** @var float Net driver position (recoveries - expenses through wallet) */
    public $driverHisab = 0;

    // --- Ledger Collections (categorized transactions) ---
    /** @var \Illuminate\Support\Collection Driver-paid expenses */
    public $driverExp = [];
    /** @var \Illuminate\Support\Collection Owner-paid expenses */
    public $ownerExp = [];
    /** @var \Illuminate\Support\Collection Driver wallet recoveries */
    public $driverRec = [];
    /** @var \Illuminate\Support\Collection Owner bank recoveries */
    public $ownerRec = [];

    // --- Financial Summary Totals ---
    public $sumDriverExp = 0;
    public $sumOwnerExp = 0;
    public $sumDriverRec = 0;
    public $sumOwnerRec = 0;
    public $totalRevenue = 0;
    public $totalExpense = 0;
    public $netProfit = 0;

    // --- Multi-Party Billing Properties ---
    /** @var \Illuminate\Support\Collection All billing entries for the managed trip */
    public $tripBillings = [];
    /** @var bool Whether the party billing modal is visible */
    public $showPartyModal = false;
    /** @var int|null ID of the billing entry being edited (null for new) */
    public $editingBillingId = null;

    /** @var string Party/company name in the billing form */
    public $b_party_name = '';
    /** @var string Material description in the billing form */
    public $b_material = '';
    /** @var string Weight in tons in the billing form */
    public $b_weight = '';
    /** @var string Freight amount in the billing form */
    public $b_freight = '';
    /** @var string Received amount in the billing form */
    public $b_received = '';

    /** @var float Total freight across all billing entries */
    public $totalPartyFreight = 0;
    /** @var float Total received amount across all billing entries */
    public $totalPartyReceived = 0;
    /** @var float Outstanding dues (freight - received) */
    public $partyDues = 0;

    // --- Transaction Modal Properties ---
    /** @var bool Whether the transaction modal is visible */
    public $showTxModal = false;
    /** @var int|null ID of the transaction being edited (null for new) */
    public $editingTxId = null;
    /** @var string Transaction type: 'expense' or 'recovery' */
    public $tx_type = '';
    /** @var string Payment mode: 'wallet', 'owner_bank', or 'fastag' */
    public $tx_payment_mode = '';
    /** @var string Selected expense category ID */
    public $tx_category_id = '';
    /** @var string Transaction amount */
    public $tx_amount = '';
    /** @var string Additional remarks/notes for the transaction */
    public $tx_remarks = '';

    // --- Quick Category Modal Properties ---
    /** @var bool Whether the new category modal is visible */
    public $showCatModal = false;
    /** @var string Name for the new expense category */
    public $new_cat_name = '';

    /**
     * Initialize component with default values.
     * Sets the start date to today and auto-selects driver if logged in as driver.
     */
    public function mount()
    {
        $this->start_date = date('Y-m-d');

        // If a driver is logged in, auto-assign them to the trip
        if (Auth::user()->hasRole('driver')) {
            $this->driver_id = Auth::id();
        }
    }

    // --- Pagination Reset Hooks (triggered when filter values change) ---
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterFromDate() { $this->resetPage(); }
    public function updatedFilterToDate() { $this->resetPage(); }

    // --- View Navigation Methods ---
    public function showList() { $this->currentView = 'list'; }
    public function showCreate() 
    { 
        $this->resetForm();
        $this->currentView = 'create'; 
    }

    /**
     * Prepare the form for editing an existing trip.
     * 
     * @param int $tripId
     */
    public function showEdit($tripId)
    {
        $trip = \App\Models\Trip::findOrFail($tripId);
        $this->editingTripId = $tripId;
        $this->vehicle_id = $trip->vehicle_id;
        $this->driver_id = $trip->driver_id;
        $this->dealer_id = $trip->dealer_id;
        $this->from_location = $trip->from_location;
        $this->to_location = $trip->to_location;
        $this->start_date = $trip->start_date;
        $this->currentView = 'create'; // Reuse the create form view
    }

    /**
     * Reset form inputs to defaults.
     */
    private function resetForm()
    {
        $this->editingTripId = null;
        $this->vehicle_id = '';
        $this->driver_id = Auth::user()->hasRole('driver') ? Auth::id() : '';
        $this->dealer_id = '';
        $this->from_location = '';
        $this->to_location = '';
        $this->start_date = date('Y-m-d');
    }

    /**
     * Switch to the trip management/ledger view for a specific trip.
     *
     * @param int $tripId The trip ID to manage
     */
    public function showManage($tripId)
    {
        $this->manageTripId = $tripId;
        $this->loadTripData();
        $this->currentView = 'manage';
    }

    /**
     * Load all trip data from the service and populate component properties.
     * Called when entering the manage view and after any data modification.
     */
    public function loadTripData()
    {
        $tripService = app(TripService::class);

        // Determine driver restriction for security
        $driverId = Auth::user()->hasRole('driver') ? Auth::id() : null;
        $data = $tripService->loadTripData($this->manageTripId, $driverId);

        // Map service response to component properties
        $this->tripDetails = $data['tripDetails'];
        $this->trip_status = $this->tripDetails->status;
        $this->driverWalletBalance = $data['driverWalletBalance'];
        $this->driverExp = $data['driverExp'];
        $this->ownerExp = $data['ownerExp'];
        $this->driverRec = $data['driverRec'];
        $this->ownerRec = $data['ownerRec'];
        $this->sumDriverExp = $data['sumDriverExp'];
        $this->sumOwnerExp = $data['sumOwnerExp'];
        $this->sumDriverRec = $data['sumDriverRec'];
        $this->sumOwnerRec = $data['sumOwnerRec'];
        $this->driverHisab = $data['driverHisab'];
        $this->totalRevenue = $data['totalRevenue'];
        $this->totalExpense = $data['totalExpense'];
        $this->netProfit = $data['netProfit'];
        $this->tripBillings = $data['tripBillings'];
        $this->totalPartyFreight = $data['totalPartyFreight'];
        $this->totalPartyReceived = $data['totalPartyReceived'];
        $this->partyDues = $data['partyDues'];

        // --- Apply Sub-list Filtering ---
        if (!empty($this->searchTxDriver)) {
            $this->driverExp = $this->driverExp->filter(fn($ex) => 
                stripos($ex->category->name ?? '', $this->searchTxDriver) !== false || 
                stripos($ex->remarks ?? '', $this->searchTxDriver) !== false
            );
        }
        if (!empty($this->searchTxOwner)) {
            $this->ownerExp = $this->ownerExp->filter(fn($ex) => 
                stripos($ex->category->name ?? '', $this->searchTxOwner) !== false || 
                stripos($ex->remarks ?? '', $this->searchTxOwner) !== false
            );
        }
        if (!empty($this->searchRecDriver)) {
            $this->driverRec = $this->driverRec->filter(fn($rc) => 
                stripos($rc->remarks ?? '', $this->searchRecDriver) !== false
            );
        }
        if (!empty($this->searchRecOwner)) {
            $this->ownerRec = $this->ownerRec->filter(fn($rc) => 
                stripos($rc->remarks ?? '', $this->searchRecOwner) !== false
            );
        }
    }

    public function updatedSearchTxDriver() { $this->loadTripData(); }
    public function updatedSearchTxOwner() { $this->loadTripData(); }
    public function updatedSearchRecDriver() { $this->loadTripData(); }
    public function updatedSearchRecOwner() { $this->loadTripData(); }

    /**
     * Validate and create a new trip via the TripService.
     */
    public function saveTrip()
    {
        $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;

        $this->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver_id' => 'required|exists:users,id',
            'dealer_id' => 'nullable',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        try {
            $tripService = app(TripService::class);
            $data = [
                'vehicle_id' => $this->vehicle_id,
                'driver_id' => $this->driver_id,
                'dealer_id' => $this->dealer_id,
                'from_location' => $this->from_location,
                'to_location' => $this->to_location,
                'start_date' => $this->start_date,
            ];

            if ($this->editingTripId) {
                $tripService->updateTrip($this->editingTripId, $data, $ownerId);
                session()->flash('success', 'Trip updated successfully!');
            } else {
                $tripService->createTrip($data, $ownerId);
                session()->flash('success', 'New trip created and driver notified!');
            }

            $this->resetForm();
            $this->showList();
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    /**
     * Delete a trip after user confirmation.
     * 
     * @param int $tripId
     */
    public function deleteTrip($tripId)
    {
        $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;
        
        try {
            app(TripService::class)->deleteTrip($tripId, $ownerId);
            session()->flash('success', 'Trip deleted successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting trip: ' . $e->getMessage());
        }
    }

    /**
     * Update the current trip's status via the TripService.
     */
    public function updateTripStatus()
    {
        try {
            $tripService = app(TripService::class);
            $tripService->updateStatus($this->tripDetails, $this->trip_status);
            session()->flash('console_success', 'Status Updated!');
        } catch (\InvalidArgumentException $e) {
            session()->flash('console_error', $e->getMessage());
        }
    }

    /**
     * End the current trip: mark as completed and release the vehicle.
     */
    public function endTrip()
    {
        try {
            $tripService = app(TripService::class);
            $tripService->endTrip($this->tripDetails);
            $this->trip_status = 'completed';
            session()->flash('console_success', 'Trip Ended.');
        } catch (\InvalidArgumentException $e) {
            session()->flash('console_error', $e->getMessage());
        }
    }


    // --- Party Billing Modal Methods ---

    /**
     * Open the billing modal for creating a new billing entry.
     */
    public function openBillingModal()
    {
        $this->resetValidation();
        $this->reset(['editingBillingId', 'b_party_name', 'b_material', 'b_weight', 'b_freight', 'b_received']);
        $this->showPartyModal = true;
    }

    /**
     * Open the billing modal pre-filled with an existing billing entry for editing.
     *
     * @param int $id The billing entry ID to edit
     */
    public function editBilling($id)
    {
        $bill = TripBilling::findOrFail($id);
        $this->editingBillingId = $bill->id;
        $this->b_party_name = $bill->party_name;
        $this->b_material = $bill->material_description;
        $this->b_weight = $bill->weight_tons;
        $this->b_freight = $bill->freight_amount;
        $this->b_received = $bill->received_amount;
        $this->showPartyModal = true;
    }

    /**
     * Delete a billing entry and reload trip data.
     *
     * @param int $id The billing entry ID to delete
     */
    public function deleteBilling($id)
    {
        $billingService = app(TripBillingService::class);
        $billingService->delete($id);
        $this->loadTripData();
    }

    /**
     * Save (create or update) a billing entry via the TripBillingService.
     */
    public function saveBilling()
    {
        $this->validate(['b_freight' => 'required|numeric']);

        $billingService = app(TripBillingService::class);
        $billingService->createOrUpdate($this->manageTripId, [
            'party_name' => $this->b_party_name,
            'material_description' => $this->b_material,
            'weight_tons' => $this->b_weight,
            'freight_amount' => $this->b_freight,
            'received_amount' => $this->b_received ?: 0,
        ], $this->editingBillingId);

        $this->showPartyModal = false;
        $this->loadTripData();
    }

    // --- Transaction Modal Methods ---

    /**
     * Open the transaction modal for creating a new transaction.
     *
     * @param string $type Transaction type: 'expense' or 'recovery'
     * @param string $mode Payment mode: 'wallet', 'owner_bank', or 'fastag'
     */
    public function openTxModal($type, $mode)
    {
        $this->resetValidation();
        $this->reset(['editingTxId', 'tx_category_id', 'tx_amount', 'tx_remarks']);
        $this->tx_type = $type;
        $this->tx_payment_mode = $mode;
        $this->showTxModal = true;
    }

    /**
     * Open the transaction modal pre-filled with an existing transaction for editing.
     *
     * @param int $id The transaction ID to edit
     */
    public function editTx($id)
    {
        $tx = TripTransaction::findOrFail($id);
        $this->editingTxId = $tx->id;
        $this->tx_type = $tx->transaction_type;
        $this->tx_payment_mode = $tx->payment_mode;
        $this->tx_category_id = $tx->expense_category_id;
        $this->tx_amount = $tx->amount;
        $this->tx_remarks = $tx->remarks;
        $this->showTxModal = true;
    }

    /**
     * Delete a transaction and reverse its wallet impact.
     *
     * @param int $id The transaction ID to delete
     */
    public function deleteTx($id)
    {
        $txService = app(TripTransactionService::class);
        $txService->delete($id, $this->tripDetails->driver_id, $this->manageTripId);
        $this->loadTripData();
    }

    /**
     * Save (create or update) a transaction via the TripTransactionService.
     * Handles wallet impact automatically through the service.
     */
    public function saveTransaction()
    {
        $this->validate(['tx_amount' => 'required|numeric|min:1']);

        $txService = app(TripTransactionService::class);
        $txService->createOrUpdate([
            'trip_id' => $this->manageTripId,
            'added_by' => Auth::id(),
            'transaction_type' => $this->tx_type,
            'expense_category_id' => $this->tx_category_id,
            'amount' => $this->tx_amount,
            'payment_mode' => $this->tx_payment_mode,
            'remarks' => $this->tx_remarks,
        ], $this->editingTxId, $this->tripDetails->driver_id, $this->manageTripId);

        $this->showTxModal = false;
        $this->loadTripData();
    }

    /**
     * Create a new expense category inline (quick-add from trip management screen).
     */
    public function saveNewCategory()
    {
        $this->validate(['new_cat_name' => 'required|string|max:255']);
        $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;

        try {
            $tripService = app(TripService::class);
            $cat = $tripService->createQuickCategory($this->new_cat_name, $ownerId);
            $this->tx_category_id = $cat->id;
            $this->showCatModal = false;
            $this->new_cat_name = '';
        } catch (\InvalidArgumentException $e) {
            $this->addError('new_cat_name', $e->getMessage());
        }
    }

    /**
     * Render the component view with all required data for the current view mode.
     */
    public function render()
    {
        $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;

        $tripService = app(TripService::class);

        // Get dropdown data for the create form
        $dropdowns = $tripService->getFormDropdownData($ownerId);

        // Determine driver restriction for trip listing
        $driverId = Auth::user()->hasRole('driver') ? Auth::id() : null;

        // Get filtered and paginated trip list with calculated profit
        $trips = $tripService->getFilteredTrips(
            $ownerId,
            $driverId,
            $this->search,
            $this->filter_from_date,
            $this->filter_to_date,
            $this->statusFilter
        );

        return view('livewire.admin.trip-management', [
            'vehicles' => $dropdowns['vehicles'],
            'drivers' => $dropdowns['drivers'],
            'dealers' => $dropdowns['dealers'],
            'categories' => $dropdowns['categories'],
            'trips' => $trips,
        ]);
    }
}