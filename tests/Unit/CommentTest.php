<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $comment->user);
        $this->assertEquals($user->id, $comment->user->id);
    }

    public function test_comment_belongs_to_video()
    {
        $video = Video::factory()->create();
        $comment = Comment::factory()->create(['video_id' => $video->id]);

        $this->assertInstanceOf(Video::class, $comment->video);
        $this->assertEquals($video->id, $comment->video->id);
    }

    public function test_comment_has_replies()
    {
        $comment = Comment::factory()->create();
        $reply = Comment::factory()->create([
            'parent_id' => $comment->id,
            'video_id' => $comment->video_id,
        ]);

        $this->assertTrue($comment->replies->contains($reply));
    }

    public function test_comment_belongs_to_parent()
    {
        $parent = Comment::factory()->create();
        $child = Comment::factory()->create([
            'parent_id' => $parent->id,
            'video_id' => $parent->video_id,
        ]);

        $this->assertInstanceOf(Comment::class, $child->parent);
        $this->assertEquals($parent->id, $child->parent->id);
    }
}
