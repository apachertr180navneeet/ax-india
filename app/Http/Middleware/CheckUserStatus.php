<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Your account is deactivated',
                    ], 403);
                }

                return redirect()->route('user.login.get')->withErrors(['error' => 'Your account is deactivated.']);
            }
        }

        return $next($request);
    }
}
