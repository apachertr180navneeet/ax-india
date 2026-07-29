<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Video;
use App\Models\WatchHistory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WatchHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_watch_history_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $history = WatchHistory::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $history->user);
        $this->assertEquals($user->id, $history->user->id);
    }

    public function test_watch_history_belongs_to_video()
    {
        $video = Video::factory()->create();
        $history = WatchHistory::factory()->create(['video_id' => $video->id]);

        $this->assertInstanceOf(Video::class, $history->video);
        $this->assertEquals($video->id, $history->video->id);
    }

    public function test_watch_history_casts_dates()
    {
        $history = WatchHistory::factory()->create([
            'watched_at' => now(),
            'completed' => true,
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $history->watched_at);
        $this->assertIsBool($history->completed);
    }
}
