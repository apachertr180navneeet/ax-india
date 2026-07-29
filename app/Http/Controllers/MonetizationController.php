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

        $earningsQuery = MonetizationEarning::where('user_id', $user->id);

        $totalGrossEarnings = (clone $earningsQuery)->sum('amount');
        $totalTaxDeducted = (clone $earningsQuery)->sum('tax_deducted');
        $totalNetEarnings = (clone $earningsQuery)->sum('net_amount');

        // Revenue Breakdown by Source
        $revenueSources = [
            'ads' => (clone $earningsQuery)->whereIn('type', ['ads', 'ad_revenue'])->sum('net_amount'),
            'premium_membership' => (clone $earningsQuery)->whereIn('type', ['premium_membership', 'video_share', 'premium_content'])->sum('net_amount'),
            'brand_sponsorship' => (clone $earningsQuery)->whereIn('type', ['brand_sponsorship', 'brand_collaboration'])->sum('net_amount'),
            'fan_contribution' => (clone $earningsQuery)->whereIn('type', ['fan_contribution', 'live_gift', 'fan_subscription'])->sum('net_amount'),
            'platform_incentive' => (clone $earningsQuery)->whereIn('type', ['platform_incentive', 'performance_bonus'])->sum('net_amount'),
        ];

        // Monthly Payout Status
        $pendingPayout = (clone $earningsQuery)->where('status', 'pending')->sum('net_amount');
        $paidOutTotal = (clone $earningsQuery)->where('status', 'paid_out')->sum('net_amount');
        $minimumThreshold = $monetization->payout_threshold ?? 100.00;
        $eligibleForPayout = $pendingPayout >= $minimumThreshold;

        $earnings = (clone $earningsQuery)->latest()->paginate(10);

        $brandDeals = BrandCollaboration::where('creator_id', $user->id)
            ->latest()
            ->get();

        return view('creator.monetization', compact(
            'monetization', 
            'subscribersCount', 
            'totalViews', 
            'copyrightViolations', 
            'isVerified', 
            'meetsCriteria', 
            'earnings', 
            'brandDeals',
            'totalGrossEarnings',
            'totalTaxDeducted',
            'totalNetEarnings',
            'revenueSources',
            'pendingPayout',
            'paidOutTotal',
            'minimumThreshold',
            'eligibleForPayout'
        ));
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

    public function updatePayoutMethod(Request $request)
    {
        $request->validate([
            'payout_method' => 'required|string|in:bank_transfer,upi,paypal',
            'bank_name' => 'required_if:payout_method,bank_transfer|nullable|string|max:100',
            'account_number' => 'required_if:payout_method,bank_transfer|nullable|string|max:50',
            'ifsc_code' => 'required_if:payout_method,bank_transfer|nullable|string|max:20',
            'pan_tax_id' => 'required|string|max:30',
            'upi_id' => 'required_if:payout_method,upi|nullable|string|max:50',
            'paypal_email' => 'required_if:payout_method,paypal|nullable|email|max:100',
        ]);

        $user = auth()->user();
        $monetization = CreatorMonetization::firstOrCreate(['user_id' => $user->id]);

        $payoutDetails = [
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'ifsc_code' => $request->ifsc_code,
            'pan_tax_id' => strtoupper($request->pan_tax_id),
            'upi_id' => $request->upi_id,
            'paypal_email' => $request->paypal_email,
        ];

        $monetization->update([
            'payout_method' => $request->payout_method,
            'payout_details' => $payoutDetails,
        ]);

        return back()->with('success', 'Payout method and tax details updated successfully!');
    }
}
