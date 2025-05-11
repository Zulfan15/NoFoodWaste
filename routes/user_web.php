<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;

// User routes
Route::prefix('user')->middleware(['auth', 'role:user'])->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Melihat donasi tersedia
    Route::get('/donations', [App\Http\Controllers\User\DonationController::class, 'index'])->name('donations');
    
    // Melihat NGO terdekat
    Route::get('/nearby-ngos', [App\Http\Controllers\User\NGOController::class, 'nearby'])->name('nearby-ngos');
    
    // Melihat riwayat donasi dari NGO dan restoran
    Route::get('/donation-history', [App\Http\Controllers\User\DonationController::class, 'history'])->name('donation-history');
});
