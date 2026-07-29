<?php

namespace App\Events;

use App\Models\User;
use App\Models\Video;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VideoUploaded implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Video $video;
    public User $user;

    public function __construct(Video $video, User $user)
    {
        $this->video = $video;
        $this->user = $user;
    }
}
