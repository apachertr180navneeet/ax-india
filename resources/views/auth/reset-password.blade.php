@extends('layouts.app')
@section('title', 'Reset Password - AX India')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5" style="max-width:450px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4"><i class="fas fa-key text-danger me-1"></i>Reset Password</h4>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token ?? '' }}">
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" value="{{ $email ?? old('email') }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
