<?php

namespace App\Console\Commands;

use App\Models\Vehicle;
use App\Models\User;
use App\Notifications\VehicleExpiryNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiryCommand extends Command
{
    protected $signature = 'vehicles:check-expiry';
    protected $description = 'Check for vehicle document expiries and send notifications';

    public function handle()
    {
        $daysToExpiry = 7;
        $expiryLimit = Carbon::now()->addDays($daysToExpiry)->toDateString();
        $today = Carbon::now()->toDateString();

        $vehicles = Vehicle::where(function($query) use ($expiryLimit, $today) {
            $query->whereBetween('rc_expiry', [$today, $expiryLimit])
                  ->orWhereBetween('insurance_expiry', [$today, $expiryLimit])
                  ->orWhereBetween('fitness_expiry', [$today, $expiryLimit])
                  ->orWhereBetween('permit_expiry', [$today, $expiryLimit])
                  ->orWhereBetween('pollution_expiry', [$today, $expiryLimit]);
        })->get();

        foreach ($vehicles as $vehicle) {
            $owner = User::find($vehicle->owner_id);
            if (!$owner) continue;

            $documents = [
                'RC' => $vehicle->rc_expiry,
                'Insurance' => $vehicle->insurance_expiry,
                'Fitness' => $vehicle->fitness_expiry,
                'Permit' => $vehicle->permit_expiry,
                'Pollution' => $vehicle->pollution_expiry,
            ];

            foreach ($documents as $type => $expiry) {
                if ($expiry >= $today && $expiry <= $expiryLimit) {
                    $owner->notify(new VehicleExpiryNotification($vehicle, $type, $expiry));
                }
            }
        }

        $this->info('Expiry check completed.');
    }
}
