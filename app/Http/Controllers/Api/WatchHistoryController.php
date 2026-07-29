<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\WatchHistoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WatchHistoryController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly WatchHistoryService $watchHistoryService) {}

    public function index(Request $request): JsonResponse
    {
        $history = $this->watchHistoryService->getHistory(
            $request->user()->id,
            $request->integer('per_page', 20)
        );

        return $this->successResponse($history, 'Watch history retrieved successfully');
    }

    public function track(Request $request, int $videoId): JsonResponse
    {
        $history = $this->watchHistoryService->trackWatch(
            $request->user(),
            $videoId,
            (float) $request->input('duration', 0),
            (float) $request->input('resume_at', 0)
        );

        return $this->successResponse($history, 'Watch tracked successfully');
    }

    public function clearAll(Request $request): JsonResponse
    {
        $this->watchHistoryService->clearHistory($request->user()->id);

        return $this->successResponse(null, 'Watch history cleared successfully');
    }

    public function remove(Request $request, int $videoId): JsonResponse
    {
        $this->watchHistoryService->removeFromHistory($request->user()->id, $videoId);

        return $this->successResponse(null, 'Item removed from watch history');
    }

    public function continueWatching(Request $request): JsonResponse
    {
        $items = $this->watchHistoryService->getContinueWatching(
            $request->user()->id,
            $request->integer('limit', 10)
        );

        return $this->successResponse($items, 'Continue watching items retrieved successfully');
    }
}
