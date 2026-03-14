<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\DealerManagement;
use App\Livewire\Admin\DriverManagement;
use App\Livewire\Admin\ExpenseCategoryManagement;
use App\Livewire\Admin\ProfileSettings;
use App\Livewire\Admin\TripManagement; // <--- NAYA ROUTE IMPORT KIYA
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

// Custom Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// Protected Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/profile', ProfileSettings::class)->name('profile');
    Route::get('/trips', TripManagement::class)->name('admin.trips'); // <--- NAYA TRIP ROUTE
    Route::get('/fleet', VehicleManagement::class)->name('admin.vehicles');
    Route::get('/drivers', DriverManagement::class)->name('admin.drivers');
    Route::get('/expenses/categories', ExpenseCategoryManagement::class)->name('admin.expense.categories');
    Route::get('/dealers', DealerManagement::class)->name('admin.dealers');

    //driver route
    Route::get('/my-documents', DriverDocuments::class)->name('driver.documents');    // Logout Logic 
    Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    })->name('logout');
});

require __DIR__ . '/settings.php';