<?php

namespace Tests\Unit;

use App\Enums\LikeType;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoLike;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoLikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_video_like_unique_constraint()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $video = Video::factory()->create();

        VideoLike::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'type' => 'like',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        VideoLike::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'type' => 'like',
        ]);
    }

    public function test_video_like_type_cast_to_enum()
    {
        $like = VideoLike::factory()->create(['type' => 'like']);

        $this->assertInstanceOf(LikeType::class, $like->type);
        $this->assertEquals(LikeType::Like, $like->type);
    }

    public function test_video_like_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $like = VideoLike::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $like->user);
        $this->assertEquals($user->id, $like->user->id);
    }
}
