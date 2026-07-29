<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    public function subscribe(User $user, User $creator): bool
    {
        return $user->id !== $creator->id;
    }

    public function unsubscribe(User $user, Subscription $subscription): bool
    {
        return $user->id === $subscription->subscriber_id;
    }
}
