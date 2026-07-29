<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Download;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
    public function download(Request $request, int $videoId)
    {
        $video = Video::findOrFail($videoId);

        if (!$video->allow_downloads) {
            return back()->with('error', 'Downloads are not enabled for this video.');
        }

        if ($request->user()) {
            Download::create([
                'user_id' => $request->user()->id,
                'video_id' => $video->id,
                'ip_address' => $request->ip(),
            ]);
        }

        $filePath = storage_path('app/public/' . $video->file_path);

        if (file_exists($filePath)) {
            return response()->download($filePath, $video->slug . '.' . ($video->extension ?? 'mp4'));
        }

        return back()->with('error', 'Video file not found for download.');
    }
}
