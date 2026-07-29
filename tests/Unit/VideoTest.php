<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoTest extends TestCase
{
    use RefreshDatabase;

    public function test_video_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $video = Video::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $video->user);
        $this->assertEquals($user->id, $video->user->id);
    }

    public function test_video_belongs_to_category()
    {
        $category = Category::factory()->create();
        $video = Video::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $video->category);
        $this->assertEquals($category->id, $video->category->id);
    }

    public function test_video_has_many_tags()
    {
        $video = Video::factory()->create();
        $tag = Tag::factory()->create();
        $video->tags()->attach($tag);

        $this->assertTrue($video->tags->contains($tag));
    }

    public function test_video_has_many_comments()
    {
        $video = Video::factory()->create();
        $comment = Comment::factory()->create(['video_id' => $video->id]);

        $this->assertTrue($video->comments->contains($comment));
    }

    public function test_video_uses_soft_deletes()
    {
        $video = Video::factory()->create();
        $video->delete();

        $this->assertSoftDeleted($video);
    }

    public function test_video_has_slug()
    {
        $video = Video::factory()->create();
        $this->assertNotNull($video->slug);
    }

    public function test_video_published_scope()
    {
        Video::factory()->create(['is_published' => true]);
        Video::factory()->create(['is_published' => false]);

        $this->assertEquals(1, Video::published()->count());
    }

    public function test_video_formatted_duration()
    {
        $video = Video::factory()->create(['duration' => 125.5]);
        $this->assertIsNumeric($video->duration);
        $this->assertEquals(125.5, $video->duration);
    }
}
