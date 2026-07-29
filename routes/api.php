<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PlaylistController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\WatchHistoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\ShareController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\NotificationController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
        Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:3,1');
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->name('verification.verify');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/change-password', [AuthController::class, 'changePassword']);
            Route::get('/user', [AuthController::class, 'user']);
            Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail']);
        });
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [ProfileController::class, 'show']);
        Route::put('/profile', [ProfileController::class, 'update']);
        Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar']);
        Route::post('/profile/cover', [ProfileController::class, 'updateCover']);
        Route::get('/profile/privacy-settings', [ProfileController::class, 'privacySettings']);
        Route::put('/profile/privacy-settings', [ProfileController::class, 'updatePrivacySettings']);
        Route::get('/profile/notification-settings', [ProfileController::class, 'notificationSettings']);
        Route::put('/profile/notification-settings', [ProfileController::class, 'updateNotificationSettings']);
    });

    Route::get('/videos', [VideoController::class, 'index']);
    Route::get('/videos/trending', [VideoController::class, 'trending']);
    Route::get('/videos/{slug}', [VideoController::class, 'show']);
    Route::get('/videos/{id}/related', [VideoController::class, 'related']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/videos', [VideoController::class, 'store']);
        Route::put('/videos/{id}', [VideoController::class, 'update']);
        Route::delete('/videos/{id}', [VideoController::class, 'destroy']);
        Route::post('/videos/{id}/like', [VideoController::class, 'like']);
    });
    Route::post('/videos/{id}/view', [VideoController::class, 'view']);

    Route::get('/videos/{videoId}/comments', [CommentController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/videos/{videoId}/comments', [CommentController::class, 'store']);
        Route::put('/comments/{id}', [CommentController::class, 'update']);
        Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
        Route::post('/comments/{id}/like', [CommentController::class, 'like']);
        Route::post('/comments/{id}/pin', [CommentController::class, 'pin']);
        Route::post('/comments/{id}/unpin', [CommentController::class, 'unpin']);
        Route::get('/comments/{id}/replies', [CommentController::class, 'replies']);
    });

    Route::get('/playlists/{id}', [PlaylistController::class, 'show']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/playlists', [PlaylistController::class, 'index']);
        Route::post('/playlists', [PlaylistController::class, 'store']);
        Route::put('/playlists/{id}', [PlaylistController::class, 'update']);
        Route::delete('/playlists/{id}', [PlaylistController::class, 'destroy']);
        Route::post('/playlists/{id}/videos', [PlaylistController::class, 'addVideo']);
        Route::delete('/playlists/{id}/videos/{videoId}', [PlaylistController::class, 'removeVideo']);
        Route::get('/playlists/{id}/videos', [PlaylistController::class, 'videos']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/subscriptions', [SubscriptionController::class, 'toggle']);
        Route::get('/subscriptions/subscribers', [SubscriptionController::class, 'subscribers']);
        Route::get('/subscriptions/subscriptions', [SubscriptionController::class, 'subscriptions']);
        Route::post('/subscriptions/{creatorId}/notification', [SubscriptionController::class, 'toggleNotification']);
    });
    Route::get('/subscriptions/{creatorId}/count', [SubscriptionController::class, 'count']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/history', [WatchHistoryController::class, 'index']);
        Route::post('/history/{videoId}', [WatchHistoryController::class, 'track']);
        Route::delete('/history', [WatchHistoryController::class, 'clearAll']);
        Route::delete('/history/{videoId}', [WatchHistoryController::class, 'remove']);
        Route::get('/history/continue-watching', [WatchHistoryController::class, 'continueWatching']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::post('/favorites', [FavoriteController::class, 'toggle']);
        Route::get('/favorites/{videoId}/check', [FavoriteController::class, 'check']);
    });

    Route::get('/search', [SearchController::class, 'search']);
    Route::get('/search/suggestions', [SearchController::class, 'suggestions']);
    Route::get('/search/trending', [SearchController::class, 'trending']);

    Route::get('/share/{videoId}', [ShareController::class, 'share']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/reports', [ReportController::class, 'store']);
        Route::get('/reports', [ReportController::class, 'index']);
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount']);
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    });

    Route::prefix('admin')->middleware(['auth:sanctum', 'role:admin'])->group(function () {
        Route::get('/reports', [ReportController::class, 'allReports']);
        Route::post('/reports/{id}/review', [ReportController::class, 'review']);
        Route::put('/videos/{id}/status', [VideoController::class, 'updateStatus']);
    });
});
