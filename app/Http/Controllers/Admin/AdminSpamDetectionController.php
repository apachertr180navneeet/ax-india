<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminSpamDetectionController extends Controller
{
    public function index(): View
    {
        $stats = [
            'flagged_today' => 18,
            'auto_removed' => 6,
            'pending_review' => 9,
            'false_positives' => 2,
        ];

        $items = [
            ['id' => 1, 'type' => 'Comment spam', 'content' => 'Buy followers cheap!!! click link...', 'score' => 96, 'user' => 'spam_bot_91', 'status' => 'pending'],
            ['id' => 2, 'type' => 'Video title', 'content' => 'FREE iPhone giveaway 2026!!!', 'score' => 88, 'user' => 'promo_king', 'status' => 'pending'],
            ['id' => 3, 'type' => 'Description', 'content' => 'Visit sketchy-site.xyz for crypto...', 'score' => 91, 'user' => 'link_dropper', 'status' => 'flagged'],
            ['id' => 4, 'type' => 'Comment spam', 'content' => 'Nice video 🔥🔥 check my channel', 'score' => 72, 'user' => 'grow_fast', 'status' => 'pending'],
            ['id' => 5, 'type' => 'Mass mention', 'content' => '@user @user @user spam mentions', 'score' => 84, 'user' => 'mention_bot', 'status' => 'removed'],
        ];

        return view('admin.spam.index', compact('stats', 'items'));
    }
}
