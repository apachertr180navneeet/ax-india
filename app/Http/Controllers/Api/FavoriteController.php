<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToggleFavoriteRequest;
use App\Services\FavoriteService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly FavoriteService $favoriteService) {}

    public function index(Request $request): JsonResponse
    {
        $favorites = $this->favoriteService->getFavorites(
            $request->user()->id,
            $request->integer('per_page', 20)
        );

        return $this->successResponse($favorites, 'Favorites retrieved successfully');
    }

    public function toggle(ToggleFavoriteRequest $request): JsonResponse
    {
        $result = $this->favoriteService->toggleFavorite(
            $request->user(),
            $request->integer('video_id')
        );

        $message = $result['favorited'] ? 'Video added to favorites' : 'Video removed from favorites';

        return $this->successResponse($result, $message);
    }

    public function check(Request $request, int $videoId): JsonResponse
    {
        $isFavorited = $this->favoriteService->isFavorited($request->user(), $videoId);

        return $this->successResponse(['is_favorited' => $isFavorited], 'Favorite status checked');
    }
}
