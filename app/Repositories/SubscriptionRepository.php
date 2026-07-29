<?php

namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Pagination\LengthAwarePaginator;

class SubscriptionRepository
{
    public function __construct(private Subscription $model) {}

    public function findBySubscriberAndCreator(int $subscriberId, int $creatorId): ?Subscription
    {
        return $this->model->where('subscriber_id', $subscriberId)
            ->where('creator_id', $creatorId)
            ->first();
    }

    public function create(array $data): Subscription
    {
        return $this->model->create($data);
    }

    public function delete(Subscription $subscription): bool
    {
        return $subscription->delete();
    }

    public function getSubscribers(int $creatorId, int $perPage): LengthAwarePaginator
    {
        return $this->model->where('creator_id', $creatorId)
            ->with('subscriber')
            ->latest()
            ->paginate($perPage);
    }

    public function getSubscriptions(int $userId, int $perPage): LengthAwarePaginator
    {
        return $this->model->where('subscriber_id', $userId)
            ->with('creator')
            ->latest()
            ->paginate($perPage);
    }

    public function getSubscriberCount(int $creatorId): int
    {
        return $this->model->where('creator_id', $creatorId)->count();
    }

    public function exists(int $subscriberId, int $creatorId): bool
    {
        return $this->model->where('subscriber_id', $subscriberId)
            ->where('creator_id', $creatorId)
            ->exists();
    }
}
