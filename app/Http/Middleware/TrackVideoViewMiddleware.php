<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TrackVideoViewMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check()) {
            $route = $request->route();

            if ($route && $route->getName() === 'video.show') {
                $videoId = $route->parameter('video');

                if ($videoId) {
                    $userId = Auth::id();
                    $cacheKey = 'video_view_' . $videoId . '_' . $userId;

                    if (Cache::add($cacheKey, true, 1800)) {
                        $video = \App\Models\Video::find($videoId);
                        if ($video) {
                            $video->increment('views_count');
                        }
                    }
                }
            }
        }

        return $response;
    }
}
