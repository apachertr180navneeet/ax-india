<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class AdminVideoModerationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        $query = Video::with('user');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $videos = $query->latest()->paginate(15);
        return view('admin.moderation.index', compact('videos', 'status'));
    }

    public function approve($id)
    {
        $video = Video::findOrFail($id);
        $video->update(['status' => 'approved']);
        return back()->with('success', 'Video has been approved successfully.');
    }

    public function reject(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        $video->update([
            'status' => 'rejected',
            'rejected_reason' => $request->input('rejected_reason', 'Violation of terms')
        ]);
        return back()->with('success', 'Video has been rejected.');
    }
}
