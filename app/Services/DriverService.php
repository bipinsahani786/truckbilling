<?php

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

/**
 * DriverService
 *
 * Handles all driver-related business logic including creating new drivers
 * (with automatic wallet creation and role assignment), and updating
 * driver profile details.
 */
class DriverService
{
    /**
     * @var WalletService Injected wallet service for wallet creation
     */
    protected WalletService $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Create a new driver under a fleet owner.
     *
     * This method performs three operations in a single transaction:
     * 1. Creates the user record with the 'driver' role
     * 2. Assigns the Spatie 'driver' role for permission management
     * 3. Automatically creates a wallet for the driver (starting balance = 0)
     *
     * If no email is provided, a default email is generated using the mobile number.
     *
     * @param array $data    Driver details (name, mobile_number, email, password, etc.)
     * @param int   $ownerId The fleet owner's user ID who is registering this driver
     * @return User The newly created driver user instance
     */
    public function createDriver(array $data, int $ownerId): User
    {
        $driver = null;

        DB::transaction(function () use ($data, $ownerId, &$driver) {
            // Create the user record (password is auto-hashed by User model's 'hashed' cast)
            $driver = User::create([
                'owner_id' => $ownerId,
                'name' => $data['name'],
                'mobile_number' => $data['mobile_number'],
                'email' => $data['email'] ?: $data['mobile_number'] . '@driver.zytrixon.com',
                'password' => $data['password'],
                'address' => $data['address'] ?? null,
                'blood_group' => $data['blood_group'] ?? null,
                'aadhar_number' => $data['aadhar_number'] ?? null,
                'license_number' => $data['license_number'] ?? null,
            ]);

            // Assign the 'driver' role via Spatie for role-based access control
            $driver->assignRole('driver');

            // Create an associated wallet with zero starting balance
            $this->walletService->createWallet($ownerId, $driver->id);
        });

        return $driver;
    }

    /**
     * Update an existing driver's profile information.
     *
     * Note: Password is only updated if a non-empty value is provided.
     * The User model's 'hashed' cast automatically handles password hashing.
     *
     * @param int   $driverId The driver's user ID to update
     * @param array $data     Updated driver details
     * @return User The updated driver user instance
     */
    public function updateDriver(int $driverId, array $data): User
    {
        $user = User::findOrFail($driverId);

        $user->update([
            'name' => $data['name'],
            'mobile_number' => $data['mobile_number'],
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'blood_group' => $data['blood_group'] ?? null,
            'aadhar_number' => $data['aadhar_number'] ?? null,
            'license_number' => $data['license_number'] ?? null,
        ]);

        // Only update password if a new one was provided
        if (!empty($data['password'])) {
            $user->update(['password' => $data['password']]);
        }

        return $user;
    }
}
