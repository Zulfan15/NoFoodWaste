<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NGO\DashboardController;

// NGO routes
Route::prefix('ngo')->middleware(['auth', 'role:ngo'])->name('ngo.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Melihat donasi tersedia
    Route::get('/available-donations', [App\Http\Controllers\NGO\DonationController::class, 'availableDonations'])->name('available-donations');
    
    // Mengklaim donasi
    Route::post('/claim/{donation}', [App\Http\Controllers\NGO\DonationController::class, 'claim'])->name('claim');
    
    // Riwayat klaim
    Route::get('/claim-history', [App\Http\Controllers\NGO\DonationController::class, 'claimHistory'])->name('claim-history');
    
    // Laporan distribusi
    Route::get('/distribution-reports', [App\Http\Controllers\NGO\DistributionController::class, 'index'])->name('distribution-reports');
    Route::post('/distribution-reports', [App\Http\Controllers\NGO\DistributionController::class, 'store'])->name('distribution-reports.store');
});
