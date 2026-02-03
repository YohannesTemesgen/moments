<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TimelineController;
use App\Http\Controllers\Admin\CalendarController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\MomentController;
use App\Http\Controllers\NavItemController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    Route::get('/', function () {
        return 'This is your multi-tenant application. The id of the current tenant is ' . tenant('id');
    });

    // Auth Routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Admin Routes (Protected)
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
        Route::get('/map', [MapController::class, 'index'])->name('map');
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
        Route::post('/settings/update', [SettingsController::class, 'updateSetting'])->name('settings.update');
        
        // Moment CRUD
        Route::get('/moments/create', [MomentController::class, 'create'])->name('moments.create');
        Route::post('/moments', [MomentController::class, 'store'])->name('moments.store');
        Route::get('/moments/{moment}', [MomentController::class, 'show'])->name('moments.show');
        Route::get('/moments/{moment}/edit', [MomentController::class, 'edit'])->name('moments.edit');
        Route::put('/moments/{moment}', [MomentController::class, 'update'])->name('moments.update');
        Route::delete('/moments/{moment}', [MomentController::class, 'destroy'])->name('moments.destroy');
        Route::delete('/moments/image/{image}', [MomentController::class, 'deleteImage'])->name('moments.image.delete');
        
        // Navigation Management
        Route::get('/navigation', [NavItemController::class, 'index'])->name('navigation');
        Route::post('/navigation', [NavItemController::class, 'store'])->name('navigation.store');
        Route::put('/navigation/{navItem}', [NavItemController::class, 'update'])->name('navigation.update');
        Route::delete('/navigation/{navItem}', [NavItemController::class, 'destroy'])->name('navigation.destroy');
        Route::patch('/navigation/{navItem}/visibility', [NavItemController::class, 'updateVisibility'])->name('navigation.visibility');
        Route::post('/navigation/order', [NavItemController::class, 'updateOrder'])->name('navigation.order');
    });
});
