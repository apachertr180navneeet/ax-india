<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToggleSubscriptionRequest;
use App\Services\SubscriptionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly SubscriptionService $subscriptionService) {}

    public function toggle(ToggleSubscriptionRequest $request): JsonResponse
    {
        $userId = $request->user()->id;
        $creatorId = $request->integer('creator_id');

        $isSubscribed = $this->subscriptionService->isSubscribed($userId, $creatorId);

        $result = $isSubscribed
            ? ['subscribed' => $this->subscriptionService->unsubscribe($userId, $creatorId)]
            : ['subscribed' => (bool) $this->subscriptionService->subscribe($userId, $creatorId)];

        return $this->successResponse($result, $isSubscribed ? 'Unsubscribed successfully' : 'Subscribed successfully');
    }

    public function subscribers(Request $request): JsonResponse
    {
        $subscribers = $this->subscriptionService->getSubscribers(
            $request->user()->id,
            $request->integer('per_page', 20)
        );

        return $this->successResponse($subscribers, 'Subscribers retrieved successfully');
    }

    public function subscriptions(Request $request): JsonResponse
    {
        $subscriptions = $this->subscriptionService->getSubscriptions(
            $request->user()->id,
            $request->integer('per_page', 20)
        );

        return $this->successResponse($subscriptions, 'Subscriptions retrieved successfully');
    }

    public function count(int $creatorId): JsonResponse
    {
        $count = $this->subscriptionService->getSubscriberCount($creatorId);

        return $this->successResponse(['count' => $count], 'Subscriber count retrieved successfully');
    }

    public function toggleNotification(Request $request, int $creatorId): JsonResponse
    {
        $enabled = $this->subscriptionService->toggleNotification($request->user()->id, $creatorId);

        return $this->successResponse(['notification_enabled' => $enabled], 'Notification preference updated');
    }
}
