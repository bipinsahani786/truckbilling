<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * UserManagementService
 *
 * Handles user administration for super-admins: listing all users,
 * blocking/unblocking accounts, and manual password resets.
 * This service only operates on non-super-admin users for security.
 */
class UserManagementService
{
    /**
     * Get a filtered and paginated list of all users (excluding super-admins).
     *
     * @param string|null $search     Search term to filter by name, email, or mobile number
     * @param string|null $roleFilter Filter by role: 'owner' or 'driver'
     * @return LengthAwarePaginator Paginated user results with roles loaded
     */
    public function getFilteredUsers(?string $search = null, ?string $roleFilter = null): LengthAwarePaginator
    {
        $query = User::with('roles')
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'super-admin');
            });

        // Apply search filter across name, email, and mobile number
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('mobile_number', 'like', '%' . $search . '%');
            });
        }

        // Apply role filter if specified
        if (!empty($roleFilter)) {
            $query->whereHas('roles', function ($q) use ($roleFilter) {
                $q->where('name', $roleFilter);
            });
        }

        return $query->latest()->paginate(15);
    }

    /**
     * Toggle a user's blocked status.
     * Blocked users will be prevented from logging in.
     *
     * @param int $userId The user ID to block/unblock
     * @return User The updated user instance
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException If user not found
     */
    public function toggleBlock(int $userId): User
    {
        $user = User::findOrFail($userId);
        $user->is_blocked = !$user->is_blocked;
        $user->save();

        return $user;
    }

    /**
     * Manually reset a user's password (used by super-admin).
     * The User model's 'hashed' cast will automatically hash the password.
     *
     * @param int    $userId      The user whose password is being reset
     * @param string $newPassword The new plaintext password to set
     * @return void
     */
    public function resetPassword(int $userId, string $newPassword): void
    {
        $user = User::findOrFail($userId);
        $user->update(['password' => $newPassword]);
    }

    /**
     * Get aggregate user statistics for the super-admin dashboard.
     *
     * @return array Associative array with total, owners, drivers, and blocked counts
     */
    public function getStats(): array
    {
        $baseQuery = User::whereDoesntHave('roles', function ($q) {
            $q->where('name', 'super-admin');
        });

        return [
            'totalUsers' => (clone $baseQuery)->count(),
            'totalOwners' => (clone $baseQuery)->whereHas('roles', fn($q) => $q->where('name', 'owner'))->count(),
            'totalDrivers' => (clone $baseQuery)->whereHas('roles', fn($q) => $q->where('name', 'driver'))->count(),
            'blockedUsers' => (clone $baseQuery)->where('is_blocked', true)->count(),
        ];
    }
}
