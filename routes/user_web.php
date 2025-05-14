<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\DonationController;
use App\Http\Controllers\User\NGOController;
use App\Http\Controllers\User\NotificationController;

// User routes
Route::prefix('user')->middleware(['auth', 'role:user'])->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Melihat donasi tersedia
    Route::get('/donations', [App\Http\Controllers\User\DonationController::class, 'index'])->name('donations');
      // Melihat NGO terdekat
    Route::get('/nearby-ngos', [NGOController::class, 'nearby'])->name('nearby-ngos');
    
    // Melihat riwayat donasi dari NGO dan restoran
    Route::get('/donation-history', [DonationController::class, 'history'])->name('donation-history');
    
    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
});
