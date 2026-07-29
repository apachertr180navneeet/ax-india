<?php

namespace Tests\Unit;

use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_subscription_belongs_to_subscriber()
    {
        $subscriber = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $subscription = Subscription::factory()->create(['subscriber_id' => $subscriber->id]);

        $this->assertInstanceOf(User::class, $subscription->subscriber);
        $this->assertEquals($subscriber->id, $subscription->subscriber->id);
    }

    public function test_subscription_belongs_to_creator()
    {
        $creator = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $subscription = Subscription::factory()->create(['creator_id' => $creator->id]);

        $this->assertInstanceOf(User::class, $subscription->creator);
        $this->assertEquals($creator->id, $subscription->creator->id);
    }

    public function test_subscription_unique_constraint()
    {
        $subscriber = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $creator = User::withoutEvents(function () {
            return User::factory()->create();
        });

        Subscription::create([
            'subscriber_id' => $subscriber->id,
            'creator_id' => $creator->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Subscription::create([
            'subscriber_id' => $subscriber->id,
            'creator_id' => $creator->id,
        ]);
    }
}
