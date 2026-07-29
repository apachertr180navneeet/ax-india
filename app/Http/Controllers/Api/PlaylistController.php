<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\UpdatePlaylistRequest;
use App\Http\Requests\AddVideoToPlaylistRequest;
use App\Models\Playlist;
use App\Services\PlaylistService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaylistController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly PlaylistService $playlistService) {}

    public function index(Request $request): JsonResponse
    {
        $playlists = $this->playlistService->getUserPlaylists(
            $request->user()->id,
            $request->integer('per_page', 10)
        );

        return $this->successResponse($playlists, 'Playlists retrieved successfully');
    }

    public function store(StorePlaylistRequest $request): JsonResponse
    {
        $playlist = $this->playlistService->create($request->user(), $request->validated());

        return $this->successResponse($playlist, 'Playlist created successfully', 201);
    }

    public function show(int $id): JsonResponse
    {
        $playlist = Playlist::with('videos.user')->findOrFail($id);

        return $this->successResponse($playlist, 'Playlist retrieved successfully');
    }

    public function update(UpdatePlaylistRequest $request, int $id): JsonResponse
    {
        $playlist = $this->playlistService->update($request->user(), $id, $request->validated());

        return $this->successResponse($playlist, 'Playlist updated successfully');
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->playlistService->delete($request->user(), $id);

        return $this->successResponse(null, 'Playlist deleted successfully');
    }

    public function addVideo(AddVideoToPlaylistRequest $request, int $id): JsonResponse
    {
        $this->playlistService->addVideo(
            $request->user(),
            $id,
            $request->integer('video_id')
        );

        return $this->successResponse(null, 'Video added to playlist successfully');
    }

    public function removeVideo(Request $request, int $id, int $videoId): JsonResponse
    {
        $this->playlistService->removeVideo($request->user(), $id, $videoId);

        return $this->successResponse(null, 'Video removed from playlist successfully');
    }

    public function videos(Request $request, int $id): JsonResponse
    {
        $videos = $this->playlistService->getPlaylistVideos(
            $id,
            $request->integer('per_page', 10)
        );

        return $this->successResponse($videos, 'Playlist videos retrieved successfully');
    }
}
