<?php

namespace App\Services;

use App\Models\Tag;
use App\Models\Video;
use App\Repositories\TagRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class TagService
{
    public function __construct(private Tag $tag, private TagRepository $tagRepository) {}

    public function getAll(): Collection
    {
        return $this->tagRepository->getAll();
    }

    public function getPopular(int $limit = 20): Collection
    {
        return $this->tagRepository->getPopular($limit);
    }

    public function findBySlug(string $slug): ?Tag
    {
        return $this->tagRepository->findBySlug($slug);
    }

    public function firstOrCreate(string $name): Tag
    {
        return $this->tagRepository->firstOrCreate($name);
    }

    public function syncVideoTags(Video $video, array $tagNames): void
    {
        try {
            $this->tagRepository->syncVideoTags($video, $tagNames);

            Log::info('Tags synced for video', [
                'video_id' => $video->id,
                'tags' => $tagNames,
            ]);
        } catch (\Exception $e) {
            Log::error('Sync video tags failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
