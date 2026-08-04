<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminNotificationController extends Controller
{
    /**
     * Admin notifications UI (demo data — UI only).
     */
    public function index(): View
    {
        $stats = [
            'unread' => 7,
            'today' => 12,
            'scheduled' => 3,
            'total' => 48,
        ];

        $notifications = [
            [
                'id' => 1,
                'type' => 'system',
                'icon' => 'bx-error-circle',
                'color' => 'danger',
                'title' => 'High report spike detected',
                'message' => '14 new video reports in the last hour. Review moderation queue.',
                'audience' => 'Admins',
                'time' => '12 minutes ago',
                'is_read' => false,
            ],
            [
                'id' => 2,
                'type' => 'creator',
                'icon' => 'bx-badge-check',
                'color' => 'success',
                'title' => 'Creator verification pending',
                'message' => '5 creators are waiting for verification approval.',
                'audience' => 'Admins',
                'time' => '35 minutes ago',
                'is_read' => false,
            ],
            [
                'id' => 3,
                'type' => 'user',
                'icon' => 'bx-user-plus',
                'color' => 'primary',
                'title' => 'New user registrations',
                'message' => '128 users registered today across web and mobile.',
                'audience' => 'Admins',
                'time' => '1 hour ago',
                'is_read' => false,
            ],
            [
                'id' => 4,
                'type' => 'broadcast',
                'icon' => 'bx-broadcast',
                'color' => 'info',
                'title' => 'Platform maintenance notice sent',
                'message' => 'Broadcast delivered to all active users about Sunday 2 AM downtime.',
                'audience' => 'All Users',
                'time' => '3 hours ago',
                'is_read' => true,
            ],
            [
                'id' => 5,
                'type' => 'payment',
                'icon' => 'bx-dollar-circle',
                'color' => 'warning',
                'title' => 'Payout batch ready',
                'message' => 'Monthly creator payouts for July are ready for processing.',
                'audience' => 'Finance / Admins',
                'time' => '5 hours ago',
                'is_read' => true,
            ],
            [
                'id' => 6,
                'type' => 'system',
                'icon' => 'bx-server',
                'color' => 'secondary',
                'title' => 'Storage usage alert',
                'message' => 'Media storage reached 72% of allocated capacity.',
                'audience' => 'Admins',
                'time' => 'Yesterday',
                'is_read' => true,
            ],
            [
                'id' => 7,
                'type' => 'creator',
                'icon' => 'bx-video',
                'color' => 'primary',
                'title' => 'Moderation backlog cleared',
                'message' => 'All pending video submissions older than 24 hours were reviewed.',
                'audience' => 'Moderators',
                'time' => '2 days ago',
                'is_read' => true,
            ],
        ];

        return view('admin.notifications.index', compact('stats', 'notifications'));
    }
}
