<?php

namespace Tests\Feature;

use App\Models\Playlist;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_playlist()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/playlists', [
                'name' => 'My Favorites',
                'description' => 'My favorite videos',
                'visibility' => 'public',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Playlist created successfully',
            ]);

        $this->assertDatabaseHas('playlists', [
            'user_id' => $user->id,
            'name' => 'My Favorites',
        ]);
    }

    public function test_user_can_add_video_to_playlist()
    {
        $user = User::factory()->create();
        $playlist = Playlist::factory()->create(['user_id' => $user->id]);
        $video = Video::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/playlists/' . $playlist->id . '/videos', [
                'video_id' => $video->id,
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Video added to playlist successfully',
            ]);

        $this->assertDatabaseHas('playlist_videos', [
            'playlist_id' => $playlist->id,
            'video_id' => $video->id,
        ]);
    }

    public function test_user_can_remove_video_from_playlist()
    {
        $user = User::factory()->create();
        $playlist = Playlist::factory()->create(['user_id' => $user->id]);
        $video = Video::factory()->create();
        $playlist->videos()->attach($video, ['sort_order' => 0]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/playlists/' . $playlist->id . '/videos/' . $video->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Video removed from playlist successfully',
            ]);

        $this->assertDatabaseMissing('playlist_videos', [
            'playlist_id' => $playlist->id,
            'video_id' => $video->id,
        ]);
    }

    public function test_user_can_delete_own_playlist()
    {
        $user = User::factory()->create();
        $playlist = Playlist::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/playlists/' . $playlist->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Playlist deleted successfully',
            ]);

        $this->assertDatabaseMissing('playlists', ['id' => $playlist->id]);
    }
}
