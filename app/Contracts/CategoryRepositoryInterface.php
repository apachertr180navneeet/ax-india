<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CategoryRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?Model;

    public function findBySlug(string $slug): ?Model;

    public function create(array $data): Model;

    public function update(int $id, array $data): ?Model;

    public function delete(int $id): bool;

    public function getActive(): Collection;

    public function getWithVideoCount(): Collection;
}
