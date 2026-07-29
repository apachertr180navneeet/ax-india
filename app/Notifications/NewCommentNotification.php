<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Comment $comment;
    public Video $video;
    public User $commenter;

    public function __construct(Comment $comment, Video $video, User $commenter)
    {
        $this->comment = $comment;
        $this->video = $video;
        $this->commenter = $commenter;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'comment',
            'message' => $this->commenter->full_name . ' commented on "' . $this->video->title . '"',
            'commenter_id' => $this->commenter->id,
            'commenter_name' => $this->commenter->full_name,
            'video_id' => $this->video->id,
            'video_title' => $this->video->title,
            'video_slug' => $this->video->slug,
            'comment_body' => $this->comment->body,
        ];
    }
}
