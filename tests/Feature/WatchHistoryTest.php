<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use App\Models\WatchHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WatchHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_watch_history_is_tracked()
    {
        $user = User::withoutEvents(fn () => User::factory()->create());
        $video = Video::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/history/' . $video->id, [
                'duration' => 120.5,
                'resume_at' => 30.0,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Watch tracked successfully',
            ]);

        $this->assertDatabaseHas('watch_histories', [
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
    }

    public function test_user_can_clear_history()
    {
        $user = User::withoutEvents(fn () => User::factory()->create());
        $video = Video::factory()->create();

        WatchHistory::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'watched_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/history');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Watch history cleared successfully',
            ]);

        $this->assertDatabaseMissing('watch_histories', [
            'user_id' => $user->id,
        ]);
    }

    public function test_user_can_remove_single_history_item()
    {
        $user = User::withoutEvents(fn () => User::factory()->create());
        $video = Video::factory()->create();

        WatchHistory::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'watched_at' => now(),
        ]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/history/' . $video->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Item removed from watch history',
            ]);

        $this->assertDatabaseMissing('watch_histories', [
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
    }
}
