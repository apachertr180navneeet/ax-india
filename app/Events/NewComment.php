<?php

namespace App\Events;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewComment
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Comment $comment;
    public Video $video;
    public User $user;

    public function __construct(Comment $comment, Video $video, User $user)
    {
        $this->comment = $comment;
        $this->video = $video;
        $this->user = $user;
    }
}
