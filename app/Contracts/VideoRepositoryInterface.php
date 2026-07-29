<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface VideoRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Model;

    public function findBySlug(string $slug): ?Model;

    public function create(array $data): Model;

    public function update(int $id, array $data): ?Model;

    public function delete(int $id): bool;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function getPublished(): Collection;

    public function getByCategory(int $categoryId): Collection;

    public function getByUser(int $userId): Collection;

    public function search(string $term): Collection;

    public function getTrending(int $limit = 10): Collection;

    public function getRelated(Model $video, int $limit = 6): Collection;
}
