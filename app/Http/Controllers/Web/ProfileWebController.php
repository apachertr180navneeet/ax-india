<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileWebController extends Controller
{
    public function __construct(private readonly ProfileService $profileService) {}

    public function show(string $username): View
    {
        $user = User::whereHas('profile', fn ($q) => $q->where('username', $username))
            ->with('profile', 'videos')
            ->firstOrFail();

        return view('web.profile.show', compact('user'));
    }

    public function settings(): View
    {
        $user = auth()->user()->load('profile');

        return view('web.profile.settings', compact('user'));
    }

    public function updateSettings(UpdateProfileRequest $request): RedirectResponse
    {
        $this->profileService->updateProfile(auth()->id(), $request->validated());

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function updatePassword(\Illuminate\Http\Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!\Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The provided current password does not match.']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::rollbackPasswordHash ?? \Illuminate\Support\Facades\Hash::make($request->new_password)
        ]);

        return redirect()->back()->with('success', 'Password updated successfully.');
    }
}
