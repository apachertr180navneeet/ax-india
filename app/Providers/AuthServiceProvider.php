<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Playlist;
use App\Models\Profile;
use App\Models\Subscription;
use App\Models\Video;
use App\Models\VideoReport;
use App\Policies\CommentPolicy;
use App\Policies\PlaylistPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\ReportPolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\VideoPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Video::class => VideoPolicy::class,
        Comment::class => CommentPolicy::class,
        Playlist::class => PlaylistPolicy::class,
        Profile::class => ProfilePolicy::class,
        Subscription::class => SubscriptionPolicy::class,
        VideoReport::class => ReportPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
