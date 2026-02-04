<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('viewRequestAnalytics', function ($user = null) {
            // Since we use superadmin.auth middleware, the user will be authenticated
            // if they are a superadmin. We can also check the guard explicitly if needed.
            return auth()->guard('superadmin')->check();
        });
    }
}
