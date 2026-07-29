<?php

namespace App\Listeners;

use App\Events\NewSubscriber;
use App\Notifications\NewSubscriberNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSubscriberNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(NewSubscriber $event): void
    {
        $event->creator->notify(new NewSubscriberNotification($event->subscriber));
    }
}
