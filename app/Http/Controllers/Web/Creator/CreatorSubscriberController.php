<?php

namespace App\Http\Controllers\Web\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class CreatorSubscriberController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $subscribers = Subscription::where('creator_id', $user->id)
            ->with('subscriber')
            ->latest()
            ->paginate(15);

        return view('creator.subscribers', compact('subscribers'));
    }
}
