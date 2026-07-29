<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Notifications\WelcomeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendWelcomeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(UserRegistered $event): void
    {
        $event->user->notify((new WelcomeNotification($event->user))
            ->delay(now()->addMinutes(5)));
    }
}
