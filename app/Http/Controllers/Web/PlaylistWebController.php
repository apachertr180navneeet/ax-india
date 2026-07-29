<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Services\PlaylistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlaylistWebController extends Controller
{
    public function __construct(
        private readonly PlaylistService $playlistService,
    ) {}

    public function index(Request $request): View
    {
        $playlists = $this->playlistService->getUserPlaylists($request->user()->id);
        return view('web.playlists.index', compact('playlists'));
    }

    public function show(int $id): View
    {
        $playlist = Playlist::with(['videos', 'user'])->findOrFail($id);
        return view('web.playlists.show', compact('playlist'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'visibility' => 'required|in:public,private,unlisted',
        ]);

        $playlist = $this->playlistService->createPlaylist($request->user()->id, $validated);

        return response()->json([
            'status' => 'success',
            'playlist' => $playlist,
            'message' => 'Playlist created successfully.',
        ]);
    }

    public function addVideo(Request $request, int $id): JsonResponse
    {
        $request->validate(['video_id' => 'required|exists:videos,id']);
        $this->playlistService->addVideoToPlaylist($id, $request->video_id, $request->user()->id);

        return response()->json(['status' => 'success', 'message' => 'Video added to playlist.']);
    }

    public function removeVideo(Request $request, int $id, int $videoId): JsonResponse
    {
        $this->playlistService->removeVideoFromPlaylist($id, $videoId, $request->user()->id);
        return response()->json(['status' => 'success', 'message' => 'Video removed from playlist.']);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $this->playlistService->deletePlaylist($id, $request->user()->id);
        return response()->json(['status' => 'success', 'message' => 'Playlist deleted successfully.']);
    }
}
