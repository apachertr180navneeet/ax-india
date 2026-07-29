<?php

namespace App\Services;

use App\Models\Video;
use App\Models\User;
use App\Models\Tag;
use App\Models\SearchLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SearchService
{
    public function __construct(
        private Video $video,
        private User $user,
        private Tag $tag,
        private SearchLog $searchLog,
    ) {}

    public function search(string $query, array $filters = [], int $perPage = 12): LengthAwarePaginator
    {
        $videoQuery = $this->video->published()->approved()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->with(['user', 'category', 'tags']);

        if (!empty($filters['category_id'])) {
            $videoQuery->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['duration'])) {
            match ($filters['duration']) {
                'short' => $videoQuery->where('duration', '<', 60),
                'medium' => $videoQuery->whereBetween('duration', [60, 600]),
                'long' => $videoQuery->where('duration', '>', 600),
                default => null,
            };
        }

        if (!empty($filters['sort'])) {
            match ($filters['sort']) {
                'oldest' => $videoQuery->oldest(),
                'popular' => $videoQuery->orderBy('views_count', 'desc'),
                default => $videoQuery->latest(),
            };
        } else {
            $videoQuery->latest();
        }

        return $videoQuery->paginate($perPage);
    }

    public function getSuggestions(string $query, int $limit = 5): Collection
    {
        $videos = $this->video->published()->approved()
            ->where('title', 'like', "%{$query}%")
            ->limit($limit)
            ->get(['id', 'title', 'slug', 'thumbnail']);

        if ($videos->count() < $limit) {
            $tags = $this->tag->where('name', 'like', "%{$query}%")
                ->limit($limit - $videos->count())
                ->get(['id', 'name as title', 'slug']);

            $videos = $videos->concat($tags);
        }

        return $videos;
    }

    public function getTrendingSearches(int $limit = 10): Collection
    {
        return $this->searchLog->select('query')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('query')
            ->orderBy('count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function logSearch(int $userId, string $query, int $resultCount): SearchLog
    {
        try {
            return $this->searchLog->create([
                'user_id' => $userId,
                'query' => $query,
                'result_count' => $resultCount,
            ]);
        } catch (\Exception $e) {
            Log::error('Log search failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getSearchHistory(int $userId, int $limit = 10): Collection
    {
        return $this->searchLog->where('user_id', $userId)
            ->latest()
            ->limit($limit)
            ->get();
    }
}
