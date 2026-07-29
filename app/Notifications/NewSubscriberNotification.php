<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewSubscriberNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public User $subscriber;

    public function __construct(User $subscriber)
    {
        $this->subscriber = $subscriber;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'subscriber',
            'message' => $this->subscriber->full_name . ' subscribed to you',
            'subscriber_id' => $this->subscriber->id,
            'subscriber_name' => $this->subscriber->full_name,
        ];
    }
}
