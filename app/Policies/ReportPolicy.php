<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VideoReport;

class ReportPolicy
{
    public function create(User $user): bool
    {
        return true;
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function review(User $user, VideoReport $report): bool
    {
        return $user->hasRole('admin');
    }
}
