@extends('layouts.app')
@section('title', 'Create Account - AX India')
@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-7" style="max-width:550px;">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-center fw-bold mb-4"><i class="fas fa-play text-danger me-1"></i>Create Account</h4>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name</label>
                                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" required>
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name</label>
                                <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" required>
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select @error('gender') is-invalid @enderror">
                                    <option value="">Select</option>
                                    <option value="male" @selected(old('gender') == 'male')>Male</option>
                                    <option value="female" @selected(old('gender') == 'female')>Female</option>
                                    <option value="other" @selected(old('gender') == 'other')>Other</option>
                                </select>
                                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob') }}">
                                @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-4">Create Account</button>
                    </form>
                    <p class="text-center mt-3 mb-0 small">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
