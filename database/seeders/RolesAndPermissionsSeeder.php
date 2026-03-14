<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Create Roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $ownerRole = Role::create(['name' => 'owner']);
        $driverRole = Role::create(['name' => 'driver']);

        // 2. Create the Master Super Admin (Your Account)
        $bipin = User::create([
            'name' => 'Bipin',
            'email' => 'admin@zytrixon.com',
            'mobile_number' => '9876543210', // Update with real one later
            'address' => 'Patna',
            'company_name' => 'Zytrixon Tech',
            'password' => Hash::make('password'), // Default password
        ]);
        $bipin->assignRole($superAdminRole);

        // 3. Create a Demo Truck Owner (Client)
        $demoOwner = User::create([
            'name' => 'Demo Transport',
            'email' => 'owner@demo.com',
            'mobile_number' => '1122334455',
            'address' => 'Delhi',
            'company_name' => 'Demo Logistics Pvt Ltd',
            'password' => Hash::make('password'),
        ]);
        $demoOwner->assignRole($ownerRole);
        
        // 4. Create a Demo Driver for the Owner
        $demoDriver = User::create([
            'owner_id' => $demoOwner->id, // Linked to the Demo Owner
            'name' => 'Ramu Driver',
            'mobile_number' => '9988776655',
            'password' => Hash::make('password'),
        ]);
        $demoDriver->assignRole($driverRole);
    }
}