<?php

namespace App\Providers;

use App\Events\ExpenseSubmittedEvent;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Event;
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
        Gate::define('approve-reject', fn(User $user) => $user->hasRole('admin'));
        Gate::define('create', fn(User $user) => $user->guest || $user->hasRole('admin'));
    }
}
