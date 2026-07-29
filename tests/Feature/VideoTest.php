<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use App\Models\VideoLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_cannot_upload()
    {
        $response = $this->postJson('/api/v1/videos', [
            'title' => 'Test Video',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_upload_video()
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->create('video.mp4', 1024);
        $thumbnail = UploadedFile::fake()->image('thumb.jpg');

        $response = $this->actingAs($user)
            ->postJson('/api/v1/videos', [
                'title' => 'My Test Video',
                'description' => 'Video description here',
                'video' => $file,
                'thumbnail' => $thumbnail,
                'category_id' => 1,
                'visibility' => 'public',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }

    public function test_user_can_view_published_videos()
    {
        Video::factory(3)->create(['is_published' => true]);

        $response = $this->getJson('/api/v1/videos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
            ]);
    }

    public function test_user_can_like_video()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/videos/' . $video->id . '/like', [
                'type' => 'like',
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('video_likes', [
            'user_id' => $user->id,
            'video_id' => $video->id,
            'type' => 'like',
        ]);
    }

    public function test_user_cannot_like_same_video_twice()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        VideoLike::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'type' => 'like',
        ]);

        $response = $this->actingAs($user)
            ->postJson('/api/v1/videos/' . $video->id . '/like', [
                'type' => 'like',
            ]);

        $response->assertStatus(200);
    }

    public function test_video_increments_view_count()
    {
        $video = Video::factory()->create(['views_count' => 100]);

        $this->postJson('/api/v1/videos/' . $video->id . '/view');

        $this->assertDatabaseHas('videos', [
            'id' => $video->id,
            'views_count' => 101,
        ]);
    }

    public function test_user_can_update_own_video()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->putJson('/api/v1/videos/' . $video->id, [
                'title' => 'Updated Title',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Video updated successfully',
            ]);
    }

    public function test_user_cannot_update_others_video()
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $video = Video::factory()->create(['user_id' => $owner->id]);

        $response = $this->actingAs($other)
            ->putJson('/api/v1/videos/' . $video->id, [
                'title' => 'Hacked Title',
            ]);

        $response->assertStatus(403);
    }
}
