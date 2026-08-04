<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class AdminSecurityBackupController extends Controller
{
    public function index(): View
    {
        $encryption = [
            'at_rest' => true,
            'in_transit' => true,
            'algorithm' => 'AES-256-GCM',
            'key_rotation' => '90 days',
            'last_rotated' => '12 Jul 2026',
        ];

        $backups = [
            ['id' => 1, 'name' => 'daily-2026-08-03', 'size' => '2.4 GB', 'type' => 'Full', 'status' => 'Success', 'time' => 'Today, 03:00 AM'],
            ['id' => 2, 'name' => 'daily-2026-08-02', 'size' => '2.3 GB', 'type' => 'Full', 'status' => 'Success', 'time' => 'Yesterday, 03:00 AM'],
            ['id' => 3, 'name' => 'daily-2026-08-01', 'size' => '2.3 GB', 'type' => 'Full', 'status' => 'Success', 'time' => '2 days ago'],
            ['id' => 4, 'name' => 'weekly-2026-07-27', 'size' => '2.8 GB', 'type' => 'Weekly', 'status' => 'Success', 'time' => '1 week ago'],
            ['id' => 5, 'name' => 'daily-2026-07-26', 'size' => '2.2 GB', 'type' => 'Full', 'status' => 'Failed', 'time' => '8 days ago'],
        ];

        return view('admin.security.index', compact('encryption', 'backups'));
    }
}
