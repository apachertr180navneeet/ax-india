<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Video;
use Illuminate\Database\Eloquent\Collection;

class TagRepository
{
    public function __construct(private Tag $model) {}

    public function getAll(): Collection
    {
        return $this->model->orderBy('name')->get();
    }

    public function getPopular(int $limit): Collection
    {
        return $this->model->withCount('videos')
            ->orderBy('videos_count', 'desc')
            ->limit($limit)
            ->get();
    }

    public function findBySlug(string $slug): ?Tag
    {
        return $this->model->where('slug', $slug)->first();
    }

    public function firstOrCreate(string $name): Tag
    {
        return $this->model->firstOrCreate(
            ['name' => $name],
            ['slug' => \Illuminate\Support\Str::slug($name)]
        );
    }

    public function syncVideoTags(Video $video, array $tagNames): void
    {
        $tagIds = [];
        foreach ($tagNames as $name) {
            $tag = $this->firstOrCreate(trim($name));
            $tagIds[] = $tag->id;
        }
        $video->tags()->sync($tagIds);
    }
}
