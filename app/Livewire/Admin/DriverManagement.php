<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Wallet;
use App\Services\DriverService;
use App\Services\WalletService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

/**
 * DriverManagement Livewire Component
 *
 * Manages the driver listing, registration, profile editing, wallet
 * operations (add funds, view transactions, toggle freeze/active).
 *
 * Business logic is delegated to DriverService and WalletService.
 * This component only handles UI state, validation, and flash messaging.
 */
class DriverManagement extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    // --- Search & Filter Properties ---
    /** @var string Search query for filtering by name, phone, or license */
    public $search = '';
    /** @var string Filter by wallet status: 'active' or 'frozen' */
    public $statusFilter = '';

    // --- Driver Form Properties ---
    /** @var int|null Driver's user ID (set during edit mode) */
    public $driver_id;
    /** @var string Driver's full name */
    public $name;
    /** @var string Driver's 10-digit mobile number */
    public $mobile_number;
    /** @var string|null Driver's email address */
    public $email;
    /** @var string|null Password (required for create, optional for edit) */
    public $password;
    /** @var string|null Driver's residential address */
    public $address;
    /** @var string|null Driver's blood group */
    public $blood_group;
    /** @var string|null Driver's 12-digit Aadhaar number */
    public $aadhar_number;
    /** @var string|null Driver's license number */
    public $license_number;
    /** @var bool Whether the form is in edit mode */
    public $isEditMode = false;

    // --- Wallet Modal Properties ---
    /** @var string Amount to add to the driver's wallet */
    public $add_amount;
    /** @var string Remarks/reason for adding funds */
    public $add_remarks;
    /** @var int|null Selected wallet ID for fund addition */
    public $selectedWalletId;
    /** @var string Name of the driver whose wallet is selected */
    public $selectedDriverName = '';

    // --- UI State Properties ---
    /** @var bool Whether the add-money modal is visible */
    public $showAddMoneyModal = false;
    /** @var bool Whether the transaction history drawer is visible */
    public $showTxDrawer = false;
    /** @var array Transaction history records for the selected wallet */
    public $transactionHistory = [];

    /** Reset pagination when search query changes */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /** Reset pagination when status filter changes */
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    /**
     * Save a new driver or update an existing driver's details.
     *
     * For new drivers: creates the user, assigns 'driver' role, and auto-creates a wallet.
     * For existing drivers: updates profile details and optionally the password.
     */
    public function saveDriver()
    {
        if ($this->isEditMode) {
            // Validate with unique constraints excluding the current driver
            $this->validate([
                'name' => 'required|string|max:255',
                'mobile_number' => 'required|digits:10|unique:users,mobile_number,' . $this->driver_id,
                'email' => 'nullable|email|unique:users,email,' . $this->driver_id,
                'aadhar_number' => 'nullable|digits:12|unique:users,aadhar_number,' . $this->driver_id,
                'license_number' => 'nullable|string|max:20|unique:users,license_number,' . $this->driver_id,
            ]);

            $driverService = app(DriverService::class);
            $driverService->updateDriver($this->driver_id, [
                'name' => $this->name,
                'mobile_number' => $this->mobile_number,
                'email' => $this->email,
                'password' => $this->password,
                'address' => $this->address,
                'blood_group' => $this->blood_group,
                'aadhar_number' => $this->aadhar_number,
                'license_number' => $this->license_number,
            ]);

            session()->flash('success', 'Driver Details Updated!');
        } else {
            // Validate all required fields for new driver registration
            $this->validate([
                'name' => 'required|string|max:255',
                'mobile_number' => 'required|digits:10|unique:users,mobile_number',
                'email' => 'nullable|email|unique:users,email',
                'password' => 'required|string|min:6',
                'aadhar_number' => 'nullable|digits:12|unique:users,aadhar_number',
                'license_number' => 'nullable|string|max:20|unique:users,license_number',
            ]);

            $driverService = app(DriverService::class);
            $driverService->createDriver([
                'name' => $this->name,
                'mobile_number' => $this->mobile_number,
                'email' => $this->email,
                'password' => $this->password,
                'address' => $this->address,
                'blood_group' => $this->blood_group,
                'aadhar_number' => $this->aadhar_number,
                'license_number' => $this->license_number,
            ], Auth::id());

            session()->flash('success', 'Driver Added & Wallet Created!');
        }

        $this->resetForm();
    }

    /**
     * Populate the form with an existing driver's data for editing.
     *
     * @param int $userId The driver's user ID to edit
     */
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

    /**
     * Toggle a driver's wallet between 'active' and 'frozen' status.
     *
     * @param int $walletId The wallet ID to toggle
     */
    public function toggleWalletStatus($walletId)
    {
        $walletService = app(WalletService::class);
        $walletService->toggleStatus($walletId);
        session()->flash('success', 'Driver Wallet Status Changed!');
    }

    /**
     * Reset the driver form to its initial state.
     */
    public function resetForm()
    {
        $this->reset([
            'driver_id', 'name', 'mobile_number', 'email', 'password',
            'address', 'blood_group', 'aadhar_number', 'license_number', 'isEditMode',
        ]);
        $this->resetValidation();
    }

    /**
     * Open the modal to add funds to a driver's wallet.
     *
     * @param int    $walletId   The wallet to add funds to
     * @param string $driverName The driver's name (displayed in the modal)
     */
    public function openAddMoneyModal($walletId, $driverName)
    {
        $this->resetValidation();
        $this->add_amount = '';
        $this->add_remarks = '';
        $this->selectedWalletId = $walletId;
        $this->selectedDriverName = $driverName;
        $this->showAddMoneyModal = true;
    }

    /**
     * Add funds to the selected driver's wallet via the WalletService.
     */
    public function addFunds()
    {
        $this->validate([
            'add_amount' => 'required|numeric|min:1',
            'add_remarks' => 'required|string|max:255',
        ]);

        $walletService = app(WalletService::class);
        $walletService->addFunds($this->selectedWalletId, $this->add_amount, $this->add_remarks);

        $this->showAddMoneyModal = false;
        session()->flash('success', '₹' . $this->add_amount . ' added to ' . $this->selectedDriverName . '\'s wallet!');
    }

    /**
     * Open the transaction history drawer for a specific wallet.
     *
     * @param int    $walletId   The wallet to view history for
     * @param string $driverName The driver's name (displayed in the drawer header)
     */
    public function viewTransactions($walletId, $driverName)
    {
        $walletService = app(WalletService::class);
        $this->selectedDriverName = $driverName;
        $this->transactionHistory = $walletService->getTransactionHistory($walletId);
        $this->showTxDrawer = true;
    }

    /**
     * Close all open modals and drawers.
     */
    public function closeModals()
    {
        $this->showAddMoneyModal = false;
        $this->showTxDrawer = false;
    }

    /**
     * Render the component view with paginated wallet/driver list and total balance.
     */
    public function render()
    {
        $query = Wallet::with('driver')->where('owner_id', Auth::id());

        // Apply search filter across driver name, phone, and license number
        if (!empty($this->search)) {
            $query->whereHas('driver', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('mobile_number', 'like', '%' . $this->search . '%')
                  ->orWhere('license_number', 'like', '%' . $this->search . '%');
            });
        }

        // Apply wallet status filter
        if (!empty($this->statusFilter)) {
            $query->where('status', $this->statusFilter);
        }

        $wallets = $query->latest()->paginate(10);

        // Calculate total active wallet balance for the summary card
        $totalBalance = Wallet::where('owner_id', Auth::id())
            ->where('status', 'active')
            ->sum('balance');

        return view('livewire.admin.driver-management', [
            'wallets' => $wallets,
            'totalBalance' => $totalBalance,
        ]);
    }
}