<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_like_unique_constraint()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $comment = Comment::factory()->create();

        CommentLike::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        CommentLike::create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);
    }

    public function test_comment_like_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $like = CommentLike::create([
            'user_id' => $user->id,
            'comment_id' => Comment::factory()->create()->id,
        ]);

        $this->assertInstanceOf(User::class, $like->user);
        $this->assertEquals($user->id, $like->user->id);
    }

    public function test_comment_like_belongs_to_comment()
    {
        $comment = Comment::factory()->create();
        $like = CommentLike::create([
            'user_id' => User::withoutEvents(fn () => User::factory()->create())->id,
            'comment_id' => $comment->id,
        ]);

        $this->assertInstanceOf(Comment::class, $like->comment);
        $this->assertEquals($comment->id, $like->comment->id);
    }
}
