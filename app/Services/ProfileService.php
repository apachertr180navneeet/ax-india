<?php

namespace App\Services;

use App\Models\Profile;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\UploadedFile;

class ProfileService
{
    use FileUploadTrait;

    public function __construct(private Profile $profile) {}

    public function getProfile(int $userId): ?Profile
    {
        return $this->profile->with('user')->where('user_id', $userId)->first();
    }

    public function updateProfile(int $userId, array $data): Profile
    {
        try {
            return DB::transaction(function () use ($userId, $data) {
                $profile = $this->profile->updateOrCreate(
                    ['user_id' => $userId],
                    collect($data)->except(['avatar', 'cover_image'])->toArray()
                );

                Log::info('Profile updated', ['user_id' => $userId]);

                return $profile->fresh()->load('user');
            });
        } catch (\Exception $e) {
            Log::error('Profile update failed', ['user_id' => $userId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function updateAvatar(int $userId, UploadedFile $file): Profile
    {
        try {
            return DB::transaction(function () use ($userId, $file) {
                $profile = $this->profile->where('user_id', $userId)->firstOrFail();

                if ($profile->avatar) {
                    $this->deleteFile($profile->avatar);
                }

                $path = $this->uploadFile($file, 'avatars');
                $profile->update(['avatar' => $path]);

                Log::info('Avatar updated', ['user_id' => $userId]);

                return $profile->fresh();
            });
        } catch (\Exception $e) {
            Log::error('Avatar update failed', ['user_id' => $userId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function updateCoverImage(int $userId, UploadedFile $file): Profile
    {
        try {
            return DB::transaction(function () use ($userId, $file) {
                $profile = $this->profile->where('user_id', $userId)->firstOrFail();

                if ($profile->cover_image) {
                    $this->deleteFile($profile->cover_image);
                }

                $path = $this->uploadFile($file, 'covers');
                $profile->update(['cover_image' => $path]);

                Log::info('Cover image updated', ['user_id' => $userId]);

                return $profile->fresh();
            });
        } catch (\Exception $e) {
            Log::error('Cover image update failed', ['user_id' => $userId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getPrivacySettings(int $userId): ?array
    {
        $profile = $this->profile->where('user_id', $userId)->first();

        return $profile?->privacy_settings;
    }

    public function updatePrivacySettings(int $userId, array $settings): Profile
    {
        try {
            $profile = $this->profile->where('user_id', $userId)->firstOrFail();
            $profile->update(['privacy_settings' => $settings]);

            Log::info('Privacy settings updated', ['user_id' => $userId]);

            return $profile->fresh();
        } catch (\Exception $e) {
            Log::error('Privacy settings update failed', ['user_id' => $userId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getNotificationSettings(int $userId): ?array
    {
        $profile = $this->profile->where('user_id', $userId)->first();

        return $profile?->notification_settings;
    }

    public function updateNotificationSettings(int $userId, array $settings): Profile
    {
        try {
            $profile = $this->profile->where('user_id', $userId)->firstOrFail();
            $profile->update(['notification_settings' => $settings]);

            Log::info('Notification settings updated', ['user_id' => $userId]);

            return $profile->fresh();
        } catch (\Exception $e) {
            Log::error('Notification settings update failed', ['user_id' => $userId, 'error' => $e->getMessage()]);
            throw $e;
        }
    }
}
