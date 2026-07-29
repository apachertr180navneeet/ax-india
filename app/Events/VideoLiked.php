<?php

namespace App\Events;

use App\Models\User;
use App\Models\Video;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoLiked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Video $video;
    public User $user;
    public string $type;

    public function __construct(Video $video, User $user, string $type)
    {
        $this->video = $video;
        $this->user = $user;
        $this->type = $type;
    }
}
