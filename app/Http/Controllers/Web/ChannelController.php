<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SubscriptionService;
use App\Services\VideoService;
use Illuminate\View\View;

class ChannelController extends Controller
{
    public function __construct(
        private readonly VideoService $videoService,
        private readonly SubscriptionService $subscriptionService,
    ) {}

    public function show(string $username): View
    {
        $user = User::whereHas('profile', fn ($q) => $q->where('username', $username))
            ->with('profile')
            ->firstOrFail();

        $videos = $this->videoService->getUserVideos($user->id, 12);
        $subscriberCount = $this->subscriptionService->getSubscriberCount($user->id);
        $playlists = $user->playlists()->where('visibility', 'public')->get();

        return view('web.channel.show', compact('user', 'videos', 'subscriberCount', 'playlists'));
    }
}
