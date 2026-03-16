<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Services\UserManagementService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

/**
 * UserManagement Livewire Component
 *
 * Super-admin only. Provides a user directory where the super-admin can:
 * - View all owners and drivers with search and role filtering
 * - Block or unblock user accounts (blocked users cannot login)
 * - Manually reset a user's password
 *
 * Business logic is delegated to UserManagementService.
 */
class UserManagement extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]

    // --- Search & Filter Properties ---
    /** @var string Search query for filtering by name, email, or mobile */
    public $search = '';
    /** @var string Filter by role: '' (all), 'owner', or 'driver' */
    public $roleFilter = '';

    // --- Password Reset Modal Properties ---
    /** @var bool Whether the password reset modal is visible */
    public $showResetModal = false;
    /** @var int|null User ID whose password is being reset */
    public $resetUserId = null;
    /** @var string Name of the user (displayed in the modal) */
    public $resetUserName = '';
    /** @var string New password to set */
    public $newPassword = '';
    /** @var string Password confirmation */
    public $newPasswordConfirmation = '';

    /** Reset pagination when search query changes */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    /** Reset pagination when role filter changes */
    public function updatedRoleFilter()
    {
        $this->resetPage();
    }

    /**
     * Toggle a user's blocked status via the UserManagementService.
     *
     * @param int $userId The user ID to block/unblock
     */
    public function toggleBlock($userId)
    {
        $service = app(UserManagementService::class);
        $user = $service->toggleBlock($userId);

        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        session()->flash('success', "User {$user->name} has been {$status}.");
    }

    /**
     * Open the password reset modal for a specific user.
     *
     * @param int    $userId   The user ID to reset password for
     * @param string $userName The user's name (displayed in the modal)
     */
    public function openResetModal($userId, $userName)
    {
        $this->resetValidation();
        $this->resetUserId = $userId;
        $this->resetUserName = $userName;
        $this->newPassword = '';
        $this->newPasswordConfirmation = '';
        $this->showResetModal = true;
    }

    /**
     * Reset the selected user's password via the UserManagementService.
     */
    public function resetUserPassword()
    {
        $this->validate([
            'newPassword' => 'required|string|min:6|same:newPasswordConfirmation',
        ], [
            'newPassword.same' => 'Passwords do not match.',
        ]);

        $service = app(UserManagementService::class);
        $service->resetPassword($this->resetUserId, $this->newPassword);

        $this->showResetModal = false;
        session()->flash('success', "Password for {$this->resetUserName} has been reset successfully.");
    }

    /**
     * Close all modals.
     */
    public function closeModals()
    {
        $this->showResetModal = false;
    }

    /**
     * Render the component view with paginated user list and stats.
     */
    public function render()
    {
        $service = app(UserManagementService::class);

        $users = $service->getFilteredUsers($this->search, $this->roleFilter);
        $stats = $service->getStats();

        return view('livewire.admin.user-management', [
            'users' => $users,
            'stats' => $stats,
        ]);
    }
}
