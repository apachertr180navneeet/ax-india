<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CommentRepositoryInterface
{
    public function getByVideo(int $videoId): Collection;

    public function create(array $data): Model;

    public function update(int $id, array $data): ?Model;

    public function delete(int $id): bool;

    public function getReplies(int $commentId): Collection;

    public function pin(int $id): ?Model;

    public function unpin(int $id): ?Model;
}
