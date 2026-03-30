<?php

use App\Http\Controllers\Api\NotificationApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\TripApiController;
use App\Http\Controllers\Api\TripTransactionApiController;
use App\Http\Controllers\Api\VehicleApiController;
use App\Http\Controllers\Api\DriverApiController;
use App\Http\Controllers\Api\DealerApiController;
use App\Http\Controllers\Api\ExpenseCategoryApiController;
use App\Http\Controllers\Api\WalletApiController;
use App\Http\Controllers\Api\UserManagementApiController;
use App\Http\Controllers\Api\TripBillingApiController;

// Public Auth Routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth & Profile
    Route::get('user', [AuthController::class, 'user']);
    Route::post('user/profile', [AuthController::class, 'updateProfile']);
    Route::post('user/change-password', [AuthController::class, 'changePassword']);
    Route::post('logout', [AuthController::class, 'logout']);
    
    // Dashboard (Accessible by all roles, logic handled inside)
    Route::get('dashboard', [DashboardApiController::class, 'index']);

    // --- Trips ---
    Route::get('trips', [TripApiController::class, 'index']);
    Route::post('trips', [TripApiController::class, 'store']);
    Route::get('trips/{id}', [TripApiController::class, 'show']);
    Route::put('trips/{id}/status', [TripApiController::class, 'updateStatus']);
    Route::post('trips/{id}/end', [TripApiController::class, 'endTrip']);
    Route::get('trips/{id}/download-invoice', [TripApiController::class, 'downloadInvoice']);

    // --- Trip Transactions ---
    Route::get('trips/{trip_id}/transactions', [TripTransactionApiController::class, 'index']);
    Route::post('trips/{trip_id}/transactions', [TripTransactionApiController::class, 'store']);
    Route::get('transactions/{id}', [TripTransactionApiController::class, 'show']);
    Route::put('transactions/{id}', [TripTransactionApiController::class, 'update']);
    Route::delete('transactions/{id}', [TripTransactionApiController::class, 'destroy']);

    // --- Trip Billings ---
    Route::get('trips/{trip_id}/billings', [TripBillingApiController::class, 'index']);
    Route::post('trips/{trip_id}/billings', [TripBillingApiController::class, 'store']);
    Route::get('billings/{id}', [TripBillingApiController::class, 'show']);
    Route::put('billings/{id}', [TripBillingApiController::class, 'update']);
    Route::delete('billings/{id}', [TripBillingApiController::class, 'destroy']);

    // --- Owner Only: Vehicles & Drivers & Dealers ---
    Route::middleware('role:owner')->group(function () {
        Route::get('vehicles', [VehicleApiController::class, 'index']);
        Route::post('vehicles', [VehicleApiController::class, 'store']);
        Route::get('vehicles/stats', [VehicleApiController::class, 'stats']);
        Route::get('vehicles/{id}', [VehicleApiController::class, 'show']);
        Route::post('vehicles/{id}', [VehicleApiController::class, 'update']); // Standard POST for updates (supports files & partial updates)
        Route::delete('vehicles/{id}', [VehicleApiController::class, 'destroy']);

        Route::get('drivers', [DriverApiController::class, 'index']);
        Route::post('drivers', [DriverApiController::class, 'store']);
        Route::get('drivers/{id}', [DriverApiController::class, 'show']);
        Route::post('drivers/{id}', [DriverApiController::class, 'update']); // Use POST with _method=PUT
        Route::delete('drivers/{id}', [DriverApiController::class, 'destroy']);

        Route::get('dealers', [DealerApiController::class, 'index']);
        Route::post('dealers', [DealerApiController::class, 'store']);
        Route::get('dealers/{id}', [DealerApiController::class, 'show']);
        Route::put('dealers/{id}', [DealerApiController::class, 'update']);
        Route::delete('dealers/{id}', [DealerApiController::class, 'destroy']);

        Route::post('wallets/add-funds', [WalletApiController::class, 'addFunds']);
    });

    // --- Shared Owner & Super-Admin: Expense Categories ---
    Route::middleware('role_or_permission:owner|super-admin')->group(function () {
        Route::get('expense-categories', [ExpenseCategoryApiController::class, 'index']);
        Route::post('expense-categories', [ExpenseCategoryApiController::class, 'store']);
        Route::put('expense-categories/{id}', [ExpenseCategoryApiController::class, 'update']);
        Route::delete('expense-categories/{id}', [ExpenseCategoryApiController::class, 'destroy']);
    });

    // --- Wallets (Driver sees their own, Owner sees driver wallets for their fleet, handled inside) ---
    Route::get('wallets', [WalletApiController::class, 'index']);
    Route::get('wallets/{id}/transactions', [WalletApiController::class, 'transactions']);

    // --- Notifications ---
    Route::get('notifications', [NotificationApiController::class, 'index']);
    Route::post('notifications/{id}/read', [NotificationApiController::class, 'markAsRead']);
    Route::post('notifications/read-all', [NotificationApiController::class, 'readAll']);

    // --- Super Admin Only: User Management ---
    Route::middleware('role:super-admin')->group(function () {
        Route::get('users', [UserManagementApiController::class, 'index']);
        Route::post('users/{id}/toggle-block', [UserManagementApiController::class, 'toggleBlock']);
        Route::post('users/{id}/reset-password', [UserManagementApiController::class, 'resetPassword']);
    });
});
