<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\SearchService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchWebController extends Controller
{
    public function __construct(
        private readonly SearchService $searchService,
    ) {}

    public function index(Request $request): View
    {
        $query = $request->input('q', '');
        $categoryId = $request->input('category_id');
        $sortBy = $request->input('sort', 'latest');

        $videos = $this->searchService->searchVideos($query, [
            'category_id' => $categoryId,
            'sort_by' => $sortBy,
        ], 12);

        $categories = Category::where('is_active', true)->get();

        return view('web.search.index', compact('videos', 'query', 'categories', 'categoryId', 'sortBy'));
    }
}
