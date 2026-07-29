<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class ShortsController extends Controller
{
    public function index()
    {
        $shorts = Video::where('is_short', true)
            ->where('is_published', true)
            ->with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('shorts.index', compact('shorts'));
    }
}
