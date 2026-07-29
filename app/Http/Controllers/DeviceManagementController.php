<?php

namespace App\Http\Controllers;

use App\Models\UserDevice;
use Illuminate\Http\Request;

class DeviceManagementController extends Controller
{
    public function index(Request $request)
    {
        $devices = UserDevice::where('user_id', auth()->id())
            ->orderBy('last_active_at', 'desc')
            ->get();

        return view('settings.devices', compact('devices'));
    }

    public function revoke(Request $request, $id)
    {
        $device = UserDevice::where('user_id', auth()->id())->findOrFail($id);
        
        if ($device->is_current_device) {
            return back()->with('error', 'Cannot revoke current active session.');
        }

        $device->delete();

        return back()->with('success', 'Device session revoked successfully.');
    }
}
