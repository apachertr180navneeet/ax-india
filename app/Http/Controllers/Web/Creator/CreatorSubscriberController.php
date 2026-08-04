<?php

namespace App\Http\Controllers\Web\Creator;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CreatorSubscriberController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        try {
            $subscribers = Subscription::where('creator_id', $user->id)
                ->with('subscriber')
                ->latest()
                ->paginate(15);
            $totalSubscribers = Subscription::where('creator_id', $user->id)->count();
        } catch (\Throwable $e) {
            $subscribers = collect();
            $totalSubscribers = 0;
        }

        $newThisWeek = 24;
        $notifOn = '68%';
        $unsubscribed = 9;

        return view('creator.subscribers', compact(
            'subscribers',
            'totalSubscribers',
            'newThisWeek',
            'notifOn',
            'unsubscribed'
        ));
    }
}
