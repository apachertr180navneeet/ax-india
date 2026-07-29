<?php

namespace App\Notifications;

use App\Models\User;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class VideoPublishedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Video $video;
    public User $channel;

    public function __construct(Video $video, User $channel)
    {
        $this->video = $video;
        $this->channel = $channel;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'video_published',
            'message' => 'New video: "' . $this->video->title . '"',
            'video_id' => $this->video->id,
            'video_title' => $this->video->title,
            'video_slug' => $this->video->slug,
            'channel_name' => $this->channel->full_name,
        ];
    }
}
