<?php

namespace App\Providers;

use App\Models\User;
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
        Gate::define('master', function (User $user) {
            return $user->level === 'master';
        });

        Gate::define('admin-or-master', function (User $user) {
            return in_array($user->level, ['admin', 'master']);
        });
    }
}
