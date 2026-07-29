<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class FavoriteService
{
    public function __construct(private Favorite $favorite) {}

    public function addFavorite($user, int $videoId): Favorite
    {
        try {
            return DB::transaction(function () use ($user, $videoId) {
                $existing = $this->favorite->where('user_id', $user->id)
                    ->where('video_id', $videoId)
                    ->first();

                if ($existing) {
                    return $existing;
                }

                $favorite = $this->favorite->create([
                    'user_id' => $user->id,
                    'video_id' => $videoId,
                ]);

                Log::info('Video favorited', ['user_id' => $user->id, 'video_id' => $videoId]);

                return $favorite;
            });
        } catch (\Exception $e) {
            Log::error('Add favorite failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function removeFavorite($user, int $videoId): bool
    {
        try {
            return DB::transaction(function () use ($user, $videoId) {
                $result = $this->favorite->where('user_id', $user->id)
                    ->where('video_id', $videoId)
                    ->delete();

                Log::info('Video unfavorited', ['user_id' => $user->id, 'video_id' => $videoId]);

                return (bool) $result;
            });
        } catch (\Exception $e) {
            Log::error('Remove favorite failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getFavorites(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->favorite->where('user_id', $userId)
            ->with('video.user')
            ->latest()
            ->paginate($perPage);
    }

    public function isFavorited($user, int $videoId): bool
    {
        return $this->favorite->where('user_id', $user->id)
            ->where('video_id', $videoId)
            ->exists();
    }

    public function toggleFavorite($user, int $videoId): array
    {
        $existing = $this->favorite->where('user_id', $user->id)
            ->where('video_id', $videoId)
            ->first();

        if ($existing) {
            $this->removeFavorite($user, $videoId);
            return ['favorited' => false];
        }

        $this->addFavorite($user, $videoId);
        return ['favorited' => true];
    }
}
