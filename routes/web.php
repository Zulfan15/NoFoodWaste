<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ForgotPasswordController;
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

@include_once('admin_web.php');

// Route untuk homepage (accessible to all)
Route::get('/', function () {
    return view('welcome');
})->name('home');

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
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    
    // Dashboard route
    Route::get('/dashboard', function() {
        return view('dashboard.index');
    })->name('dashboard');

    // Donation routes
    Route::get('/donate', [DonationController::class, 'index'])->name('donate');
    Route::get('/find-donations', [DonationController::class, 'findDonations'])->name('find-donations');
});

Route::prefix('starter-kit')->group(function () {
    Route::view('index', 'admin.color-version.index')->name('index');
});