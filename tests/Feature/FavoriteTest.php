<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_favorite()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/favorites', [
                'video_id' => $video->id,
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
    }

    public function test_user_can_remove_favorite()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        \App\Models\Favorite::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/v1/favorites', [
                'video_id' => $video->id,
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);
    }

    public function test_user_can_view_favorites()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        \App\Models\Favorite::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson('/api/v1/favorites');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }
}
