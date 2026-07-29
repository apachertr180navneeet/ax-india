<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\VideoService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(private readonly VideoService $videoService) {}

    public function index(): View
    {
        $trending = $this->videoService->getTrendingVideos(10);
        $videos = $this->videoService->getPublishedVideos([], 20);

        return view('web.home.index', compact('trending', 'videos'));
    }
}
