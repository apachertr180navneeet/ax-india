<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CreatorVerification;

class AdminVerificationController extends Controller
{
    public function index()
    {
        $requests = CreatorVerification::with('user')->latest()->paginate(15);
        return view('admin.verifications.index', compact('requests'));
    }

    public function approve($id)
    {
        $verification = CreatorVerification::findOrFail($id);
        $verification->update(['status' => 'approved']);
        return back()->with('success', 'Creator verification approved.');
    }

    public function reject(Request $request, $id)
    {
        $verification = CreatorVerification::findOrFail($id);
        $verification->update([
            'status' => 'rejected',
            'admin_notes' => $request->input('notes', 'Verification documents did not meet requirements.')
        ]);
        return back()->with('success', 'Creator verification rejected.');
    }
}
