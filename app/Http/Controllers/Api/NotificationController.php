<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly NotificationService $notificationService) {}

    public function index(Request $request): JsonResponse
    {
        $notifications = $this->notificationService->getUserNotifications(
            $request->user(),
            $request->integer('per_page', 20)
        );

        return $this->successResponse($notifications, 'Notifications retrieved successfully');
    }

    public function unreadCount(Request $request): JsonResponse
    {
        $count = $this->notificationService->getUnreadCount($request->user());

        return $this->successResponse(['unread_count' => $count], 'Unread count retrieved successfully');
    }

    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $this->notificationService->markAsRead($id);

        return $this->successResponse(null, 'Notification marked as read');
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $this->notificationService->markAllAsRead($request->user());

        return $this->successResponse(null, 'All notifications marked as read');
    }
}
