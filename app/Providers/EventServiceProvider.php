<?php

namespace App\Providers;

use App\Events\NewComment;
use App\Events\NewSubscriber;
use App\Events\UserRegistered;
use App\Events\VideoLiked;
use App\Events\VideoReported;
use App\Events\VideoUploaded;
use App\Listeners\ProcessVideoThumbnail;
use App\Listeners\SendCommentNotification;
use App\Listeners\SendLikeNotification;
use App\Listeners\SendReportNotification;
use App\Listeners\SendSubscriberNotification;
use App\Listeners\SendWelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        UserRegistered::class => [
            SendWelcomeNotification::class,
        ],
        VideoUploaded::class => [
            ProcessVideoThumbnail::class,
        ],
        VideoLiked::class => [
            SendLikeNotification::class,
        ],
        NewComment::class => [
            SendCommentNotification::class,
        ],
        NewSubscriber::class => [
            SendSubscriberNotification::class,
        ],
        VideoReported::class => [
            SendReportNotification::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
