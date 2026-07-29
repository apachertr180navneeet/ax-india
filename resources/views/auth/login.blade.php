@extends('web.layouts.app')
@section('title', 'Sign In - AX India')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 440px;">
        <div class="auth-header">
            <div class="logo-icon mx-auto mb-3" style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--accent-red), #cc0029); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(255, 0, 51, 0.4);">
                <i class="bi bi-play-btn-fill fs-3 text-white"></i>
            </div>
            <h2 class="auth-title">Welcome Back</h2>
            <p class="auth-subtitle">Sign in to your AX-India account</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success border-0 rounded-3 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="auth-input-group">
                <label for="email"><i class="bi bi-envelope me-1"></i> Email or Phone</label>
                <input type="text" id="email" name="email" class="auth-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email or phone" required autofocus>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="auth-input-group">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="mb-0"><i class="bi bi-lock me-1"></i> Password</label>
                </div>
                <input type="password" id="password" name="password" class="auth-input @error('password') is-invalid @enderror" placeholder="••••••••" required>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check m-0">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label text-secondary small" for="remember">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn-custom btn-primary-custom w-100 py-2.5 mb-3" style="font-size: 1rem;">
                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
            </button>

            <div class="text-center mt-3 pt-3 border-top border-secondary">
                <p class="mb-0 text-secondary small">
                    Don't have an account? <a href="{{ route('register') }}" class="fw-bold" style="color: var(--accent-red);">Create one now</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
