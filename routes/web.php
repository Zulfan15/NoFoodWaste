<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Welcome page

// Route untuk homepage (accessible to all)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Leaderboard page (accessible to all)
Route::get('/leaderboard', [LeaderboardController::class, 'showLeaderboard'])->name('leaderboard');

// Route untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('login', function() {
        return view('login');
    })->name('login');

    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    
    // Registration routes
    Route::get('register', function() {
        return view('register');
    })->name('register');
    
    Route::post('register', [AuthController::class, 'register'])->name('register.post');
    
    // Password reset routes
    Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Route untuk user yang sudah login
Route::middleware('auth')->group(function () {    Route::post('logout', [AuthController::class, 'logout'])->name('logout');      
    
    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Leaderboard routes
    Route::get('/leaderboard/data', [LeaderboardController::class, 'getLeaderboardData'])->name('leaderboard.data');
    Route::get('/leaderboard/update', [LeaderboardController::class, 'updateLeaderboard'])->name('leaderboard.update');    // Donation routes
    Route::get('/donate', [DonationController::class, 'index'])->name('donate');
    Route::post('/donate', [DonationController::class, 'store'])->name('donate.post');
    Route::get('/find-donations', [DonationController::class, 'findDonations'])->name('find-donations');
    Route::get('/get-nearby-donations', [DonationController::class, 'getNearbyDonations'])->name('get-nearby-donations');
    Route::get('/donations/search-by-category/{category}', [DonationController::class, 'findByCategory'])->name('donations.category');
    
    // Extended donation functionality
    Route::get('/donations/{id}', [DonationController::class, 'show'])->name('donations.show');
    Route::get('/donations/{id}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::put('/donations/{id}', [DonationController::class, 'update'])->name('donations.update');
    Route::delete('/donations/{id}', [DonationController::class, 'destroy'])->name('donations.destroy');
    
    // Claims functionality
    Route::get('/donations/{id}/claim-form', [DonationController::class, 'claimForm'])->name('donations.claim.form');
    Route::post('/donations/{id}/claim', [DonationController::class, 'claim'])->name('donations.claim');
    Route::get('/claims/{id}', [DonationController::class, 'showClaim'])->name('claims.show');
    Route::delete('/claims/{id}', [DonationController::class, 'cancelClaim'])->name('claims.cancel');// User profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/update-photo', [ProfileController::class, 'updateProfilePhoto'])->name('profile.update-photo');    // User activity routes
    Route::get('/my-activity', [ProfileController::class, 'activity'])->name('my-activity');
    Route::get('/my-donations', [DonationController::class, 'myDonations'])->name('donations.my');
    Route::get('/my-claims', [DonationController::class, 'myClaims'])->name('claims.my');
    
    // Notifications routes
    Route::get('/notifications', [App\Http\Controllers\User\NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/mark-as-read', [App\Http\Controllers\User\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    
    // User settings routes
    Route::get('/settings', [ProfileController::class, 'showSettings'])->name('settings');
    Route::post('/settings/update', [ProfileController::class, 'updateSettings'])->name('settings.update');
    Route::get('/settings/export/{type}/{format}', [ProfileController::class, 'exportUserData'])->name('settings.export');
    Route::get('/export-data', [ProfileController::class, 'exportData'])->name('profile.export-data');
    Route::post('/data-deletion-request', [ProfileController::class, 'processDataDeletionRequest'])->name('profile.data-deletion-request');
    Route::post('/profile/deactivate', [ProfileController::class, 'deactivate'])->name('profile.deactivate');
    Route::delete('/profile/delete', [ProfileController::class, 'deleteAccount'])->name('profile.delete');
});

// Route fallback untuk template (redirect ke dashboard)
Route::get('/index', function() {
    return redirect()->route('dashboard');
})->name('index');

// Route fallback untuk template starter-kit yang dihapus
Route::get('/footer-dark', function() {
    return redirect()->route('dashboard');
})->name('footer-dark');

Route::get('/footer-light', function() {
    return redirect()->route('dashboard');
})->name('footer-light');

Route::get('/footer-fixed', function() {
    return redirect()->route('dashboard');
})->name('footer-fixed');

Route::get('/layout-dark', function() {
    return redirect()->route('dashboard');
})->name('layout-dark');

Route::get('/layout-rtl', function() {
    return redirect()->route('dashboard');
})->name('layout-rtl');

Route::get('/boxed', function() {
    return redirect()->route('dashboard');
})->name('boxed');

Route::get('/default-layout', function() {
    return redirect()->route('dashboard');
})->name('default-layout');

Route::get('/compact-layout', function() {
    return redirect()->route('dashboard');
})->name('compact-layout');

Route::get('/modern-layout', function() {
    return redirect()->route('dashboard');
})->name('modern-layout');

// Route khusus untuk download assets (hanya untuk development)
Route::get('/download-assets', function() {
    return view('scripts.download_assets');
});