<?php

namespace App\Http\Controllers\Web\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Video;
use App\Models\Subscription;

class CreatorDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Metrics
        $totalVideos = Video::where('user_id', $user->id)->count();
        $totalViews = Video::where('user_id', $user->id)->sum('views_count');
        $totalLikes = Video::where('user_id', $user->id)->sum('likes_count');
        $totalSubscribers = Subscription::where('creator_id', $user->id)->count();
        $totalEarnings = Video::where('user_id', $user->id)->sum('earnings');

        // Recent Uploads
        $recentVideos = Video::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('creator.dashboard', compact(
            'totalVideos',
            'totalViews',
            'totalLikes',
            'totalSubscribers',
            'totalEarnings',
            'recentVideos'
        ));
    }
}
