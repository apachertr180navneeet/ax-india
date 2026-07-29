<?php

namespace Tests\Unit;

use App\Enums\ReportReason;
use App\Enums\ReportStatus;
use App\Models\User;
use App\Models\Video;
use App\Models\VideoReport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VideoReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_report_belongs_to_user()
    {
        $user = User::withoutEvents(function () {
            return User::factory()->create();
        });
        $report = VideoReport::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $report->user);
        $this->assertEquals($user->id, $report->user->id);
    }

    public function test_report_belongs_to_video()
    {
        $video = Video::factory()->create();
        $report = VideoReport::factory()->create(['video_id' => $video->id]);

        $this->assertInstanceOf(Video::class, $report->video);
        $this->assertEquals($video->id, $report->video->id);
    }

    public function test_report_reason_enum_cast()
    {
        $report = VideoReport::factory()->create(['reason' => 'spam']);
        $this->assertInstanceOf(ReportReason::class, $report->reason);
        $this->assertEquals(ReportReason::Spam, $report->reason);
    }

    public function test_report_status_enum_cast()
    {
        $report = VideoReport::factory()->create(['status' => 'pending']);
        $this->assertInstanceOf(ReportStatus::class, $report->status);
        $this->assertEquals(ReportStatus::Pending, $report->status);
    }
}
