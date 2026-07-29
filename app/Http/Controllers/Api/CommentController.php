<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Services\CommentService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly CommentService $commentService) {}

    public function index(int $videoId): JsonResponse
    {
        $comments = $this->commentService->getVideoComments($videoId);

        return $this->successResponse($comments, 'Comments retrieved successfully');
    }

    public function store(StoreCommentRequest $request, int $videoId): JsonResponse
    {
        $comment = $this->commentService->addComment(
            $request->user(),
            $videoId,
            $request->validated()
        );

        return $this->successResponse($comment, 'Comment added successfully', 201);
    }

    public function update(UpdateCommentRequest $request, int $id): JsonResponse
    {
        $comment = $this->commentService->editComment(
            $request->user(),
            $id,
            $request->input('body')
        );

        return $this->successResponse($comment, 'Comment updated successfully');
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->commentService->deleteComment($request->user(), $id);

        return $this->successResponse(null, 'Comment deleted successfully');
    }

    public function like(Request $request, int $id): JsonResponse
    {
        $this->commentService->toggleLike($request->user(), $id);

        return $this->successResponse(null, 'Comment like toggled successfully');
    }

    public function pin(Request $request, int $id): JsonResponse
    {
        $comment = $this->commentService->pinComment($request->user(), $id);

        return $this->successResponse($comment, 'Comment pinned successfully');
    }

    public function unpin(Request $request, int $id): JsonResponse
    {
        $comment = $this->commentService->unpinComment($request->user(), $id);

        return $this->successResponse($comment, 'Comment unpinned successfully');
    }

    public function replies(int $id): JsonResponse
    {
        $replies = Comment::where('parent_id', $id)
            ->with('user')
            ->latest()
            ->paginate(10);

        return $this->successResponse($replies, 'Replies retrieved successfully');
    }
}
