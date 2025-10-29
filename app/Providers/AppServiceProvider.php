<?php

namespace App\Providers;

use App\Listeners\TeamMemberAddedListener;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Events\TeamMemberAdded;

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

        $this->registerGates();

        Event::listen(
            TeamMemberAdded::class,
            TeamMemberAddedListener::class
        );
    }

    public function registerGates()
    {
        Gate::define('edit-task', function ($user, $task) {
            return $user->id === $task->assigned_to || $user->ownsTeam($user->currentTeam);
        });

        Gate::define('delete-task', function ($user, $task) {
            return $user->hasTeamPermission($user->currentTeam, 'delete');
        });

        Gate::define('view-request', function ($user, $startup) {
            return $user->ownsStartup($startup);
        });
    }
}
