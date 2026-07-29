<?php

namespace App\Listeners;

use App\Events\VideoReported;
use App\Notifications\VideoReportedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendReportNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(VideoReported $event): void
    {
        $admins = \App\Models\User::role('admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new VideoReportedNotification(
                $event->report,
                $event->video,
                $event->user
            ));
        }
    }
}
