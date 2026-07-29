<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_favorite_unique_constraint()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $video = Video::factory()->create();

        Favorite::create(['user_id' => $user->id, 'video_id' => $video->id]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Favorite::create(['user_id' => $user->id, 'video_id' => $video->id]);
    }

    public function test_favorite_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $favorite = Favorite::create([
            'user_id' => $user->id,
            'video_id' => Video::factory()->create()->id,
        ]);

        $this->assertInstanceOf(User::class, $favorite->user);
        $this->assertEquals($user->id, $favorite->user->id);
    }

    public function test_favorite_belongs_to_video()
    {
        $video = Video::factory()->create();
        $favorite = Favorite::create([
            'user_id' => User::withoutEvents(fn () => User::factory()->create())->id,
            'video_id' => $video->id,
        ]);

        $this->assertInstanceOf(Video::class, $favorite->video);
        $this->assertEquals($video->id, $favorite->video->id);
    }
}
