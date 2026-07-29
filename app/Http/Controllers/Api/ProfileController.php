<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateAvatarRequest;
use App\Http\Requests\UpdateCoverRequest;
use App\Http\Requests\UpdatePrivacySettingsRequest;
use App\Http\Requests\UpdateNotificationSettingsRequest;
use App\Services\ProfileService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly ProfileService $profileService) {}

    public function show(): JsonResponse
    {
        $profile = $this->profileService->getProfile(auth()->id());

        return $this->successResponse($profile, 'Profile retrieved successfully');
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $profile = $this->profileService->updateProfile(auth()->id(), $request->validated());

        return $this->successResponse($profile, 'Profile updated successfully');
    }

    public function updateAvatar(UpdateAvatarRequest $request): JsonResponse
    {
        $profile = $this->profileService->updateAvatar(auth()->id(), $request->file('avatar'));

        return $this->successResponse($profile, 'Avatar updated successfully');
    }

    public function updateCover(UpdateCoverRequest $request): JsonResponse
    {
        $profile = $this->profileService->updateCoverImage(auth()->id(), $request->file('cover_image'));

        return $this->successResponse($profile, 'Cover image updated successfully');
    }

    public function privacySettings(): JsonResponse
    {
        $settings = $this->profileService->getPrivacySettings(auth()->id());

        return $this->successResponse($settings, 'Privacy settings retrieved successfully');
    }

    public function updatePrivacySettings(UpdatePrivacySettingsRequest $request): JsonResponse
    {
        $profile = $this->profileService->updatePrivacySettings(auth()->id(), $request->input('settings'));

        return $this->successResponse($profile, 'Privacy settings updated successfully');
    }

    public function notificationSettings(): JsonResponse
    {
        $settings = $this->profileService->getNotificationSettings(auth()->id());

        return $this->successResponse($settings, 'Notification settings retrieved successfully');
    }

    public function updateNotificationSettings(UpdateNotificationSettingsRequest $request): JsonResponse
    {
        $profile = $this->profileService->updateNotificationSettings(auth()->id(), $request->input('settings'));

        return $this->successResponse($profile, 'Notification settings updated successfully');
    }
}
