<?php

namespace App\Services;

use App\Models\Favorite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class FavoriteService
{
    public function __construct(private Favorite $favorite) {}

    private function resolveUserId($user): int
    {
        return is_object($user) ? $user->id : (int) $user;
    }

    public function addFavorite($user, int $videoId): Favorite
    {
        $userId = $this->resolveUserId($user);
        try {
            return DB::transaction(function () use ($userId, $videoId) {
                $existing = $this->favorite->where('user_id', $userId)
                    ->where('video_id', $videoId)
                    ->first();

                if ($existing) {
                    return $existing;
                }

                $favorite = $this->favorite->create([
                    'user_id' => $userId,
                    'video_id' => $videoId,
                ]);

                Log::info('Video favorited', ['user_id' => $userId, 'video_id' => $videoId]);

                return $favorite;
            });
        } catch (\Exception $e) {
            Log::error('Add favorite failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function removeFavorite($user, int $videoId): bool
    {
        $userId = $this->resolveUserId($user);
        try {
            return DB::transaction(function () use ($userId, $videoId) {
                $result = $this->favorite->where('user_id', $userId)
                    ->where('video_id', $videoId)
                    ->delete();

                Log::info('Video unfavorited', ['user_id' => $userId, 'video_id' => $videoId]);

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

    public function getUserFavorites(int $userId, int $perPage = 20): LengthAwarePaginator
    {
        return $this->getFavorites($userId, $perPage);
    }

    public function isFavorited($user, int $videoId): bool
    {
        $userId = $this->resolveUserId($user);
        return $this->favorite->where('user_id', $userId)
            ->where('video_id', $videoId)
            ->exists();
    }

    public function toggleFavorite($user, int $videoId): array
    {
        $userId = $this->resolveUserId($user);
        $existing = $this->favorite->where('user_id', $userId)
            ->where('video_id', $videoId)
            ->first();

        if ($existing) {
            $this->removeFavorite($userId, $videoId);
            return [
                'favorited' => false,
                'is_favorite' => false,
                'message' => 'Removed from favorites'
            ];
        }

        $this->addFavorite($userId, $videoId);
        return [
            'favorited' => true,
            'is_favorite' => true,
            'message' => 'Added to favorites'
        ];
    }
}
