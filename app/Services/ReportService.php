<?php

namespace App\Services;

use App\Models\Video;
use App\Models\VideoReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportService
{
    public function __construct(private VideoReport $videoReport, private Video $video) {}

    public function reportVideo($user, int $videoId, array $data): VideoReport
    {
        try {
            return DB::transaction(function () use ($user, $videoId, $data) {
                $existing = $this->videoReport->where('user_id', $user->id)
                    ->where('video_id', $videoId)
                    ->where('status', 'pending')
                    ->first();

                if ($existing) {
                    abort(400, 'You have already reported this video');
                }

                $report = $this->videoReport->create([
                    'user_id' => $user->id,
                    'video_id' => $videoId,
                    'reason' => $data['reason'],
                    'description' => $data['description'] ?? null,
                    'status' => 'pending',
                ]);

                Log::info('Video reported', ['report_id' => $report->id, 'video_id' => $videoId]);

                return $report;
            });
        } catch (\Exception $e) {
            Log::error('Report video failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getReports(?string $status = null, int $perPage = 15): LengthAwarePaginator
    {
        $query = $this->videoReport->with(['user', 'video', 'reviewer']);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->latest()->paginate($perPage);
    }

    public function reviewReport(int $adminId, int $reportId, string $status, ?string $note = null): VideoReport
    {
        try {
            return DB::transaction(function () use ($adminId, $reportId, $status, $note) {
                $report = $this->videoReport->findOrFail($reportId);

                $report->update([
                    'status' => $status,
                    'reviewed_by' => $adminId,
                    'reviewed_at' => now(),
                    'review_note' => $note,
                ]);

                Log::info('Report reviewed', ['report_id' => $reportId, 'status' => $status]);

                return $report->fresh();
            });
        } catch (\Exception $e) {
            Log::error('Review report failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function dismissReport(int $adminId, int $reportId): VideoReport
    {
        return $this->reviewReport($adminId, $reportId, 'dismissed');
    }

    public function takeAction(int $adminId, int $reportId): bool
    {
        try {
            return DB::transaction(function () use ($adminId, $reportId) {
                $report = $this->videoReport->with('video')->findOrFail($reportId);

                if ($report->video) {
                    $report->video->delete();
                }

                $report->update([
                    'status' => 'reviewed',
                    'reviewed_by' => $adminId,
                    'reviewed_at' => now(),
                ]);

                Log::info('Action taken on report - video removed', [
                    'report_id' => $reportId,
                    'video_id' => $report->video_id,
                ]);

                return true;
            });
        } catch (\Exception $e) {
            Log::error('Take action on report failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getPendingReports(int $perPage = 15): LengthAwarePaginator
    {
        return $this->videoReport->with(['user', 'video'])
            ->where('status', 'pending')
            ->latest()
            ->paginate($perPage);
    }
}
