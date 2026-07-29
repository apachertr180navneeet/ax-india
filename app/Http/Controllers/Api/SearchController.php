<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Services\SearchService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly SearchService $searchService) {}

    public function search(SearchRequest $request): JsonResponse
    {
        $results = $this->searchService->search(
            $request->input('q'),
            $request->only('category_id', 'duration', 'sort'),
            $request->integer('per_page', 12)
        );

        if ($request->user()) {
            $this->searchService->logSearch(
                $request->user()->id,
                $request->input('q'),
                $results->total()
            );
        }

        return $this->successResponse($results, 'Search results retrieved successfully');
    }

    public function suggestions(SearchRequest $request): JsonResponse
    {
        $suggestions = $this->searchService->getSuggestions(
            $request->input('q'),
            $request->integer('limit', 5)
        );

        return $this->successResponse($suggestions, 'Suggestions retrieved successfully');
    }

    public function trending(): JsonResponse
    {
        $trending = $this->searchService->getTrendingSearches();

        return $this->successResponse($trending, 'Trending searches retrieved successfully');
    }
}
