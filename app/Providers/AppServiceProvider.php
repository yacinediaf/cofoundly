<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
        Model::unguard();
        Model::preventLazyLoading();

        Gate::define('edit-task', function ($user, $task) {
            return $user->id === $task->assigned_to || $user->ownsTeam($user->currentTeam);
        });

        Gate::define('delete-task', function ($user, $task) {
            return $user->hasTeamPermission($user->currentTeam, 'delete');
        });
    }
}
