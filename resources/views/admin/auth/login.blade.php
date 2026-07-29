@extends('admin.layouts.login_layout')
@section('content')

<div class="auth-wrapper" style="min-height: 100vh;">
    <div class="auth-card text-center" style="max-width: 420px; margin: auto;">
        <div class="logo-icon mx-auto mb-3" style="width: 54px; height: 54px; background: linear-gradient(135deg, var(--accent-red), #3730a3); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(171, 196, 255, 0.6);">
            <i class="bi bi-shield-lock-fill fs-3 text-white"></i>
        </div>
        <h2 class="auth-title">Admin Portal</h2>
        <p class="auth-subtitle mb-4">Sign in to manage {{ config('app.name') }}</p>

        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-3 mb-4">{{ session('error') }}</div>
        @endif

        <form action="{{ route('admin.login.post') }}" method="POST">
            @csrf
            <div class="auth-input-group text-start">
                <label for="email"><i class="bi bi-envelope me-1"></i> Email</label>
                <input type="email" id="email" name="email" class="auth-input" placeholder="admin@axindia.com" required autofocus>
            </div>

            <div class="auth-input-group text-start">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="mb-0"><i class="bi bi-lock me-1"></i> Password</label>
                    <a href="{{ route('admin.forget.password.get') }}" class="small" style="color: var(--accent-blue);">Forgot?</a>
                </div>
                <input type="password" id="password" name="password" class="auth-input" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required>
            </div>

            <button type="submit" class="btn-custom btn-primary-custom w-100 py-2.5 mt-3" style="font-size: 1rem;">
                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
            </button>
        </form>

        <p class="mt-4 mb-0 text-secondary small">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>

@endsection
