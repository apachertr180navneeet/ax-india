<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\VideoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VideoUploadController extends Controller
{
    public function __construct(
        private readonly VideoService $videoService,
    ) {}

    public function showForm(): View
    {
        $categories = Category::where('is_active', true)->get();
        return view('web.videos.upload', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'category_id' => 'required|exists:categories,id',
            'video_file' => 'required|file|mimes:mp4,mov,avi,mkv|max:204800',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'visibility' => 'required|in:public,private,unlisted',
            'allow_downloads' => 'nullable|boolean',
        ]);

        $video = $this->videoService->uploadVideo($request->user(), $validated, $request->file('video_file'), $request->file('thumbnail'));

        return redirect()->route('watch', $video->slug)->with('success', 'Video uploaded successfully!');
    }
}
