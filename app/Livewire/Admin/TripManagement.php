<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Dealer;
use App\Models\Trip;
use App\Models\TripTransaction;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

class TripManagement extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    public $currentView = 'list'; 

    // --- CREATE TRIP INPUTS ---
    public $vehicle_id = '';
    public $driver_id = '';
    public $dealer_id = '';
    public $from_location = '';
    public $to_location = '';
    public $material_description = '';
    public $weight_tons = '';
    public $start_date = '';

    // --- MANAGE TRIP STATE ---
    public $manageTripId = null;
    public $tripDetails = null;
    public $trip_status = '';
    
    // Ledger Collections
    public $driverExp = [];
    public $ownerExp = [];
    public $driverRec = [];
    public $ownerRec = [];
    
    // Totals
    public $sumDriverExp = 0;
    public $sumOwnerExp = 0;
    public $sumDriverRec = 0;
    public $sumOwnerRec = 0;
    public $totalRevenue = 0;
    public $totalExpense = 0;
    public $netProfit = 0;

    // --- TRANSACTION MODAL STATE ---
    public $showTxModal = false;
    public $tx_type = ''; // 'expense' or 'recovery'
    public $tx_payment_mode = ''; // 'wallet' or 'owner_bank'
    public $tx_category_id = '';
    public $tx_amount = '';
    public $tx_remarks = '';

    // --- QUICK ADD CATEGORY ---
    public $showCatModal = false;
    public $new_cat_name = '';

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        
        // Auto-select driver if logged in user is a driver
        if (Auth::user()->hasRole('driver')) {
            $this->driver_id = Auth::id();
        }
    }

    public function showList() { $this->currentView = 'list'; }
    public function showCreate() { $this->currentView = 'create'; }
    
    public function showManage($tripId) 
    { 
        $this->manageTripId = $tripId;
        $this->loadTripData();
        $this->currentView = 'manage'; 
    }

    // ==========================================
    // LOAD TRIP & HISAB (SEPARATED)
    // ==========================================
    public function loadTripData()
    {
        $this->tripDetails = Trip::with(['vehicle', 'driver', 'dealer'])->findOrFail($this->manageTripId);
        $this->trip_status = $this->tripDetails->status;
        
        $txs = TripTransaction::with('category')->where('trip_id', $this->manageTripId)->latest()->get();
        
        // Separate Data
        $this->driverExp = $txs->where('transaction_type', 'expense')->where('payment_mode', 'wallet');
        $this->ownerExp = $txs->where('transaction_type', 'expense')->whereIn('payment_mode', ['owner_bank', 'fastag']);
        $this->driverRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'wallet');
        $this->ownerRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'owner_bank');

        // Calculate Sums
        $this->sumDriverExp = $this->driverExp->sum('amount');
        $this->sumOwnerExp = $this->ownerExp->sum('amount');
        $this->sumDriverRec = $this->driverRec->sum('amount');
        $this->sumOwnerRec = $this->ownerRec->sum('amount');

        // Final Profit/Loss (Advance & Freight removed from Creation, Revenue purely relies on Recovery added)
        $this->totalExpense = $this->sumDriverExp + $this->sumOwnerExp;
        $this->totalRevenue = $this->sumDriverRec + $this->sumOwnerRec;
        $this->netProfit = $this->totalRevenue - $this->totalExpense;
    }

    // ==========================================
    // CREATE NEW TRIP
    // ==========================================
    public function saveTrip()
    {
        $this->validate([
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'start_date' => 'required|date',
        ]);

        DB::transaction(function () {
            $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;

            $trip = Trip::create([
                'owner_id' => $ownerId,
                'vehicle_id' => $this->vehicle_id,
                'driver_id' => $this->driver_id,
                'dealer_id' => $this->dealer_id === '' ? null : $this->dealer_id,
                'material_description' => $this->material_description === '' ? null : $this->material_description,
                'weight_tons' => $this->weight_tons === '' ? null : $this->weight_tons,
                'from_location' => strtoupper($this->from_location),
                'to_location' => strtoupper($this->to_location),
                'party_freight_amount' => 0, // Removed from UI
                'driver_advance' => 0,       // Removed from UI
                'start_date' => $this->start_date,
                'status' => 'scheduled',
            ]);

            Vehicle::where('id', $this->vehicle_id)->update(['status' => 'maintenance']);
        });

        session()->flash('success', 'Trip created successfully!');
        $this->reset(['vehicle_id', 'dealer_id', 'from_location', 'to_location', 'material_description', 'weight_tons']);
        if (!Auth::user()->hasRole('driver')) {
            $this->driver_id = '';
        }
        $this->showList();
    }

    public function updateTripStatus()
    {
        $this->tripDetails->update(['status' => $this->trip_status]);
        session()->flash('console_success', 'Trip Status Updated!');
    }

    public function endTrip()
    {
        DB::transaction(function () {
            $this->tripDetails->update(['status' => 'completed', 'end_date' => now()->format('Y-m-d')]);
            $this->trip_status = 'completed';
            Vehicle::where('id', $this->tripDetails->vehicle_id)->update(['status' => 'active']);
        });
        session()->flash('console_success', 'Trip Ended Successfully. Vehicle is free.');
    }

    // ==========================================
    // TRANSACTION MODAL LOGIC
    // ==========================================
    public function openTxModal($type, $mode)
    {
        $this->resetValidation();
        $this->tx_type = $type;
        $this->tx_payment_mode = $mode;
        $this->tx_category_id = '';
        $this->tx_amount = '';
        $this->tx_remarks = '';
        $this->showTxModal = true;
    }

    public function saveTransaction()
    {
        $this->validate([
            'tx_amount' => 'required|numeric|min:1',
            'tx_category_id' => $this->tx_type == 'expense' ? 'required' : 'nullable',
        ]);

        DB::transaction(function () {
            TripTransaction::create([
                'trip_id' => $this->manageTripId,
                'added_by' => Auth::id(),
                'transaction_type' => $this->tx_type,
                'expense_category_id' => $this->tx_category_id === '' ? null : $this->tx_category_id,
                'amount' => $this->tx_amount,
                'payment_mode' => $this->tx_payment_mode,
                'remarks' => $this->tx_remarks,
            ]);

            // Wallet Deduct/Add logic
            if ($this->tx_payment_mode === 'wallet') {
                $wallet = Wallet::where('driver_id', $this->tripDetails->driver_id)->first();
                if ($wallet) {
                    if ($this->tx_type === 'expense') {
                        $wallet->balance -= $this->tx_amount; 
                        WalletTransaction::create(['wallet_id' => $wallet->id, 'type' => 'debit', 'amount' => $this->tx_amount, 'description' => 'Trip Exp: ' . $this->tx_remarks]);
                    } else {
                        $wallet->balance += $this->tx_amount; 
                        WalletTransaction::create(['wallet_id' => $wallet->id, 'type' => 'credit', 'amount' => $this->tx_amount, 'description' => 'Trip Rec: ' . $this->tx_remarks]);
                    }
                    $wallet->save();
                }
            }
        });

        $this->showTxModal = false;
        $this->loadTripData(); 
    }

    // ==========================================
    // QUICK ADD CATEGORY
    // ==========================================
    public function saveNewCategory()
    {
        $this->validate(['new_cat_name' => 'required|string|max:100']);
        $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;
        $cat = ExpenseCategory::create(['owner_id' => $ownerId, 'name' => strtoupper($this->new_cat_name)]);
        $this->tx_category_id = $cat->id; 
        $this->showCatModal = false;
        $this->new_cat_name = '';
    }

    public function render()
    {
        $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;

        $vehicles = Vehicle::where('owner_id', $ownerId)->where('status', 'active')->get();
        $drivers = User::role('driver')->where('owner_id', $ownerId)->get();
        $dealers = Dealer::where('owner_id', $ownerId)->get();
        $categories = ExpenseCategory::where('owner_id', $ownerId)->get();

        $trips = Trip::with(['vehicle', 'driver', 'dealer'])
                     ->where('owner_id', $ownerId)
                     ->latest()
                     ->paginate(10);

        return view('livewire.admin.trip-management', [
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'dealers' => $dealers,
            'categories' => $categories,
            'trips' => $trips,
        ]);
    }
}