<?php

namespace App\Http\Controllers\Web\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Models\Subscription;

class CreatorAnalyticsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $topVideos = Video::where('user_id', $user->id)
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        $totalViews = Video::where('user_id', $user->id)->sum('views_count');
        $totalLikes = Video::where('user_id', $user->id)->sum('likes_count');
        $totalComments = Video::where('user_id', $user->id)->sum('comments_count');
        $totalEarnings = Video::where('user_id', $user->id)->sum('earnings');

        return view('creator.analytics', compact(
            'topVideos',
            'totalViews',
            'totalLikes',
            'totalComments',
            'totalEarnings'
        ));
    }
}
