<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use App\Models\Favorite;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_favorite_toggle_adds_and_removes()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $this->actingAs($user);

        $add = $this->postJson('/api/v1/favorites', ['video_id' => $video->id]);
        $add->assertStatus(200);
        $this->assertDatabaseHas('favorites', ['user_id' => $user->id, 'video_id' => $video->id]);

        $remove = $this->postJson('/api/v1/favorites', ['video_id' => $video->id]);
        $remove->assertStatus(200);
        $this->assertDatabaseMissing('favorites', ['user_id' => $user->id, 'video_id' => $video->id]);
    }

    public function test_check_favorite_status()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        Favorite::create(['user_id' => $user->id, 'video_id' => $video->id]);

        $response = $this->actingAs($user)
            ->getJson('/api/v1/favorites/' . $video->id . '/check');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => ['is_favorited' => true],
            ]);
    }

    public function test_unauthenticated_cannot_favorite()
    {
        $response = $this->postJson('/api/v1/favorites', ['video_id' => 1]);
        $response->assertStatus(401);
    }
}
