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
}
