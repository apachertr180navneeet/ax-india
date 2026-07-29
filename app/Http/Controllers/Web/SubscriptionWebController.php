<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\SubscriptionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionWebController extends Controller
{
    public function __construct(
        private readonly SubscriptionService $subscriptionService,
    ) {}

    public function index(Request $request): View
    {
        $subscriptions = $this->subscriptionService->getUserSubscriptions($request->user()->id);
        $feed = $this->subscriptionService->getSubscriptionFeed($request->user()->id, 16);

        return view('web.subscriptions.index', compact('subscriptions', 'feed'));
    }

    public function toggle(Request $request): JsonResponse
    {
        $request->validate(['channel_id' => 'required|exists:users,id']);
        $result = $this->subscriptionService->toggleSubscription($request->user()->id, $request->channel_id);

        return response()->json([
            'status' => 'success',
            'is_subscribed' => $result['is_subscribed'],
            'subscriber_count' => $result['subscriber_count'],
            'message' => $result['message'],
        ]);
    }
}
