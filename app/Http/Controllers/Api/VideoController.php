<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadVideoRequest;
use App\Http\Requests\UpdateVideoRequest;
use App\Http\Requests\VideoLikeRequest;
use App\Models\Video;
use App\Services\VideoService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class VideoController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly VideoService $videoService) {}

    public function index(Request $request): JsonResponse
    {
        $videos = $this->videoService->getPublishedVideos(
            $request->only('category', 'sort', 'visibility'),
            $request->integer('per_page', 12)
        );

        return $this->successResponse($videos, 'Videos retrieved successfully');
    }

    public function store(UploadVideoRequest $request): JsonResponse
    {
        $video = $this->videoService->uploadVideo(
            $request->user(),
            $request->validated(),
            $request->file('video'),
            $request->file('thumbnail')
        );

        return $this->successResponse($video, 'Video uploaded successfully', 201);
    }

    public function show(string $slug): JsonResponse
    {
        $video = Video::where('slug', $slug)
            ->with(['user', 'tags', 'category', 'files'])
            ->firstOrFail();

        return $this->successResponse($video, 'Video retrieved successfully');
    }

    public function update(UpdateVideoRequest $request, int $id): JsonResponse
    {
        $video = $this->videoService->updateVideo(
            $id,
            $request->user(),
            $request->validated(),
            $request->file('thumbnail')
        );

        return $this->successResponse($video, 'Video updated successfully');
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $video = Video::findOrFail($id);
        Gate::authorize('delete', $video);

        $this->videoService->deleteVideo($id, $request->user());

        return $this->successResponse(null, 'Video deleted successfully');
    }

    public function like(VideoLikeRequest $request, int $id): JsonResponse
    {
        $this->videoService->toggleLike($request->user(), $id, $request->input('type'));

        return $this->successResponse(null, 'Like updated successfully');
    }

    public function view(int $id): JsonResponse
    {
        $this->videoService->updateViews($id);

        return $this->successResponse(null, 'View counted successfully');
    }

    public function related(int $id): JsonResponse
    {
        $video = Video::findOrFail($id);
        $related = $this->videoService->getRelatedVideos($video);

        return $this->successResponse($related, 'Related videos retrieved successfully');
    }

    public function trending(): JsonResponse
    {
        $videos = $this->videoService->getTrendingVideos();

        return $this->successResponse($videos, 'Trending videos retrieved successfully');
    }
}
