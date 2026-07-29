<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\VideoWatchController;
use App\Http\Controllers\Web\VideoUploadController;
use App\Http\Controllers\Web\ProfileWebController;
use App\Http\Controllers\Web\ChannelController;
use App\Http\Controllers\Web\HistoryWebController;
use App\Http\Controllers\Web\FavoriteWebController;
use App\Http\Controllers\Web\PlaylistWebController;
use App\Http\Controllers\Web\SubscriptionWebController;
use App\Http\Controllers\Web\SearchWebController;
use App\Http\Controllers\Web\NotificationWebController;
use App\Http\Controllers\Web\DownloadController;
use App\Http\Controllers\Web\ShortsController;
use App\Http\Controllers\Web\AuthWebController;
use App\Http\Controllers\Web\Creator\CreatorDashboardController;
use App\Http\Controllers\Web\Creator\CreatorAnalyticsController;
use App\Http\Controllers\Web\Creator\CreatorSubscriberController;
use App\Http\Controllers\Web\Creator\LiveStreamController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVideoModerationController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminAdvertisementController;
use App\Http\Controllers\Admin\AdminVerificationController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminPaymentController;

// Public Web Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/watch/{slug}', [VideoWatchController::class, 'show'])->name('watch');
Route::get('/channel/{username}', [ChannelController::class, 'show'])->name('channel');
Route::get('/search', [SearchWebController::class, 'index'])->name('search');
Route::get('/download/{id}', [DownloadController::class, 'download'])->name('videos.download');
Route::get('/shorts', [ShortsController::class, 'index'])->name('shorts.index');

// Guest Web Routes (Login, Register)
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthWebController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthWebController::class, 'login']);
    Route::get('/register', [AuthWebController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthWebController::class, 'register']);
});

Route::post('/logout', [AuthWebController::class, 'logout'])->name('logout')->middleware('auth');

