<?php

namespace Tests\Unit;

use App\Enums\VideoVisibility;
use App\Models\Playlist;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaylistTest extends TestCase
{
    use RefreshDatabase;

    public function test_playlist_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $playlist = Playlist::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $playlist->user);
        $this->assertEquals($user->id, $playlist->user->id);
    }

    public function test_playlist_has_many_videos()
    {
        $playlist = Playlist::factory()->create();
        $video = Video::factory()->create();
        $playlist->videos()->attach($video, ['sort_order' => 0]);

        $this->assertTrue($playlist->videos->contains($video));
    }

    public function test_playlist_visibility_cast()
    {
        $playlist = Playlist::factory()->create(['visibility' => 'public']);

        $this->assertInstanceOf(VideoVisibility::class, $playlist->visibility);
        $this->assertEquals(VideoVisibility::Public, $playlist->visibility);
    }
}
