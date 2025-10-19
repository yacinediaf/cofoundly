<?php

namespace App\Listeners;

use Laravel\Jetstream\Events\TeamMemberAdded;

class TeamMemberAddedListener
{
    /**
     * Handle the event.
     */
    public function handle(TeamMemberAdded $event): void
    {
        $event->team->startup->requests()
            ->where('user_id', $event->user->id)
            ->delete();
    }
}
