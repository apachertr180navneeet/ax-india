@extends('web.layouts.app')
@section('title', 'Create Account - AX India')

@section('content')
<div class="auth-wrapper">
    <div class="auth-card" style="max-width: 580px;">
        <div class="auth-header">
            <div class="logo-icon mx-auto mb-3" style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--accent-red), #3730a3); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(171, 196, 255, 0.6);">
                <i class="bi bi-play-btn-fill fs-4 text-white"></i>
            </div>
            <h2 class="auth-title">Join AX-India</h2>
            <p class="auth-subtitle">Create your free account to start watching and sharing</p>
        </div>

        @if ($errors->has('error'))
            <div class="alert alert-danger border-0 rounded-3 mb-4" role="alert">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" class="auth-input @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" placeholder="John" required>
                        @error('first_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" class="auth-input @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" placeholder="Doe" required>
                        @error('last_name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" class="auth-input @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="johndoe" required>
                        @error('username')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="auth-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="john@example.com" required>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" class="auth-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+91 9876543210">
                        @error('phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="auth-input @error('gender') is-invalid @enderror">
                            <option value="">Select Gender</option>
                            <option value="male" @selected(old('gender') == 'male')>Male</option>
                            <option value="female" @selected(old('gender') == 'female')>Female</option>
                            <option value="other" @selected(old('gender') == 'other')>Other</option>
                        </select>
                        @error('gender')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="auth-input @error('password') is-invalid @enderror" placeholder="••••••••" required>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="auth-input-group m-0">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="auth-input" placeholder="••••••••" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-custom btn-primary-custom w-100 py-2.5 mt-4 mb-3" style="font-size: 1rem;">
                <i class="bi bi-person-plus-fill me-2"></i> Create Account
            </button>

            <div class="text-center mt-3 pt-3 border-top">
                <p class="mb-0 text-secondary small">
                    Already have an account? <a href="{{ route('login') }}" class="fw-bold" style="color: var(--text-primary);">Sign In</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
