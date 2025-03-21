<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        Gate::define('edit-attendance', function ($user, $attendance) {
            return $user->id === $attendance->teacher_id || $user->can('edit-attendance');
        });

        Paginator::useBootstrapFive();
    }
}
