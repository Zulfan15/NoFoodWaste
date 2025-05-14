<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\DonationController;
use App\Http\Controllers\Admin\NGOController;
use App\Http\Controllers\Admin\RestaurantController;

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
      // Mengelola pengguna
    Route::resource('users', UserController::class);
    
    // Melihat statistik
    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics');
    
    // Mengelola donasi
    Route::resource('donations', DonationController::class);
      // Mengelola NGO
    Route::resource('ngos', NGOController::class);
    
    // Mengelola restoran    
    Route::resource('restaurants', RestaurantController::class);
});


