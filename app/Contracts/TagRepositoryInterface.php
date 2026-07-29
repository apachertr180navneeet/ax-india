<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TagRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Model;

    public function findBySlug(string $slug): ?Model;

    public function create(array $data): Model;

    public function firstOrCreate(string $name): Model;

    public function getPopular(int $limit = 20): Collection;
}
