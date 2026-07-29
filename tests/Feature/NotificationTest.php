<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_has_notifications()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->getJson('/api/v1/notifications');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }

    public function test_user_can_mark_as_read()
    {
        $user = User::factory()->create();
        $notification = $user->notifications()->create([
            'id' => Str::uuid(),
            'type' => 'App\Notifications\NewSubscriber',
            'data' => json_encode(['message' => 'Someone subscribed']),
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/v1/notifications/' . $notification->id . '/read');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Notification marked as read',
            ]);
    }

    public function test_user_can_mark_all_as_read()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/notifications/read-all');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'All notifications marked as read',
            ]);
    }
}
