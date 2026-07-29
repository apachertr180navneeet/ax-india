<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    public function definition(): array
    {
        $subscriber = User::factory();
        $creator = User::factory();

        return [
            'subscriber_id' => $subscriber,
            'creator_id' => $creator,
            'notification_enabled' => true,
        ];
    }
}
