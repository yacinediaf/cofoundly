<?php

namespace App\Notifications;

use App\Models\Startup;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StartupJoinRequest extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user, public Startup $startup)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Startup Join Request')
            ->greeting('Hello ' . $this->startup->owner->name . ',')
            ->line('You have received a join request from ' . $this->user->name . '.')
            ->line('Please log in to accept or reject the request.')
            ->action('View Request', url('/startups/' . $this->startup->id . '/requests'));
    }
}
