<?php

namespace App\Repositories;

use App\Models\Video;
use App\Models\VideoLike;
use App\Enums\VideoStatus;
use App\Enums\LikeType;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class VideoRepository
{
    public function __construct(private Video $model) {}

    public function findById(int $id): ?Video
    {
        return $this->model->with(['user', 'category', 'tags', 'files'])->find($id);
    }

    public function findPublished(array $filters, int $perPage): LengthAwarePaginator
    {
        $query = $this->model->published()->approved()->with(['user', 'category', 'tags']);

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        if (!empty($filters['visibility'])) {
            $query->where('visibility', $filters['visibility']);
        }

        if (!empty($filters['sort'])) {
            match ($filters['sort']) {
                'oldest' => $query->oldest(),
                'popular' => $query->orderBy('views_count', 'desc'),
                'trending' => $query->orderBy('views_count', 'desc')->orderBy('likes_count', 'desc'),
                default => $query->latest(),
            };
        } else {
            $query->latest();
        }

        return $query->paginate($perPage);
    }

    public function findByUser(int $userId, int $perPage): LengthAwarePaginator
    {
        return $this->model->where('user_id', $userId)
            ->with(['category', 'tags'])
            ->latest()
            ->paginate($perPage);
    }

    public function getTrending(int $limit): LengthAwarePaginator
    {
        return $this->model->published()->approved()
            ->with(['user', 'category'])
            ->orderBy('views_count', 'desc')
            ->orderBy('likes_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getRelated(Video $video, int $limit)
    {
        return $this->model->published()->approved()
            ->where('id', '!=', $video->id)
            ->where(function ($query) use ($video) {
                if ($video->category_id) {
                    $query->where('category_id', $video->category_id);
                }
                if ($video->tags->isNotEmpty()) {
                    $tagIds = $video->tags->pluck('id')->toArray();
                    $query->orWhereHas('tags', function ($q) use ($tagIds) {
                        $q->whereIn('tags.id', $tagIds);
                    });
                }
            })
            ->with(['user', 'category'])
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function search(string $query, int $perPage): LengthAwarePaginator
    {
        return $this->model->published()->approved()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->with(['user', 'category', 'tags'])
            ->latest()
            ->paginate($perPage);
    }

    public function incrementViews(int $videoId): void
    {
        $this->model->where('id', $videoId)->increment('views_count');
    }

    public function toggleLike(int $userId, int $videoId, string $type): VideoLike
    {
        $existing = VideoLike::where('user_id', $userId)
            ->where('video_id', $videoId)
            ->first();

        if ($existing) {
            if ($existing->type->value === $type) {
                $existing->delete();
                $this->updateLikeCount($videoId);
                $deleted = new VideoLike();
                $deleted->wasRecentlyDeleted = true;
                return $deleted;
            }
            $existing->update(['type' => $type]);
        } else {
            $existing = VideoLike::create([
                'user_id' => $userId,
                'video_id' => $videoId,
                'type' => $type,
            ]);
        }

        $this->updateLikeCount($videoId);
        return $existing->fresh();
    }

    public function updateLikeCount(int $videoId): void
    {
        $video = $this->model->withCount([
            'likes as likes_count' => fn($q) => $q->where('type', LikeType::Like),
            'likes as dislikes_count' => fn($q) => $q->where('type', LikeType::Dislike),
        ])->find($videoId);

        if ($video) {
            $video->saveQuietly();
        }
    }

    public function create(array $data): Video
    {
        return $this->model->create($data);
    }

    public function update(Video $video, array $data): bool
    {
        return $video->update($data);
    }

    public function delete(Video $video): bool
    {
        return $video->delete();
    }
}
