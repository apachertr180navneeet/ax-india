@extends('web.layouts.app')
@section('title', 'Forgot Password - AX India')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 440px;">
        <div class="auth-header">
            <div class="logo-icon mx-auto mb-3" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--almond-silk), var(--almond-cream)); border: 1px solid var(--bone); border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(213, 189, 175, 0.4);">
                <i class="bi bi-key-fill fs-4" style="color: var(--text-primary);"></i>
            </div>
            <h2 class="auth-title">Reset Password</h2>
            <p class="auth-subtitle">Enter your email address to receive a password reset link</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success border-0 rounded-3 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="auth-input-group mb-4">
                <label for="email"><i class="bi bi-envelope me-1"></i> Email Address</label>
                <input type="email" id="email" name="email" class="auth-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="john@example.com" required autofocus>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-custom btn-primary-custom w-100 py-2.5 mb-3" style="font-size: 1rem;">
                <i class="bi bi-send-fill me-2"></i> Send Reset Link
            </button>

            <div class="text-center mt-3 pt-3 border-top">
                <p class="mb-0 text-secondary small">
                    Remember your password? <a href="{{ route('login') }}" class="fw-bold" style="color: var(--text-primary);">Back to Sign In</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
