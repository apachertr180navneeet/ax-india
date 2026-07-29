<?php

namespace App\Repositories;

use App\Models\Playlist;
use Illuminate\Pagination\LengthAwarePaginator;

class PlaylistRepository
{
    public function __construct(private Playlist $model) {}

    public function findById(int $id): ?Playlist
    {
        return $this->model->with('user')->find($id);
    }

    public function findByUser(int $userId, int $perPage): LengthAwarePaginator
    {
        return $this->model->where('user_id', $userId)
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Playlist
    {
        return $this->model->create($data);
    }

    public function update(Playlist $playlist, array $data): bool
    {
        return $playlist->update($data);
    }

    public function delete(Playlist $playlist): bool
    {
        return $playlist->delete();
    }

    public function addVideo(Playlist $playlist, int $videoId): void
    {
        $maxOrder = $playlist->videos()->max('sort_order') ?? 0;
        $playlist->videos()->syncWithoutDetaching([$videoId => ['sort_order' => $maxOrder + 1]]);
    }

    public function removeVideo(Playlist $playlist, int $videoId): void
    {
        $playlist->videos()->detach($videoId);
    }

    public function getVideos(Playlist $playlist, int $perPage): LengthAwarePaginator
    {
        return $playlist->videos()
            ->with(['user', 'category'])
            ->published()
            ->approved()
            ->paginate($perPage);
    }
}
