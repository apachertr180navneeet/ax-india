<?php

namespace App\Http\Controllers\Web\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Video;

class LiveStreamController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $liveStream = Video::where('user_id', $user->id)
            ->where('is_live', true)
            ->latest()
            ->first();

        return view('creator.live', compact('liveStream'));
    }

    public function generateStreamKey(Request $request)
    {
        $user = Auth::user();
        $streamKey = 'live_' . Str::random(24);

        $video = Video::create([
            'user_id' => $user->id,
            'title' => $request->input('title', 'Live Stream'),
            'slug' => 'live-' . Str::slug($request->input('title', 'Live Stream')) . '-' . Str::random(6),
            'description' => $request->input('description', ''),
            'file_path' => 'live/stream',
            'is_live' => true,
            'stream_key' => $streamKey,
            'live_status' => 'offline',
            'is_published' => true,
        ]);

        return back()->with('success', 'Live Stream key generated successfully! Key: ' . $streamKey);
    }
}
