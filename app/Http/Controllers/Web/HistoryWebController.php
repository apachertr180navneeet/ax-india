<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\WatchHistoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistoryWebController extends Controller
{
    public function __construct(
        private readonly WatchHistoryService $historyService,
    ) {}

    public function index(Request $request): View
    {
        $history = $this->historyService->getUserHistory($request->user()->id, 15);
        return view('web.history.index', compact('history'));
    }

    public function clear(Request $request): JsonResponse
    {
        $this->historyService->clearHistory($request->user()->id);
        return response()->json(['status' => 'success', 'message' => 'Watch history cleared successfully.']);
    }

    public function remove(Request $request, int $videoId): JsonResponse
    {
        $this->historyService->removeFromHistory($request->user()->id, $videoId);
        return response()->json(['status' => 'success', 'message' => 'Video removed from watch history.']);
    }
}
