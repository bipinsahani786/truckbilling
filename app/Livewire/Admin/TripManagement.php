<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Dealer;
use App\Models\Trip;
use App\Models\TripTransaction;
use App\Models\TripBilling;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\ExpenseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf; // PDF PACKAGE
use Livewire\Attributes\Layout;

class TripManagement extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    public $currentView = 'list'; 
    
    // --- SEARCH & FILTER ---
    public $search = '';
    public $filter_from_date = '';
    public $filter_to_date = '';

    // --- CREATE TRIP INPUTS ---
    public $vehicle_id = '';
    public $driver_id = '';
    public $dealer_id = '';
    public $from_location = '';
    public $to_location = '';
    public $start_date = '';

    // --- MANAGE TRIP STATE ---
    public $manageTripId = null;
    public $tripDetails = null;
    public $trip_status = '';
    public $driverWalletBalance = 0; 
    public $driverHisab = 0; 
    
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

    // --- MULTIPLE INDEPENDENT PARTY BILLING ---
    public $tripBillings = [];
    public $showPartyModal = false;
    public $editingBillingId = null;
    
    public $b_party_name = '';
    public $b_material = '';
    public $b_weight = '';
    public $b_freight = '';
    public $b_received = '';

    public $totalPartyFreight = 0;
    public $totalPartyReceived = 0; 
    public $partyDues = 0; 

    // --- TRANSACTION MODAL (Add/Edit) ---
    public $showTxModal = false;
    public $editingTxId = null;
    public $tx_type = ''; 
    public $tx_payment_mode = ''; 
    public $tx_category_id = '';
    public $tx_amount = '';
    public $tx_remarks = '';

    public $showCatModal = false;
    public $new_cat_name = '';

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        if (Auth::user()->hasRole('driver')) {
            $this->driver_id = Auth::id();
        }
    }

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterFromDate() { $this->resetPage(); }
    public function updatedFilterToDate() { $this->resetPage(); }

    public function showList() { $this->currentView = 'list'; }
    public function showCreate() { $this->currentView = 'create'; }
    
    public function showManage($tripId) 
    { 
        $this->manageTripId = $tripId;
        $this->loadTripData();
        $this->currentView = 'manage'; 
    }

    public function loadTripData()
    {
        $query = Trip::with(['vehicle', 'driver', 'dealer'])->where('id', $this->manageTripId);
        if (Auth::user()->hasRole('driver')) {
            $query->where('driver_id', Auth::id());
        }
        $this->tripDetails = $query->firstOrFail();
        $this->trip_status = $this->tripDetails->status;
        
        $wallet = Wallet::where('driver_id', $this->tripDetails->driver_id)->first();
        $this->driverWalletBalance = $wallet ? $wallet->balance : 0;

        $txs = TripTransaction::with('category')->where('trip_id', $this->manageTripId)->latest()->get();
        
        $this->driverExp = $txs->where('transaction_type', 'expense')->where('payment_mode', 'wallet');
        $this->ownerExp = $txs->where('transaction_type', 'expense')->whereIn('payment_mode', ['owner_bank', 'fastag']);
        $this->driverRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'wallet');
        $this->ownerRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'owner_bank');

        $this->sumDriverExp = $this->driverExp->sum('amount');
        $this->sumOwnerExp = $this->ownerExp->sum('amount');
        $this->sumDriverRec = $this->driverRec->sum('amount');
        $this->sumOwnerRec = $this->ownerRec->sum('amount');

        $this->driverHisab = $this->sumDriverRec - $this->sumDriverExp;

        $this->totalRevenue = $this->sumDriverRec + $this->sumOwnerRec;
        $this->totalExpense = $this->sumDriverExp + $this->sumOwnerExp;
        $this->netProfit = $this->totalRevenue - $this->totalExpense; 

        $this->tripBillings = TripBilling::where('trip_id', $this->manageTripId)->get();
        $this->totalPartyFreight = $this->tripBillings->sum('freight_amount');
        $this->totalPartyReceived = $this->tripBillings->sum('received_amount');
        $this->partyDues = $this->totalPartyFreight - $this->totalPartyReceived;
    }

    public function saveTrip()
    {
        $this->validate([
            'vehicle_id' => 'required',
            'driver_id' => 'required',
            'from_location' => 'required|string',
            'to_location' => 'required|string',
        ]);

        DB::transaction(function () {
            $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;

            Trip::create([
                'owner_id' => $ownerId,
                'vehicle_id' => $this->vehicle_id,
                'driver_id' => $this->driver_id,
                'dealer_id' => $this->dealer_id === '' ? null : $this->dealer_id,
                'from_location' => strtoupper($this->from_location),
                'to_location' => strtoupper($this->to_location),
                'start_date' => $this->start_date,
                'status' => 'in_transit',
            ]);

            Vehicle::where('id', $this->vehicle_id)->update(['status' => 'maintenance']);
        });

        session()->flash('success', 'Trip created successfully!');
        $this->reset(['vehicle_id', 'dealer_id', 'from_location', 'to_location']);
        $this->showList();
    }

    public function updateTripStatus() { $this->tripDetails->update(['status' => $this->trip_status]); session()->flash('console_success', 'Status Updated!'); }

    public function endTrip()
    {
        DB::transaction(function () {
            $this->tripDetails->update(['status' => 'completed', 'end_date' => now()->format('Y-m-d')]);
            $this->trip_status = 'completed';
            Vehicle::where('id', $this->tripDetails->vehicle_id)->update(['status' => 'active']);
        });
        session()->flash('console_success', 'Trip Ended.');
    }

    // --- PDF GENERATION LOGIC ---
   // --- PDF GENERATION LOGIC ---
    public function downloadBill($tripId)
    {
        $trip = Trip::with(['vehicle', 'driver', 'dealer'])->findOrFail($tripId);
        $billings = TripBilling::where('trip_id', $tripId)->get();

        // Saare transactions fetch karo PDF ke liye
        $txs = TripTransaction::with('category')->where('trip_id', $tripId)->latest()->get();
        
        $driverExp = $txs->where('transaction_type', 'expense')->where('payment_mode', 'wallet');
        $ownerExp = $txs->where('transaction_type', 'expense')->whereIn('payment_mode', ['owner_bank', 'fastag']);
        $driverRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'wallet');
        $ownerRec = $txs->where('transaction_type', 'recovery')->where('payment_mode', 'owner_bank');

        // Note: Humne yahan Driver Wallet fetch nahi kiya hai kyunki wo PDF me nahi dikhana hai.

        $pdf = Pdf::loadView('pdf.trip-bill', [
            'trip' => $trip,
            'billings' => $billings,
            'driverExp' => $driverExp,
            'ownerExp' => $ownerExp,
            'driverRec' => $driverRec,
            'ownerRec' => $ownerRec,
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Trip-Ledger-T' . $trip->id . '.pdf');
    }
    // --- OTHER MODAL LOGICS (Unchanged) ---
    public function openBillingModal() { $this->resetValidation(); $this->reset(['editingBillingId', 'b_party_name', 'b_material', 'b_weight', 'b_freight', 'b_received']); $this->showPartyModal = true; }
    public function editBilling($id) { $bill = TripBilling::findOrFail($id); $this->editingBillingId = $bill->id; $this->b_party_name = $bill->party_name; $this->b_material = $bill->material_description; $this->b_weight = $bill->weight_tons; $this->b_freight = $bill->freight_amount; $this->b_received = $bill->received_amount; $this->showPartyModal = true; }
    public function deleteBilling($id) { TripBilling::findOrFail($id)->delete(); $this->loadTripData(); }
    
    public function saveBilling()
    {
        $this->validate(['b_freight' => 'required|numeric']);
        if ($this->editingBillingId) {
            TripBilling::findOrFail($this->editingBillingId)->update(['party_name' => $this->b_party_name, 'material_description' => $this->b_material, 'weight_tons' => $this->b_weight, 'freight_amount' => $this->b_freight, 'received_amount' => $this->b_received ?: 0]);
        } else {
            TripBilling::create(['trip_id' => $this->manageTripId, 'party_name' => $this->b_party_name, 'material_description' => $this->b_material, 'weight_tons' => $this->b_weight, 'freight_amount' => $this->b_freight, 'received_amount' => $this->b_received ?: 0]);
        }
        $this->showPartyModal = false; $this->loadTripData();
    }

    public function openTxModal($type, $mode) { $this->resetValidation(); $this->reset(['editingTxId', 'tx_category_id', 'tx_amount', 'tx_remarks']); $this->tx_type = $type; $this->tx_payment_mode = $mode; $this->showTxModal = true; }
    public function editTx($id) { $tx = TripTransaction::findOrFail($id); $this->editingTxId = $tx->id; $this->tx_type = $tx->transaction_type; $this->tx_payment_mode = $tx->payment_mode; $this->tx_category_id = $tx->expense_category_id; $this->tx_amount = $tx->amount; $this->tx_remarks = $tx->remarks; $this->showTxModal = true; }
    public function deleteTx($id) { DB::transaction(function () use ($id) { $tx = TripTransaction::findOrFail($id); $this->reverseWalletImpact($tx); $tx->delete(); }); $this->loadTripData(); }

    public function saveTransaction()
    {
        $this->validate(['tx_amount' => 'required|numeric|min:1']);
        DB::transaction(function () {
            if ($this->editingTxId) {
                $tx = TripTransaction::findOrFail($this->editingTxId); $this->reverseWalletImpact($tx); 
                $tx->update(['expense_category_id' => $this->tx_category_id === '' ? null : $this->tx_category_id, 'amount' => $this->tx_amount, 'remarks' => $this->tx_remarks]); $this->applyWalletImpact($tx); 
            } else {
                $tx = TripTransaction::create(['trip_id' => $this->manageTripId, 'added_by' => Auth::id(), 'transaction_type' => $this->tx_type, 'expense_category_id' => $this->tx_category_id === '' ? null : $this->tx_category_id, 'amount' => $this->tx_amount, 'payment_mode' => $this->tx_payment_mode, 'remarks' => $this->tx_remarks]); $this->applyWalletImpact($tx);
            }
        });
        $this->showTxModal = false; $this->loadTripData(); 
    }

    private function reverseWalletImpact($tx) { if ($tx->payment_mode === 'wallet') { $wallet = Wallet::where('driver_id', $this->tripDetails->driver_id)->first(); if ($wallet) { if ($tx->transaction_type === 'expense') $wallet->balance += $tx->amount; else $wallet->balance -= $tx->amount; $wallet->save(); } } }
    private function applyWalletImpact($tx) { if ($tx->payment_mode === 'wallet') { $wallet = Wallet::where('driver_id', $this->tripDetails->driver_id)->first(); if ($wallet) { if ($tx->transaction_type === 'expense') { $wallet->balance -= $tx->amount; WalletTransaction::create(['wallet_id' => $wallet->id, 'type' => 'debit', 'amount' => $tx->amount, 'description' => 'Trip Exp T-' . $this->manageTripId]); } else { $wallet->balance += $tx->amount; WalletTransaction::create(['wallet_id' => $wallet->id, 'type' => 'credit', 'amount' => $tx->amount, 'description' => 'Trip Rec T-' . $this->manageTripId]); } $wallet->save(); } } }

    public function saveNewCategory() { $this->validate(['new_cat_name' => 'required|string']); $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id; $cat = ExpenseCategory::create(['owner_id' => $ownerId, 'name' => strtoupper($this->new_cat_name)]); $this->tx_category_id = $cat->id; $this->showCatModal = false; $this->new_cat_name = ''; }

    public function render()
    {
        $ownerId = Auth::user()->hasRole('owner') ? Auth::id() : User::find(Auth::id())->owner_id;

        $vehicles = Vehicle::where('owner_id', $ownerId)->where('status', 'active')->get();
        $drivers = User::role('driver')->where('owner_id', $ownerId)->get();
        $dealers = Dealer::where('owner_id', $ownerId)->get();
        $categories = ExpenseCategory::where('owner_id', $ownerId)->get();

        $tripQuery = Trip::with(['vehicle', 'driver', 'dealer'])->where('owner_id', $ownerId);
        
        if (Auth::user()->hasRole('driver')) {
            $tripQuery->where('driver_id', Auth::id());
        }

        // --- SEARCH LOGIC ---
        if (!empty($this->search)) {
            $tripQuery->where(function($q) {
                $q->where('id', 'like', "%{$this->search}%")
                  ->orWhere('from_location', 'like', "%{$this->search}%")
                  ->orWhere('to_location', 'like', "%{$this->search}%")
                  ->orWhereHas('vehicle', fn($v) => $v->where('truck_number', 'like', "%{$this->search}%"));
            });
        }

        // --- DATE FILTER LOGIC ---
        if (!empty($this->filter_from_date)) {
            $tripQuery->whereDate('start_date', '>=', $this->filter_from_date);
        }
        if (!empty($this->filter_to_date)) {
            $tripQuery->whereDate('start_date', '<=', $this->filter_to_date);
        }

        $trips = $tripQuery->latest()->paginate(10);

        foreach ($trips as $t) {
            $exp = TripTransaction::where('trip_id', $t->id)->where('transaction_type', 'expense')->sum('amount');
            $rec = TripTransaction::where('trip_id', $t->id)->where('transaction_type', 'recovery')->sum('amount');
            $t->calculated_profit = $rec - $exp;
        }

        return view('livewire.admin.trip-management', [
            'vehicles' => $vehicles,
            'drivers' => $drivers,
            'dealers' => $dealers,
            'categories' => $categories,
            'trips' => $trips,
        ]);
    }
}