<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_subscribe_to_creator()
    {
        $user = User::factory()->create();
        $creator = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/subscriptions', [
                'creator_id' => $creator->id,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Subscribed successfully',
            ]);

        $this->assertDatabaseHas('subscriptions', [
            'subscriber_id' => $user->id,
            'creator_id' => $creator->id,
        ]);
    }

    public function test_user_cannot_subscribe_to_self()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/subscriptions', [
                'creator_id' => $user->id,
            ]);

        $response->assertStatus(400);
    }

    public function test_user_can_unsubscribe()
    {
        $user = User::factory()->create();
        $creator = User::factory()->create();

        \App\Models\Subscription::create([
            'subscriber_id' => $user->id,
            'creator_id' => $creator->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/v1/subscriptions', [
                'creator_id' => $creator->id,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Unsubscribed successfully',
            ]);
    }

    public function test_subscription_count_increases()
    {
        $user = User::factory()->create();
        $creator = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/api/v1/subscriptions', [
                'creator_id' => $creator->id,
            ]);

        $response = $this->getJson('/api/v1/subscriptions/' . $creator->id . '/count');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['count' => 1],
            ]);
    }
}
