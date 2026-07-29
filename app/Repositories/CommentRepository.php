<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Models\CommentLike;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentRepository
{
    public function __construct(private Comment $model) {}

    public function findById(int $id): ?Comment
    {
        return $this->model->with(['user', 'replies.user'])->find($id);
    }

    public function getByVideo(int $videoId, int $perPage): LengthAwarePaginator
    {
        return $this->model->where('video_id', $videoId)
            ->whereNull('parent_id')
            ->with(['user', 'replies.user', 'replies' => fn($q) => $q->latest()])
            ->latest()
            ->paginate($perPage);
    }

    public function getReplies(int $commentId)
    {
        return $this->model->where('parent_id', $commentId)
            ->with('user')
            ->oldest()
            ->get();
    }

    public function create(array $data): Comment
    {
        return $this->model->create($data);
    }

    public function update(Comment $comment, array $data): bool
    {
        return $comment->update($data);
    }

    public function delete(Comment $comment): bool
    {
        return $comment->delete();
    }

    public function toggleLike(int $userId, int $commentId): ?CommentLike
    {
        $existing = CommentLike::where('user_id', $userId)
            ->where('comment_id', $commentId)
            ->first();

        if ($existing) {
            $existing->delete();
            $this->updateLikeCount($commentId);
            return null;
        }

        $like = CommentLike::create([
            'user_id' => $userId,
            'comment_id' => $commentId,
        ]);

        $this->updateLikeCount($commentId);
        return $like;
    }

    public function updateLikeCount(int $commentId): void
    {
        $this->model->where('id', $commentId)->update([
            'likes_count' => CommentLike::where('comment_id', $commentId)->count(),
        ]);
    }
}
