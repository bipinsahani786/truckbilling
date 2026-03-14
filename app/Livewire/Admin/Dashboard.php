<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\TripTransaction;
use App\Models\TripBilling; // Multi-Party Billing included
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

class Dashboard extends Component
{
    #[Layout('layouts.app')]

    // Advanced Filters
    public $date_from;
    public $date_to;
    public $status_filter = '';

    public function mount()
    {
        // ✅ BUG FIXED: Default filter is now strictly from 1st of month to TODAY
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');
    }

    public function resetFilters()
    {
        // ✅ BUG FIXED: Resetting filters also respects TODAY's date
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');
        $this->status_filter = '';
    }

    public function render()
    {
        $user = Auth::user();
        $isDriver = $user->hasRole('driver');
        $isOwner = !$isDriver; // Added explicitly for the view
        $ownerId = $isDriver ? $user->owner_id : $user->id;

        // Base Trip Query with Filters
        $tripQuery = Trip::where('owner_id', $ownerId);

        // Security: If Driver, restrict to own trips only
        if ($isDriver) {
            $tripQuery->where('driver_id', $user->id);
        }

        // Apply Date & Status Filters
        if ($this->date_from) {
            $tripQuery->whereDate('start_date', '>=', $this->date_from);
        }
        if ($this->date_to) {
            $tripQuery->whereDate('start_date', '<=', $this->date_to);
        }
        if ($this->status_filter) {
            $tripQuery->where('status', $this->status_filter);
        }

        $tripIds = (clone $tripQuery)->pluck('id');

        // 1. FLEET STATUS (Owner Only)
        $totalVehicles = 0;
        $onRoadVehicles = 0;
        $fleetPercentage = 0;

        if ($isOwner) {
            $totalVehicles = Vehicle::where('owner_id', $ownerId)->count();
            $onRoadVehicles = Vehicle::where('owner_id', $ownerId)->where('status', 'maintenance')->count(); 
            $fleetPercentage = $totalVehicles > 0 ? round(($onRoadVehicles / $totalVehicles) * 100) : 0;
        }

        // 2. REVENUE & PROFIT CALCULATION (Based on Filtered Trips)
        $totalFreight = TripBilling::whereIn('trip_id', $tripIds)->sum('freight_amount');
        
        $totalRecoveries = TripTransaction::whereIn('trip_id', $tripIds)
                            ->where('transaction_type', 'recovery')
                            ->sum('amount');

        $totalExpenses = TripTransaction::whereIn('trip_id', $tripIds)
                            ->where('transaction_type', 'expense')
                            ->sum('amount');

        $totalRevenue = $totalFreight + $totalRecoveries;
        $netProfit = $totalRevenue - $totalExpenses;

        $pendingDues = $totalFreight - $totalRecoveries;
        if ($pendingDues < 0) $pendingDues = 0;

        // 3. GRAPH DATA: Revenue, Recovery, Expense (Last 15 Days)
        $chartLabels = [];
        $chartFreight = [];
        $chartRecovery = [];
        $chartExpense = [];
        
        $endDate = $this->date_to ? Carbon::parse($this->date_to) : Carbon::now();
        
        // ✅ BUG FIXED: Prevent graph from predicting the future (which caused flat 0 lines)
        if ($endDate->isFuture()) {
            $endDate = Carbon::now();
        }

        for ($i = 14; $i >= 0; $i--) {
            $dateStr = (clone $endDate)->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($dateStr)->format('d M');

            // Daily Revenue & Expense for the Graph
            $dailyTrips = Trip::where('owner_id', $ownerId);
            if ($isDriver) $dailyTrips->where('driver_id', $user->id);
            $dailyTrips->whereDate('start_date', $dateStr);
            $dTripIds = $dailyTrips->pluck('id');

            // Fetching 3 metrics for graph
            $dFreight = TripBilling::whereIn('trip_id', $dTripIds)->sum('freight_amount');
            $dRec = TripTransaction::whereIn('trip_id', $dTripIds)->where('transaction_type', 'recovery')->sum('amount');
            $dExp = TripTransaction::whereIn('trip_id', $dTripIds)->where('transaction_type', 'expense')->sum('amount');

            $chartFreight[] = $dFreight;
            $chartRecovery[] = $dRec;
            $chartExpense[] = $dExp;
        }

        // 4. LIVE TRIP FEED
        $liveTrips = (clone $tripQuery)->with(['vehicle', 'driver'])
                         ->where('status', '!=', 'completed')
                         ->latest()
                         ->take(5)
                         ->get();

        foreach ($liveTrips as $trip) {
            $tripExp = TripTransaction::where('trip_id', $trip->id)->where('transaction_type', 'expense')->sum('amount');
            $tripRec = TripTransaction::where('trip_id', $trip->id)->where('transaction_type', 'recovery')->sum('amount');
            $tripBillingFreight = TripBilling::where('trip_id', $trip->id)->sum('freight_amount');
            
            $trip->current_profit = ($tripBillingFreight + $tripRec) - $tripExp;
        }

        return view('livewire.admin.dashboard', [
            'isDriver' => $isDriver,
            'isOwner' => $isOwner,
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'pendingDues' => $pendingDues,
            'totalVehicles' => $totalVehicles,
            'onRoadVehicles' => $onRoadVehicles,
            'fleetPercentage' => $fleetPercentage,
            'liveTrips' => $liveTrips,
            'chartLabels' => $chartLabels,
            'chartFreight' => $chartFreight,
            'chartRecovery' => $chartRecovery,
            'chartExpense' => $chartExpense,
        ]);
    }
}