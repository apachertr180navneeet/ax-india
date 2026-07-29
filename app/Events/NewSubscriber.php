<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewSubscriber
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $creator;
    public User $subscriber;

    public function __construct(User $creator, User $subscriber)
    {
        $this->creator = $creator;
        $this->subscriber = $subscriber;
    }
}
