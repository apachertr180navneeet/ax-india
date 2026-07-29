<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface SubscriptionRepositoryInterface
{
    public function subscribe(int $subscriberId, int $creatorId): Model;

    public function unsubscribe(int $subscriberId, int $creatorId): bool;

    public function isSubscribed(int $subscriberId, int $creatorId): bool;

    public function getSubscribers(int $creatorId): Collection;

    public function getSubscriptions(int $userId): Collection;

    public function getSubscriberCount(int $creatorId): int;

    public function toggleNotification(int $subscriberId, int $creatorId): ?Model;
}
