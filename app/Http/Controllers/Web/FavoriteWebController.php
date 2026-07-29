<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\FavoriteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FavoriteWebController extends Controller
{
    public function __construct(
        private readonly FavoriteService $favoriteService,
    ) {}

    public function index(Request $request): View
    {
        $favorites = $this->favoriteService->getUserFavorites($request->user()->id, 15);
        return view('web.favorites.index', compact('favorites'));
    }

    public function toggle(Request $request): JsonResponse
    {
        $request->validate(['video_id' => 'required|exists:videos,id']);
        $result = $this->favoriteService->toggleFavorite($request->user()->id, $request->video_id);
        return response()->json([
            'status' => 'success',
            'is_favorite' => $result['is_favorite'],
            'message' => $result['message'],
        ]);
    }
}
