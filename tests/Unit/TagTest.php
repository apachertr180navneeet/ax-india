<?php

namespace Tests\Unit;

use App\Models\Tag;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TagTest extends TestCase
{
    use RefreshDatabase;

    public function test_tag_has_many_videos()
    {
        $video = Video::factory()->create();
        $tag = Tag::factory()->create();
        $video->tags()->syncWithoutDetaching([$tag->id]);

        $this->assertTrue($tag->fresh()->videos->contains($video));
    }
}
