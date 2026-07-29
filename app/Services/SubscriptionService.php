<?php

namespace App\Services;

use App\Models\Subscription;
use App\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionService
{
    public function __construct(private Subscription $subscription, private SubscriptionRepository $subscriptionRepository) {}

    public function subscribe(int $subscriberId, int $creatorId): Subscription
    {
        try {
            if ($subscriberId === $creatorId) {
                abort(400, 'You cannot subscribe to yourself');
            }

            return DB::transaction(function () use ($subscriberId, $creatorId) {
                $existing = $this->subscriptionRepository->findBySubscriberAndCreator($subscriberId, $creatorId);

                if ($existing) {
                    return $existing;
                }

                $subscription = $this->subscriptionRepository->create([
                    'subscriber_id' => $subscriberId,
                    'creator_id' => $creatorId,
                    'notification_enabled' => true,
                ]);

                Log::info('User subscribed', ['subscriber_id' => $subscriberId, 'creator_id' => $creatorId]);

                return $subscription;
            });
        } catch (\Exception $e) {
            Log::error('Subscribe failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function unsubscribe(int $subscriberId, int $creatorId): bool
    {
        try {
            return DB::transaction(function () use ($subscriberId, $creatorId) {
                $subscription = $this->subscriptionRepository->findBySubscriberAndCreator($subscriberId, $creatorId);

                if (!$subscription) {
                    return false;
                }

                $result = $this->subscriptionRepository->delete($subscription);

                Log::info('User unsubscribed', ['subscriber_id' => $subscriberId, 'creator_id' => $creatorId]);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('Unsubscribe failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function isSubscribed(int $subscriberId, int $creatorId): bool
    {
        return $this->subscriptionRepository->exists($subscriberId, $creatorId);
    }

    public function getSubscribers(int $creatorId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->subscriptionRepository->getSubscribers($creatorId, $perPage);
    }

    public function getSubscriptions(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->subscriptionRepository->getSubscriptions($userId, $perPage);
    }

    public function getSubscriberCount(int $creatorId): int
    {
        return $this->subscriptionRepository->getSubscriberCount($creatorId);
    }

    public function toggleNotification(int $subscriberId, int $creatorId): bool
    {
        try {
            return DB::transaction(function () use ($subscriberId, $creatorId) {
                $subscription = $this->subscriptionRepository->findBySubscriberAndCreator($subscriberId, $creatorId);

                if (!$subscription) {
                    abort(404, 'Subscription not found');
                }

                $subscription->update([
                    'notification_enabled' => !$subscription->notification_enabled,
                ]);

                Log::info('Subscription notification toggled', [
                    'subscriber_id' => $subscriberId,
                    'creator_id' => $creatorId,
                    'enabled' => $subscription->notification_enabled,
                ]);

                return $subscription->notification_enabled;
            });
        } catch (\Exception $e) {
            Log::error('Toggle notification failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
