<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicineController;
use Illuminate\Support\Facades\Auth;

// Redirect root to medicines dashboard (or login if not authenticated)
Route::get('/', function () {
    return Auth::check() ? redirect()->route('medicines.index') : redirect()->route('login');
});

// Authentication routes
Auth::routes();

// Protected routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Dashboard route
    Route::get('/dashboard', [MedicineController::class, 'dashboard'])->name('dashboard');
    
    // Medicines routes
    Route::get('/medicines', [MedicineController::class, 'index'])->name('medicines.index');
    Route::get('/medicines/create', [MedicineController::class, 'create'])->name('medicines.create');
    Route::post('/medicines', [MedicineController::class, 'store'])->name('medicines.store');
    Route::put('/medicines/{medicine}', [MedicineController::class, 'update'])->name('medicines.update');
    Route::delete('/medicines/{medicine}', [MedicineController::class, 'destroy'])->name('medicines.destroy');
    
    // Redirect /home to dashboard
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');
});

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');
