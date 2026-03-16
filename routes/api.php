<?php

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
    Route::post('logout', [AuthController::class, 'logout']);
    
    // Dashboard (Accessible by all roles, logic handled inside)
    Route::get('dashboard', [DashboardApiController::class, 'index']);

    // --- Trips ---
    Route::get('trips', [TripApiController::class, 'index']);
    Route::post('trips', [TripApiController::class, 'store']);
    Route::get('trips/{id}', [TripApiController::class, 'show']);
    Route::put('trips/{id}/status', [TripApiController::class, 'updateStatus']);
    Route::post('trips/{id}/end', [TripApiController::class, 'endTrip']);

    // --- Trip Transactions ---
    Route::post('trips/{trip_id}/transactions', [TripTransactionApiController::class, 'store']);
    Route::put('transactions/{id}', [TripTransactionApiController::class, 'update']);
    Route::delete('transactions/{id}', [TripTransactionApiController::class, 'destroy']);

    // --- Trip Billings ---
    Route::post('trips/{trip_id}/billings', [TripBillingApiController::class, 'store']);
    Route::put('billings/{id}', [TripBillingApiController::class, 'update']);
    Route::delete('billings/{id}', [TripBillingApiController::class, 'destroy']);

    // --- Owner Only: Vehicles & Drivers & Dealers ---
    Route::middleware('role:owner')->group(function () {
        Route::get('vehicles', [VehicleApiController::class, 'index']);
        Route::post('vehicles', [VehicleApiController::class, 'store']);
        Route::get('vehicles/stats', [VehicleApiController::class, 'stats']);
        Route::get('vehicles/{id}', [VehicleApiController::class, 'show']);

        Route::get('drivers', [DriverApiController::class, 'index']);
        Route::post('drivers', [DriverApiController::class, 'store']);

        Route::get('dealers', [DealerApiController::class, 'index']);
        Route::post('dealers', [DealerApiController::class, 'store']);

        Route::post('wallets/add-funds', [WalletApiController::class, 'addFunds']);
    });

    // --- Shared Owner & Super-Admin: Expense Categories ---
    Route::middleware('role_or_permission:owner|super-admin')->group(function () {
        Route::get('expense-categories', [ExpenseCategoryApiController::class, 'index']);
        Route::post('expense-categories', [ExpenseCategoryApiController::class, 'store']);
        Route::delete('expense-categories/{id}', [ExpenseCategoryApiController::class, 'destroy']);
    });

    // --- Wallets (Driver sees their own, Owner sees driver wallets for their fleet, handled inside) ---
    Route::get('wallets', [WalletApiController::class, 'index']);

    // --- Super Admin Only: User Management ---
    Route::middleware('role:super-admin')->group(function () {
        Route::get('users', [UserManagementApiController::class, 'index']);
        Route::post('users/{id}/toggle-block', [UserManagementApiController::class, 'toggleBlock']);
        Route::post('users/{id}/reset-password', [UserManagementApiController::class, 'resetPassword']);
    });
});
