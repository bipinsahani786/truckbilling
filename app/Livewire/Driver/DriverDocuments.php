<?php

namespace App\Livewire\Driver;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Trip;
use Livewire\Attributes\Layout;

class DriverDocuments extends Component
{
    #[Layout('layouts.app')]

    public function render()
    {
        $driver = Auth::user();

        // Driver filhal jis gaadi par active hai, uski details nikal rahe hain
        $activeTrip = Trip::with('vehicle')
            ->where('driver_id', $driver->id)
            ->where('status', '!=', 'completed')
            ->latest()
            ->first();

        $currentVehicle = $activeTrip ? $activeTrip->vehicle : null;

        return view('livewire.driver.driver-documents', [
            'driver' => $driver,
            'vehicle' => $currentVehicle,
        ]);
    }
}