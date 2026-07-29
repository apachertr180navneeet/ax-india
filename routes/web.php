<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\VideoWatchController;
use App\Http\Controllers\Web\ProfileWebController;
use App\Http\Controllers\Web\ChannelController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminUserController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/watch/{slug}', [VideoWatchController::class, 'show'])->name('watch');
Route::get('/channel/{username}', [ChannelController::class, 'show'])->name('channel');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings', [ProfileWebController::class, 'settings'])->name('settings');
    Route::put('/settings', [ProfileWebController::class, 'updateSettings'])->name('settings.update');
    Route::get('/profile/{username}', [ProfileWebController::class, 'show'])->name('profile.show');
});

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
    });
});
