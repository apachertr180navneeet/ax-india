<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Welcome to AX India!')
            ->greeting('Hello ' . $this->user->full_name . '!')
            ->line('Welcome to AX India!')
            ->action('Browse Videos', url('/'))
            ->line('Thank you for joining us!');
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'welcome',
            'message' => 'Welcome to AX India!',
        ];
    }
}
