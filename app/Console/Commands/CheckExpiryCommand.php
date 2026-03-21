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
            $query->whereBetween('insurance_expiry_date', [$today, $expiryLimit])
                  ->orWhereBetween('fitness_expiry_date', [$today, $expiryLimit])
                  ->orWhereBetween('national_permit_expiry_date', [$today, $expiryLimit])
                  ->orWhereBetween('pollution_expiry_date', [$today, $expiryLimit]);
        })->get();

        foreach ($vehicles as $vehicle) {
            $owner = User::find($vehicle->owner_id);
            if (!$owner) continue;

            $documents = [
                'Insurance' => $vehicle->insurance_expiry_date,
                'Fitness' => $vehicle->fitness_expiry_date,
                'Permit' => $vehicle->national_permit_expiry_date,
                'Pollution' => $vehicle->pollution_expiry_date,
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
