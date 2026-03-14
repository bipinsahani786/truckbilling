<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;

class DriverManagement extends Component
{
    use WithPagination;

    #[Layout('layouts.app')] // Apply the modern layout

    // --- FILTERS ---
    public $search = '';
    public $statusFilter = '';

    // --- DRIVER FORM INPUTS ---
    public $driver_id;
    public $name, $mobile_number, $email, $password;
    public $address, $blood_group, $aadhar_number, $license_number;
    public $isEditMode = false;

    // --- WALLET MODAL INPUTS ---
    public $add_amount;
    public $add_remarks;
    public $selectedWalletId;
    public $selectedDriverName = '';
    
    // --- UI STATE ---
    public $showAddMoneyModal = false;
    public $showTxDrawer = false;
    public $transactionHistory = [];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    // --- SAVE / UPDATE DRIVER ---
    public function saveDriver()
    {
        if ($this->isEditMode) {
            $this->validate([
                'name' => 'required|string|max:255',
                'mobile_number' => 'required|string|unique:users,mobile_number,' . $this->driver_id,
                'email' => 'nullable|email|unique:users,email,' . $this->driver_id,
                'aadhar_number' => 'nullable|string|unique:users,aadhar_number,' . $this->driver_id,
                'license_number' => 'nullable|string|unique:users,license_number,' . $this->driver_id,
            ]);

            $user = User::findOrFail($this->driver_id);
            $user->update([
                'name' => $this->name,
                'mobile_number' => $this->mobile_number,
                'email' => $this->email,
                'address' => $this->address,
                'blood_group' => $this->blood_group,
                'aadhar_number' => $this->aadhar_number,
                'license_number' => $this->license_number,
            ]);

            if (!empty($this->password)) {
                $user->update(['password' => Hash::make($this->password)]);
            }

            session()->flash('success', 'Driver Details Updated!');
        } else {
            $this->validate([
                'name' => 'required|string|max:255',
                'mobile_number' => 'required|string|unique:users,mobile_number',
                'password' => 'required|string|min:6',
                'aadhar_number' => 'nullable|string|unique:users,aadhar_number',
                'license_number' => 'nullable|string|unique:users,license_number',
            ]);

            // Create Driver
            $driver = User::create([
                'owner_id' => Auth::id(),
                'name' => $this->name,
                'mobile_number' => $this->mobile_number,
                'email' => $this->email ?: $this->mobile_number . '@driver.zytrixon.com',
                'password' => Hash::make($this->password),
                'address' => $this->address,
                'blood_group' => $this->blood_group,
                'aadhar_number' => $this->aadhar_number,
                'license_number' => $this->license_number,
            ]);

            // Assign Spatie Role
            $driver->assignRole('driver');

            // Auto-create Wallet
            Wallet::create([
                'owner_id' => Auth::id(),
                'driver_id' => $driver->id,
                'balance' => 0.00,
                'status' => 'active',
            ]);

            session()->flash('success', 'Driver Added & Wallet Created!');
        }

        $this->resetForm();
    }

    public function editDriver($userId)
    {
        $user = User::findOrFail($userId);
        $this->driver_id = $user->id;
        $this->name = $user->name;
        $this->mobile_number = $user->mobile_number;
        $this->email = $user->email;
        $this->address = $user->address;
        $this->blood_group = $user->blood_group;
        $this->aadhar_number = $user->aadhar_number;
        $this->license_number = $user->license_number;
        
        $this->isEditMode = true;
    }

    public function toggleWalletStatus($walletId)
    {
        $wallet = Wallet::findOrFail($walletId);
        $wallet->status = $wallet->status === 'active' ? 'frozen' : 'active';
        $wallet->save();
        
        session()->flash('success', 'Driver Wallet Status Changed!');
    }

    public function resetForm()
    {
        $this->reset([
            'driver_id', 'name', 'mobile_number', 'email', 'password', 
            'address', 'blood_group', 'aadhar_number', 'license_number', 'isEditMode'
        ]);
        $this->resetValidation();
    }

    // --- WALLET METHODS ---
    public function openAddMoneyModal($walletId, $driverName)
    {
        $this->resetValidation();
        $this->add_amount = '';
        $this->add_remarks = '';
        $this->selectedWalletId = $walletId;
        $this->selectedDriverName = $driverName;
        $this->showAddMoneyModal = true;
    }

    public function addFunds()
    {
        $this->validate([
            'add_amount' => 'required|numeric|min:1',
            'add_remarks' => 'required|string|max:255',
        ]);

        DB::transaction(function () {
            $wallet = Wallet::findOrFail($this->selectedWalletId);
            
            // 1. Update Balance
            $wallet->balance += $this->add_amount;
            $wallet->save();

            // 2. Add Transaction Record
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $this->add_amount,
                'description' => $this->add_remarks,
            ]);
        });

        $this->showAddMoneyModal = false;
        session()->flash('success', '₹' . $this->add_amount . ' added to ' . $this->selectedDriverName . '\'s wallet!');
    }

    public function viewTransactions($walletId, $driverName)
    {
        $this->selectedDriverName = $driverName;
        $this->transactionHistory = WalletTransaction::where('wallet_id', $walletId)
                                        ->latest()
                                        ->get();
        $this->showTxDrawer = true;
    }

    public function closeModals()
    {
        $this->showAddMoneyModal = false;
        $this->showTxDrawer = false;
    }

    public function render()
    {
        $query = Wallet::with('driver')->where('owner_id', Auth::id());

        if (!empty($this->search)) {
            $query->whereHas('driver', function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('mobile_number', 'like', '%' . $this->search . '%')
                  ->orWhere('license_number', 'like', '%' . $this->search . '%');
            });
        }

        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $wallets = $query->latest()->paginate(10);
        
        $totalBalance = Wallet::where('owner_id', Auth::id())
                              ->where('status', 'active')
                              ->sum('balance');

        return view('livewire.admin.driver-management', [
            'wallets' => $wallets,
            'totalBalance' => $totalBalance
        ]);
    }
}