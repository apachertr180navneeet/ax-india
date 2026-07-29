<?php

namespace App\Events;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoReport;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoReported
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public VideoReport $report;
    public Video $video;
    public User $user;

    public function __construct(VideoReport $report, Video $video, User $user)
    {
        $this->report = $report;
        $this->video = $video;
        $this->user = $user;
    }
}
