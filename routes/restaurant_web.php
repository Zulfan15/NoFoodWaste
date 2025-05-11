<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Restaurant\DashboardController;

// Restaurant routes
Route::prefix('restaurant')->middleware(['auth', 'role:restaurant'])->name('restaurant.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Donasi makanan
    Route::get('/donations', [App\Http\Controllers\Restaurant\DonationController::class, 'index'])->name('donations');
    Route::get('/donations/create', [App\Http\Controllers\Restaurant\DonationController::class, 'create'])->name('donations.create');
    Route::post('/donations', [App\Http\Controllers\Restaurant\DonationController::class, 'store'])->name('donations.store');
    Route::get('/donations/{donation}/edit', [App\Http\Controllers\Restaurant\DonationController::class, 'edit'])->name('donations.edit');
    Route::put('/donations/{donation}', [App\Http\Controllers\Restaurant\DonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{donation}', [App\Http\Controllers\Restaurant\DonationController::class, 'destroy'])->name('donations.destroy');
    
    // Riwayat donasi
    Route::get('/history', [App\Http\Controllers\Restaurant\DonationController::class, 'history'])->name('history');
});
