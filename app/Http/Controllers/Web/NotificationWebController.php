<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationWebController extends Controller
{
    public function __construct(
        private readonly NotificationService $notificationService,
    ) {}

    public function index(Request $request): View
    {
        $notifications = $this->notificationService->getUserNotifications($request->user()->id, 20);
        return view('web.notifications.index', compact('notifications'));
    }

    public function markAsRead(Request $request, int $id): JsonResponse
    {
        $this->notificationService->markAsRead($id, $request->user()->id);
        return response()->json(['status' => 'success', 'message' => 'Notification marked as read.']);
    }

    public function markAllAsRead(Request $request): JsonResponse
    {
        $this->notificationService->markAllAsRead($request->user()->id);
        return response()->json(['status' => 'success', 'message' => 'All notifications marked as read.']);
    }
}
