<?php

namespace App\Listeners;

use App\Events\NewComment;
use App\Notifications\NewCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCommentNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(NewComment $event): void
    {
        $videoOwner = $event->video->user;

        if ($videoOwner->id !== $event->user->id) {
            $videoOwner->notify(new NewCommentNotification(
                $event->comment,
                $event->video,
                $event->user
            ));
        }

        if ($event->comment->parent_id) {
            $parentComment = $event->comment->parent;

            if ($parentComment && $parentComment->user_id !== $event->user->id) {
                $parentComment->user->notify(new NewCommentNotification(
                    $event->comment,
                    $event->video,
                    $event->user
                ));
            }
        }
    }
}
