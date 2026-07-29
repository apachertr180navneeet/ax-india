<?php

namespace App\Policies;

use App\Enums\VideoStatus;
use App\Enums\VideoVisibility;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;

class VideoPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, Video $video): bool
    {
        if ($video->visibility === VideoVisibility::Public) {
            return true;
        }

        if ($video->visibility === VideoVisibility::Unlisted || $video->visibility === VideoVisibility::Private) {
            return $user->id === $video->user_id;
        }

        return false;
    }

    public function update(User $user, Video $video): bool
    {
        return $user->id === $video->user_id;
    }

    public function delete(User $user, Video $video): bool
    {
        return $user->id === $video->user_id || $user->hasRole('admin');
    }

    public function approve(User $user, Video $video): bool
    {
        return $user->hasRole('admin') || $user->hasPermissionTo('approve videos');
    }

    public function report(User $user, Video $video): bool
    {
        return true;
    }

    public function download(User $user, Video $video): bool
    {
        return $video->allow_downloads;
    }
}
