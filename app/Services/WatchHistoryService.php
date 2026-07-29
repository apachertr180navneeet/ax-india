<?php

namespace App\Services;

use App\Models\WatchHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class WatchHistoryService
{
    public function __construct(private WatchHistory $watchHistory) {}

    public function trackWatch($user, int $videoId, float $duration, float $resumeAt): WatchHistory
    {
        try {
            return DB::transaction(function () use ($user, $videoId, $duration, $resumeAt) {
                $history = $this->watchHistory->updateOrCreate(
                    ['user_id' => $user->id, 'video_id' => $videoId],
                    [
                        'watched_at' => now(),
                        'watch_duration' => $duration,
                        'resume_at' => $resumeAt,
                        'completed' => false,
                    ]
                );

                return $history;
            });
        } catch (\Exception $e) {
            Log::error('Track watch failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getHistory(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->watchHistory->where('user_id', $userId)
            ->with('video.user')
            ->latest('watched_at')
            ->paginate($perPage);
    }

    public function getContinueWatching(int $userId, int $limit = 10)
    {
        return $this->watchHistory->where('user_id', $userId)
            ->where('completed', false)
            ->where('resume_at', '>', 0)
            ->with('video.user')
            ->latest('watched_at')
            ->limit($limit)
            ->get();
    }

    public function markCompleted($user, int $videoId): void
    {
        try {
            $this->watchHistory->where('user_id', $user->id)
                ->where('video_id', $videoId)
                ->update(['completed' => true, 'resume_at' => 0]);
        } catch (\Exception $e) {
            Log::error('Mark watch completed failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function clearHistory(int $userId): void
    {
        try {
            $this->watchHistory->where('user_id', $userId)->delete();
            Log::info('Watch history cleared', ['user_id' => $userId]);
        } catch (\Exception $e) {
            Log::error('Clear watch history failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function removeFromHistory(int $userId, int $videoId): void
    {
        try {
            $this->watchHistory->where('user_id', $userId)
                ->where('video_id', $videoId)
                ->delete();
        } catch (\Exception $e) {
            Log::error('Remove from watch history failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
