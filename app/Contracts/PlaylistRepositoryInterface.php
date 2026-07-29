<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface PlaylistRepositoryInterface
{
    public function getByUser(int $userId): Collection;

    public function create(array $data): Model;

    public function update(int $id, array $data): ?Model;

    public function delete(int $id): bool;

    public function addVideo(int $playlistId, int $videoId): void;

    public function removeVideo(int $playlistId, int $videoId): void;

    public function getVideos(int $playlistId): LengthAwarePaginator;
}