// Authenticated Web Routes
Route::middleware(['auth'])->group(function () {
    // Video Upload
    Route::get('/upload', [VideoUploadController::class, 'showForm'])->name('videos.upload');
    Route::post('/upload', [VideoUploadController::class, 'store'])->name('videos.store');

    // Profile & Settings
    Route::get('/settings', [ProfileWebController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileWebController::class, 'updateSettings'])->name('settings.update');
    Route::get('/profile/{username}', [ProfileWebController::class, 'show'])->name('profile.show');

    // Watch History
    Route::get('/history', [HistoryWebController::class, 'index'])->name('history.index');
    Route::delete('/history', [HistoryWebController::class, 'clear'])->name('history.clear');
    Route::delete('/history/{videoId}', [HistoryWebController::class, 'remove'])->name('history.remove');

    // Favorites
    Route::get('/favorites', [FavoriteWebController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle', [FavoriteWebController::class, 'toggle'])->name('favorites.toggle');

    // Playlists
    Route::get('/playlists', [PlaylistWebController::class, 'index'])->name('playlists.index');
    Route::get('/playlists/{id}', [PlaylistWebController::class, 'show'])->name('playlists.show');
    Route::post('/playlists', [PlaylistWebController::class, 'store'])->name('playlists.store');
    Route::post('/playlists/{id}/videos', [PlaylistWebController::class, 'addVideo'])->name('playlists.videos.add');
    Route::delete('/playlists/{id}/videos/{videoId}', [PlaylistWebController::class, 'removeVideo'])->name('playlists.videos.remove');
    Route::delete('/playlists/{id}', [PlaylistWebController::class, 'destroy'])->name('playlists.destroy');

    // Subscriptions
    Route::get('/subscriptions', [SubscriptionWebController::class, 'index'])->name('subscriptions.index');
    Route::post('/subscriptions/toggle', [SubscriptionWebController::class, 'toggle'])->name('subscriptions.toggle');

    // Notifications
    Route::get('/notifications', [NotificationWebController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationWebController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationWebController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Security & Device Management
    Route::get('/settings/devices', [\App\Http\Controllers\DeviceManagementController::class, 'index'])->name('settings.devices');
    Route::delete('/settings/devices/{id}', [\App\Http\Controllers\DeviceManagementController::class, 'revoke'])->name('settings.devices.revoke');

    // Copyright Protection
    Route::post('/videos/{video}/copyright-claim', [\App\Http\Controllers\CopyrightController::class, 'store'])->name('videos.copyright-claim');

    // Creator Studio Routes
    Route::prefix('creator')->name('creator.')->group(function () {
        Route::get('/dashboard', [CreatorDashboardController::class, 'index'])->name('dashboard');
        Route::get('/analytics', [CreatorAnalyticsController::class, 'index'])->name('analytics');
        Route::get('/subscribers', [CreatorSubscriberController::class, 'index'])->name('subscribers');
        Route::get('/live', [LiveStreamController::class, 'index'])->name('live');
        Route::post('/live/key', [LiveStreamController::class, 'generateStreamKey'])->name('live.key');

        // Creator Monetization Program
        Route::get('/monetization', [\App\Http\Controllers\MonetizationController::class, 'index'])->name('monetization');
        Route::post('/monetization/apply', [\App\Http\Controllers\MonetizationController::class, 'apply'])->name('monetization.apply');
    });
});

// Admin Web Routes
Route::name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [AdminAuthController::class, 'index']);
    Route::get('login', [AdminAuthController::class, 'login'])->name('login');
    Route::post('login', [AdminAuthController::class, 'postLogin'])->name('login.post');
    Route::get('forget-password', [AdminAuthController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('forget-password', [AdminAuthController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('reset-password/{token}', [AdminAuthController::class, 'showResetPasswordForm'])->name('reset.password.get');
    Route::post('reset-password', [AdminAuthController::class, 'submitResetPasswordForm'])->name('reset.password.post');

    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', [AdminAuthController::class, 'adminDashboard'])->name('dashboard');
        Route::get('change-password', [AdminAuthController::class, 'changePassword'])->name('change.password');
        Route::post('update-password', [AdminAuthController::class, 'updatePassword'])->name('update.password');
        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AdminAuthController::class, 'adminProfile'])->name('profile');
        Route::post('profile', [AdminAuthController::class, 'updateAdminProfile'])->name('update.profile');

        Route::name('users.')->group(function () {
            Route::get("users", [AdminUserController::class, 'index'])->name('index');
            Route::get("users/alluser", [AdminUserController::class, 'getallUser'])->name('alluser');
            Route::post("users/status", [AdminUserController::class, 'userStatus'])->name('status');
            Route::delete("users/delete/{id}", [AdminUserController::class, 'destroy'])->name('destroy');
            Route::get("users/{id}", [AdminUserController::class, 'show'])->name('show');
        });

        // Video Moderation
        Route::get('moderation', [AdminVideoModerationController::class, 'index'])->name('moderation.index');
        Route::post('moderation/{id}/approve', [AdminVideoModerationController::class, 'approve'])->name('moderation.approve');
        Route::post('moderation/{id}/reject', [AdminVideoModerationController::class, 'reject'])->name('moderation.reject');

        // Category Management
        Route::get('categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::delete('categories/{id}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

        // Advertisement Management
        Route::get('advertisements', [AdminAdvertisementController::class, 'index'])->name('advertisements.index');
        Route::post('advertisements', [AdminAdvertisementController::class, 'store'])->name('advertisements.store');
        Route::post('advertisements/{id}/toggle', [AdminAdvertisementController::class, 'toggle'])->name('advertisements.toggle');
        Route::delete('advertisements/{id}', [AdminAdvertisementController::class, 'destroy'])->name('advertisements.destroy');

        // Creator Verifications
        Route::get('verifications', [AdminVerificationController::class, 'index'])->name('verifications.index');
        Route::post('verifications/{id}/approve', [AdminVerificationController::class, 'approve'])->name('verifications.approve');
        Route::post('verifications/{id}/reject', [AdminVerificationController::class, 'reject'])->name('verifications.reject');

        // Reports Management
        Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::delete('reports/{id}/resolve', [AdminReportController::class, 'resolve'])->name('reports.resolve');

        // Payments & Payouts
        Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::post('payments/{id}/process', [AdminPaymentController::class, 'process'])->name('payments.process');
    });
});
