<?php

namespace App\Listeners;

use App\Events\VideoUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class ProcessVideoThumbnail implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(VideoUploaded $event): void
    {
        Log::info('Video uploaded, processing thumbnail: ' . $event->video->id);
    }
}
