<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LastActiveAtMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->last_active_at || Carbon::parse($user->last_active_at)->diffInMinutes(now()) >= 5) {
                $user->forceFill([
                    'last_active_at' => now(),
                ])->save();
            }
        }

        return $next($request);
    }
}
