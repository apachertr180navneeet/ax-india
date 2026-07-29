<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class LikeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public User $liker;
    public Video $video;

    public function __construct(User $liker, Video $video)
    {
        $this->liker = $liker;
        $this->video = $video;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'like',
            'message' => $this->liker->full_name . ' liked your video "' . $this->video->title . '"',
            'liker_id' => $this->liker->id,
            'liker_name' => $this->liker->full_name,
            'video_id' => $this->video->id,
            'video_title' => $this->video->title,
            'video_slug' => $this->video->slug,
        ];
    }
}
