<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_report_video()
    {
        $user = User::factory()->create();
        $video = Video::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/v1/reports', [
                'video_id' => $video->id,
                'reason' => 'spam',
                'description' => 'This video is spam',
            ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Video reported successfully',
            ]);

        $this->assertDatabaseHas('video_reports', [
            'user_id' => $user->id,
            'video_id' => $video->id,
            'reason' => 'spam',
        ]);
    }

    public function test_unauthenticated_user_cannot_report()
    {
        $response = $this->postJson('/api/v1/reports', [
            'video_id' => 1,
            'reason' => 'spam',
        ]);

        $response->assertStatus(401);
    }
}
