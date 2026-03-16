<?php

namespace App\Services;

use App\Models\Trip;
use App\Models\TripBilling;
use App\Models\TripTransaction;
use App\Models\Vehicle;
use Carbon\Carbon;

/**
 * DashboardService
 *
 * Aggregates and calculates all analytics data displayed on the dashboard,
 * including fleet status, revenue/profit metrics, chart data for the last
 * 15 days, and a live trip feed.
 */
class DashboardService
{
    /**
     * Get all dashboard analytics data based on applied filters.
     *
     * Calculates:
     * - Fleet status (total vehicles, on-road vehicles, utilization percentage)
     * - Revenue & profit metrics (total freight, recoveries, expenses, net profit, pending dues)
     * - Live trip feed (last 5 active trips with current profit)
     *
     * @param int         $ownerId      The fleet owner's user ID
     * @param bool        $isDriver     Whether the current user is a driver
     * @param int|null    $driverId     The driver's user ID (for driver-specific filtering)
     * @param string|null $dateFrom     Start date filter (Y-m-d format)
     * @param string|null $dateTo       End date filter (Y-m-d format)
     * @param string|null $statusFilter Trip status filter
     * @return array Associative array with all dashboard metrics
     */
    public function getDashboardData(int $ownerId, bool $isDriver, ?int $driverId = null, ?string $dateFrom = null, ?string $dateTo = null, ?string $statusFilter = null): array
    {
        // Build the base trip query with ownership and optional driver restriction
        $tripQuery = Trip::where('owner_id', $ownerId);
        if ($isDriver) {
            $tripQuery->where('driver_id', $driverId);
        }

        // Apply date range and status filters
        if ($dateFrom) {
            $tripQuery->whereDate('start_date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $tripQuery->whereDate('start_date', '<=', $dateTo);
        }
        if ($statusFilter) {
            $tripQuery->where('status', $statusFilter);
        }

        // Get all matching trip IDs for aggregate calculations
        $tripIds = (clone $tripQuery)->pluck('id');

        // --- Fleet Status (Owner Only) ---
        $totalVehicles = 0;
        $onRoadVehicles = 0;
        $fleetPercentage = 0;

        if (!$isDriver) {
            $totalVehicles = Vehicle::where('owner_id', $ownerId)->count();
            // 'maintenance' status means the vehicle is currently on a trip
            $onRoadVehicles = Vehicle::where('owner_id', $ownerId)->where('status', 'maintenance')->count();
            $fleetPercentage = $totalVehicles > 0 ? round(($onRoadVehicles / $totalVehicles) * 100) : 0;
        }

        // --- Revenue & Profit Calculation ---
        $totalFreight = TripBilling::whereIn('trip_id', $tripIds)->sum('freight_amount');

        $totalRecoveries = TripTransaction::whereIn('trip_id', $tripIds)
            ->where('transaction_type', 'recovery')
            ->sum('amount');

        $totalExpenses = TripTransaction::whereIn('trip_id', $tripIds)
            ->where('transaction_type', 'expense')
            ->sum('amount');

        $totalRevenue = $totalFreight + $totalRecoveries;
        $netProfit = $totalRevenue - $totalExpenses;

        // Pending dues = freight billed minus amount actually recovered
        $pendingDues = max(0, $totalFreight - $totalRecoveries);

        // --- Live Trip Feed (last 5 active/in-progress trips) ---
        $liveTrips = (clone $tripQuery)
            ->with(['vehicle', 'driver'])
            ->where('status', '!=', 'completed')
            ->latest()
            ->take(5)
            ->get();

        // Calculate current profit for each live trip
        foreach ($liveTrips as $trip) {
            $tripExp = TripTransaction::where('trip_id', $trip->id)
                ->where('transaction_type', 'expense')->sum('amount');
            $tripRec = TripTransaction::where('trip_id', $trip->id)
                ->where('transaction_type', 'recovery')->sum('amount');
            $tripBillingFreight = TripBilling::where('trip_id', $trip->id)->sum('freight_amount');

            $trip->current_profit = ($tripBillingFreight + $tripRec) - $tripExp;
        }

        return [
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
            'netProfit' => $netProfit,
            'pendingDues' => $pendingDues,
            'totalVehicles' => $totalVehicles,
            'onRoadVehicles' => $onRoadVehicles,
            'fleetPercentage' => $fleetPercentage,
            'liveTrips' => $liveTrips,
        ];
    }

    /**
     * Generate chart data for the last 15 days showing daily freight, recovery, and expenses.
     *
     * Prevents future-date predictions by capping the end date to today.
     *
     * @param int         $ownerId   The fleet owner's user ID
     * @param bool        $isDriver  Whether the current user is a driver
     * @param int|null    $driverId  The driver's user ID (for driver-specific filtering)
     * @param string|null $endDate   The end date for the chart range (defaults to today)
     * @return array Associative array with 'labels', 'freight', 'recovery', 'expense' arrays
     */
    public function getChartData(int $ownerId, bool $isDriver, ?int $driverId = null, ?string $endDate = null): array
    {
        $chartLabels = [];
        $chartFreight = [];
        $chartRecovery = [];
        $chartExpense = [];

        $end = $endDate ? Carbon::parse($endDate) : Carbon::now();

        // Prevent the chart from showing future dates (which would always be zero)
        if ($end->isFuture()) {
            $end = Carbon::now();
        }

        // Generate data points for each of the last 15 days
        for ($i = 14; $i >= 0; $i--) {
            $dateStr = (clone $end)->subDays($i)->format('Y-m-d');
            $chartLabels[] = Carbon::parse($dateStr)->format('d M');

            // Get trip IDs for this specific date
            $dailyTrips = Trip::where('owner_id', $ownerId);
            if ($isDriver) {
                $dailyTrips->where('driver_id', $driverId);
            }
            $dailyTrips->whereDate('start_date', $dateStr);
            $dTripIds = $dailyTrips->pluck('id');

            // Calculate daily metrics
            $chartFreight[] = TripBilling::whereIn('trip_id', $dTripIds)->sum('freight_amount');
            $chartRecovery[] = TripTransaction::whereIn('trip_id', $dTripIds)
                ->where('transaction_type', 'recovery')->sum('amount');
            $chartExpense[] = TripTransaction::whereIn('trip_id', $dTripIds)
                ->where('transaction_type', 'expense')->sum('amount');
        }

        return [
            'labels' => $chartLabels,
            'freight' => $chartFreight,
            'recovery' => $chartRecovery,
            'expense' => $chartExpense,
        ];
    }
}
