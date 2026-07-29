<?php

namespace App\Listeners;

use App\Events\VideoLiked;
use App\Notifications\LikeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLikeNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(VideoLiked $event): void
    {
        if ($event->video->user_id === $event->user->id) {
            return;
        }

        $event->video->user->notify(new LikeNotification($event->user, $event->video));
    }
}
