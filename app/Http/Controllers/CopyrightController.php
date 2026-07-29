<?php

namespace App\Http\Controllers;

use App\Models\CopyrightClaim;
use App\Models\Video;
use Illuminate\Http\Request;

class CopyrightController extends Controller
{
    public function store(Request $request, Video $video)
    {
        $request->validate([
            'claim_type' => 'required|in:audio,visual,full_content',
            'reason' => 'required|string|max:1000',
            'copyright_owner_name' => 'required|string|max:255',
        ]);

        CopyrightClaim::create([
            'video_id' => $video->id,
            'claimant_id' => auth()->id(),
            'claim_type' => $request->claim_type,
            'reason' => $request->reason,
            'copyright_owner_name' => $request->copyright_owner_name,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Copyright claim submitted successfully and is currently under review.');
    }
}
