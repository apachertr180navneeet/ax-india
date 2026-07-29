@extends('layouts.app')
@section('title', 'Forgot Password - AX India')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5" style="max-width:450px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-2"><i class="fas fa-lock text-danger me-1"></i>Forgot Password</h4>
                    <p class="text-muted text-center small mb-4">Enter your email and we'll send you a reset link.</p>
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
                    </form>
                    <p class="text-center mt-3 mb-0 small"><a href="{{ route('login') }}">Back to Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
