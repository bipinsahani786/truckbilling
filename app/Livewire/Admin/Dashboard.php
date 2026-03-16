<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Services\DashboardService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

/**
 * Dashboard Livewire Component
 *
 * Displays the main analytics dashboard with fleet status, revenue/profit
 * metrics, a financial chart for the last 15 days, and a live trip feed.
 *
 * Supports both owner and driver views:
 * - Owner: sees full fleet stats and all trips across the organization
 * - Driver: sees only their own trips and revenue
 *
 * Business logic is delegated to DashboardService.
 * This component only handles date filters and rendering.
 */
class Dashboard extends Component
{
    #[Layout('layouts.app')]

    // --- Date & Status Filter Properties ---
    /** @var string Start date for filtering dashboard data (Y-m-d format) */
    public $date_from;
    /** @var string End date for filtering dashboard data (Y-m-d format) */
    public $date_to;
    /** @var string Trip status filter (empty = all statuses) */
    public $status_filter = '';

    /**
     * Initialize filters with sensible defaults.
     * Default range: 1st of current month through today.
     */
    public function mount()
    {
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');
    }

    /**
     * Reset all filters back to their default values.
     */
    public function resetFilters()
    {
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');
        $this->status_filter = '';
    }

    /**
     * Render the dashboard view with all analytics data from the DashboardService.
     */
    public function render()
    {
        $user = Auth::user();
        $isDriver = $user->hasRole('driver');
        $isOwner = !$isDriver;
        $ownerId = $isDriver ? $user->owner_id : $user->id;
        $driverId = $isDriver ? $user->id : null;

        $dashboardService = app(DashboardService::class);

        // Get main dashboard metrics (revenue, profit, fleet stats, live trips)
        $dashboardData = $dashboardService->getDashboardData(
            $ownerId,
            $isDriver,
            $driverId,
            $this->date_from,
            $this->date_to,
            $this->status_filter
        );

        // Get chart data for the last 15 days (freight, recovery, expense)
        $chartData = $dashboardService->getChartData(
            $ownerId,
            $isDriver,
            $driverId,
            $this->date_to
        );

        return view('livewire.admin.dashboard', [
            'isDriver' => $isDriver,
            'isOwner' => $isOwner,
            'totalRevenue' => $dashboardData['totalRevenue'],
            'totalExpenses' => $dashboardData['totalExpenses'],
            'netProfit' => $dashboardData['netProfit'],
            'pendingDues' => $dashboardData['pendingDues'],
            'totalVehicles' => $dashboardData['totalVehicles'],
            'onRoadVehicles' => $dashboardData['onRoadVehicles'],
            'fleetPercentage' => $dashboardData['fleetPercentage'],
            'liveTrips' => $dashboardData['liveTrips'],
            'chartLabels' => $chartData['labels'],
            'chartFreight' => $chartData['freight'],
            'chartRecovery' => $chartData['recovery'],
            'chartExpense' => $chartData['expense'],
        ]);
    }
}