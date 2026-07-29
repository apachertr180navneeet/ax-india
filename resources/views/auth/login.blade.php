@extends('layouts.app')
@section('title', 'Sign In - AX India')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5" style="max-width:450px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4"><i class="fas fa-play text-danger me-1"></i>Sign In</h4>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email or Phone</label>
                            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="remember">
                            <label class="form-check-label" for="remember">Remember me</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Sign In</button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="mb-1 small">Don't have an account? <a href="{{ route('register') }}">Register</a></p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
