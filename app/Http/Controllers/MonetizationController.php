<?php

namespace App\Http\Controllers;

use App\Models\CreatorMonetization;
use App\Models\MonetizationEarning;
use App\Models\BrandCollaboration;
use App\Models\CopyrightClaim;
use App\Models\Video;
use Illuminate\Http\Request;

class MonetizationController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $monetization = CreatorMonetization::firstOrCreate(['user_id' => $user->id]);

        // Evaluate eligibility criteria
        $subscribersCount = $user->subscribers()->count();
        $totalViews = Video::where('user_id', $user->id)->sum('views_count');
        $copyrightViolations = CopyrightClaim::whereHas('video', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->where('status', 'upheld')->count();

        $isVerified = (bool) $user->creatorVerification && $user->creatorVerification->status === 'approved';
        $meetsCriteria = $subscribersCount >= 1000 && $totalViews >= 40000 && $copyrightViolations === 0;

        $earnings = MonetizationEarning::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        $brandDeals = BrandCollaboration::where('creator_id', $user->id)
            ->latest()
            ->get();

        return view('creator.monetization', compact('monetization', 'subscribersCount', 'totalViews', 'copyrightViolations', 'isVerified', 'meetsCriteria', 'earnings', 'brandDeals'));
    }

    public function apply(Request $request)
    {
        $user = auth()->user();
        $monetization = CreatorMonetization::where('user_id', $user->id)->firstOrFail();

        $monetization->update([
            'status' => 'pending_approval',
            'applied_at' => now(),
        ]);

        return back()->with('success', 'Monetization application submitted successfully!');
    }
}
