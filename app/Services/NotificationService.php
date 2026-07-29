<?php

namespace App\Services;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class NotificationService
{
    public function send($notifiable, Notification $notification): void
    {
        try {
            $notifiable->notify($notification);
            Log::info('Notification sent');
        } catch (\Exception $e) {
            Log::error('Send notification failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function markAsRead(string $notificationId): void
    {
        try {
            $user = auth()->user();
            $notification = $user->notifications()->findOrFail($notificationId);
            $notification->markAsRead();
        } catch (\Exception $e) {
            Log::error('Mark notification as read failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function markAllAsRead($user): void
    {
        try {
            $user->unreadNotifications->markAsRead();
        } catch (\Exception $e) {
            Log::error('Mark all notifications as read failed', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function getUserNotifications($user, int $perPage = 20): LengthAwarePaginator
    {
        return $user->notifications()->paginate($perPage);
    }

    public function getUnreadCount($user): int
    {
        return $user->unreadNotifications->count();
    }
}
