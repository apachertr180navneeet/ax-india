<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Video;
use App\Repositories\CommentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentService
{
    public function __construct(private Comment $comment, private Video $video, private CommentRepository $commentRepository) {}

    public function addComment($user, int $videoId, array $data): Comment
    {
        try {
            return DB::transaction(function () use ($user, $videoId, $data) {
                $comment = $this->comment->create([
                    'user_id' => $user->id,
                    'video_id' => $videoId,
                    'parent_id' => $data['parent_id'] ?? null,
                    'body' => $data['body'],
                ]);

                $this->video->where('id', $videoId)->increment('comments_count');

                Log::info('Comment added', ['comment_id' => $comment->id, 'video_id' => $videoId]);

                return $comment->load('user');
            });
        } catch (\Exception $e) {
            Log::error('Add comment failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function editComment($user, int $commentId, string $body): Comment
    {
        try {
            return DB::transaction(function () use ($user, $commentId, $body) {
                $comment = $this->comment->where('user_id', $user->id)->findOrFail($commentId);

                $comment->update([
                    'body' => $body,
                    'is_edited' => true,
                ]);

                Log::info('Comment edited', ['comment_id' => $commentId]);

                return $comment->fresh()->load('user');
            });
        } catch (\Exception $e) {
            Log::error('Edit comment failed', ['comment_id' => $commentId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function deleteComment($user, int $commentId): bool
    {
        try {
            return DB::transaction(function () use ($user, $commentId) {
                $comment = $this->comment->where('user_id', $user->id)->findOrFail($commentId);

                $videoId = $comment->video_id;
                $result = $comment->delete();

                $this->video->where('id', $videoId)->decrement('comments_count');

                Log::info('Comment deleted', ['comment_id' => $commentId]);

                return $result;
            });
        } catch (\Exception $e) {
            Log::error('Delete comment failed', ['comment_id' => $commentId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getVideoComments(int $videoId, int $perPage = 10): LengthAwarePaginator
    {
        return $this->commentRepository->getByVideo($videoId, $perPage);
    }

    public function toggleLike($user, int $commentId): void
    {
        try {
            $this->commentRepository->toggleLike($user->id, $commentId);
        } catch (\Exception $e) {
            Log::error('Toggle comment like failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function pinComment($user, int $commentId): Comment
    {
        try {
            return DB::transaction(function () use ($user, $commentId) {
                $comment = $this->comment->findOrFail($commentId);

                $video = $this->video->findOrFail($comment->video_id);

                if ($video->user_id !== $user->id) {
                    abort(403, 'You do not own this video');
                }

                $this->comment->where('video_id', $comment->video_id)
                    ->where('is_pinned', true)
                    ->update(['is_pinned' => false]);

                $comment->update(['is_pinned' => true]);

                Log::info('Comment pinned', ['comment_id' => $commentId]);

                return $comment->fresh();
            });
        } catch (\Exception $e) {
            Log::error('Pin comment failed', ['comment_id' => $commentId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function unpinComment($user, int $commentId): Comment
    {
        try {
            return DB::transaction(function () use ($user, $commentId) {
                $comment = $this->comment->findOrFail($commentId);

                $video = $this->video->findOrFail($comment->video_id);

                if ($video->user_id !== $user->id) {
                    abort(403, 'You do not own this video');
                }

                $comment->update(['is_pinned' => false]);

                Log::info('Comment unpinned', ['comment_id' => $commentId]);

                return $comment->fresh();
            });
        } catch (\Exception $e) {
            Log::error('Unpin comment failed', ['comment_id' => $commentId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function reportComment($user, int $commentId, string $reason): void
    {
        try {
            Log::info('Comment reported', [
                'user_id' => $user->id,
                'comment_id' => $commentId,
                'reason' => $reason,
            ]);
        } catch (\Exception $e) {
            Log::error('Report comment failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
