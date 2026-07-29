<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Services\CommentService;
use App\Services\VideoService;
use Illuminate\View\View;

class VideoWatchController extends Controller
{
    public function __construct(
        private readonly VideoService $videoService,
        private readonly CommentService $commentService,
    ) {}

    public function show(string $slug): View
    {
        $video = Video::where('slug', $slug)
            ->with(['user.profile', 'category', 'tags', 'files'])
            ->firstOrFail();

        $this->videoService->updateViews($video->id);

        $comments = $this->commentService->getVideoComments($video->id, 10);
        $related = $this->videoService->getRelatedVideos($video, 8);

        return view('web.watch.show', compact('video', 'comments', 'related'));
    }
}
