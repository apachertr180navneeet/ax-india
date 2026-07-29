<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_comment()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/videos/' . $video->id . '/comments', [
                'body' => 'Great video!',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Comment added successfully',
            ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'video_id' => $video->id,
            'body' => 'Great video!',
        ]);
    }

    public function test_user_can_edit_own_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->putJson('/api/v1/comments/' . $comment->id, [
                'body' => 'Updated comment body',
            ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Comment updated successfully',
            ]);

        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => 'Updated comment body',
        ]);
    }

    public function test_user_can_delete_own_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->deleteJson('/api/v1/comments/' . $comment->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Comment deleted successfully',
            ]);
    }

    public function test_user_can_like_comment()
    {
        $user = User::factory()->create();
        $comment = Comment::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/comments/' . $comment->id . '/like');

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Comment like toggled successfully',
            ]);
    }

    public function test_video_owner_can_pin_comment()
    {
        $owner = User::factory()->create();
        $video = Video::factory()->create(['user_id' => $owner->id]);
        $comment = Comment::factory()->create(['video_id' => $video->id]);

        $response = $this->actingAs($owner)
            ->postJson('/api/v1/comments/' . $comment->id . '/pin');

        $response->assertStatus(200);
    }
}
