<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Advertisement;

class AdminAdvertisementController extends Controller
{
    public function index()
    {
        $ads = Advertisement::latest()->paginate(15);
        return view('admin.advertisements.index', compact('ads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:banner,pre_roll,sidebar',
            'target_url' => 'nullable|url',
        ]);

        Advertisement::create([
            'title' => $request->title,
            'type' => $request->type,
            'target_url' => $request->target_url,
            'is_active' => true,
        ]);

        return back()->with('success', 'Advertisement created successfully.');
    }

    public function toggle($id)
    {
        $ad = Advertisement::findOrFail($id);
        $ad->update(['is_active' => !$ad->is_active]);
        return back()->with('success', 'Advertisement status updated.');
    }

    public function destroy($id)
    {
        $ad = Advertisement::findOrFail($id);
        $ad->delete();
        return back()->with('success', 'Advertisement deleted successfully.');
    }
}
