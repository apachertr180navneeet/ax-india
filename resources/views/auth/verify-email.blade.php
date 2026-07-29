@extends('web.layouts.app')
@section('title', 'Verify Email - AX India')
@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-6 col-lg-5" style="max-width:450px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <i class="fas fa-envelope fa-3x text-primary mb-3"></i>
                    <h4 class="fw-bold mb-3">Verify Your Email</h4>
                    <p class="text-muted mb-4">A verification link has been sent to your email address. Please check your inbox and click the link to activate your account.</p>
                    <p class="text-muted small mb-3">Didn't receive the email?</p>
                    <form action="{{ route('verification.resend') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Resend Verification Email</button>
                    </form>
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mt-3 small mb-0">A new verification link has been sent.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
