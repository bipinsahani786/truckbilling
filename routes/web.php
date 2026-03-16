<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\DealerManagement;
use App\Livewire\Admin\DriverManagement;
use App\Livewire\Admin\ExpenseCategoryManagement;
use App\Livewire\Admin\ProfileSettings;
use App\Livewire\Admin\TripManagement;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\VehicleManagement;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Driver\DriverDocuments;
use App\Livewire\Driver\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Guest routes (login, register, forgot/reset password handled by Fortify)
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Protected routes (authenticated users only)
Route::middleware('auth')->group(function () {

    // Shared routes: Profile settings and Dashboard accessible by all roles
    Route::get('/profile', ProfileSettings::class)->name('profile');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    // --- Owner-Only Routes ---
    // Trips, fleet, drivers, dealers are only for fleet owners
    Route::middleware('role:owner')->prefix('admin')->group(function () {
        Route::get('/trips', TripManagement::class)->name('admin.trips');
        Route::get('/fleet', VehicleManagement::class)->name('admin.vehicles');
        Route::get('/drivers', DriverManagement::class)->name('admin.drivers');
        Route::get('/dealers', DealerManagement::class)->name('admin.dealers');
        Route::get('/expenses/categories', ExpenseCategoryManagement::class)->name('admin.expense.categories');
    });

    // --- Super-Admin Routes ---
    // Super-admin manages users and system-wide expense categories
    Route::middleware('role:super-admin')->prefix('superadmin')->group(function () {
        Route::get('/users', UserManagement::class)->name('admin.users');
        Route::get('/expenses/categories', ExpenseCategoryManagement::class)->name('superadmin.expense.categories');
    });

    // --- Driver Routes ---
    // Drivers see their own trips and documents
    Route::middleware('role:driver')->prefix('driver')->group(function () {
        Route::get('/trips', TripManagement::class)->name('driver.trips');
        Route::get('/my-documents', DriverDocuments::class)->name('driver.documents');
    });

    // Logout
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

require __DIR__ . '/settings.php';