<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TimelineController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\MomentController;
use App\Http\Controllers\GennaController;
use App\Http\Controllers\NavItemController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Original Landing Page (for Upsidedown)
Route::get('/landing', [LandingController::class, 'index'])->name('landing.original');

// Genna Countdown Page
Route::get('/genacountdown', [GennaController::class, 'index'])->name('genacountdown');

// SuperAdmin Routes
use App\Http\Controllers\SuperAdmin\AuthController as SuperAdminAuthController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;

Route::prefix('admin')->name('superadmin.')->group(function () {
    Route::get('/login', [SuperAdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [SuperAdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [SuperAdminAuthController::class, 'logout'])->name('logout');
});

Route::middleware(['superadmin.auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [SuperAdminDashboardController::class, 'users'])->name('users.index');
    Route::get('/users/create', [SuperAdminDashboardController::class, 'createUser'])->name('users.create');
    Route::post('/users', [SuperAdminDashboardController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [SuperAdminDashboardController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [SuperAdminDashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [SuperAdminDashboardController::class, 'deleteUser'])->name('users.destroy');
    
    // Profile
    Route::get('/profile', [SuperAdminDashboardController::class, 'profile'])->name('profile');
    Route::post('/profile', [SuperAdminDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [SuperAdminDashboardController::class, 'updatePassword'])->name('profile.password');

    // Settings
    Route::get('/settings', [SuperAdminDashboardController::class, 'settings'])->name('settings');
    Route::post('/settings/update', [SuperAdminDashboardController::class, 'updateSetting'])->name('settings.update');
});

// PWA Manifest
Route::get('/manifest.json', function () {
    return response()->json([
        'name' => 'BirthDay App',
        'short_name' => 'BirthDay',
        'description' => 'Countdown and Moments Tracker',
        'start_url' => '/',
        'display' => 'standalone',
        'background_color' => '#000000',
        'theme_color' => '#ea2a33',
        'icons' => [
            ['src' => '/icons/icon-72x72.png', 'sizes' => '72x72', 'type' => 'image/png'],
            ['src' => '/icons/icon-96x96.png', 'sizes' => '96x96', 'type' => 'image/png'],
            ['src' => '/icons/icon-128x128.png', 'sizes' => '128x128', 'type' => 'image/png'],
            ['src' => '/icons/icon-144x144.png', 'sizes' => '144x144', 'type' => 'image/png'],
            ['src' => '/icons/icon-152x152.png', 'sizes' => '152x152', 'type' => 'image/png'],
            ['src' => '/icons/icon-192x192.png', 'sizes' => '192x192', 'type' => 'image/png'],
            ['src' => '/icons/icon-384x384.png', 'sizes' => '384x384', 'type' => 'image/png'],
            ['src' => '/icons/icon-512x512.png', 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'any maskable'],
        ],
    ])->header('Content-Type', 'application/manifest+json');
});
