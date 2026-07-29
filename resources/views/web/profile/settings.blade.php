@extends('web.layouts.app')
@section('title', 'Settings - AX India')
@section('content')
    <div class="row justify-content-center py-3">
        <div class="col-lg-10">
            <h3 class="fw-bold mb-4 text-white"><i class="bi bi-gear-fill me-2 text-danger"></i>Account Settings</h3>
            <ul class="nav nav-tabs mb-4 border-0" id="settingsTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"><i class="bi bi-person me-1"></i>Profile</button></li>
                <li class="nav-item"><button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button"><i class="bi bi-key me-1"></i>Password Security</button></li>
                <li class="nav-item"><button class="nav-link" id="avatar-tab" data-bs-toggle="tab" data-bs-target="#avatar" type="button"><i class="bi bi-camera me-1"></i>Avatar & Cover</button></li>
                <li class="nav-item"><button class="nav-link" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy" type="button"><i class="bi bi-shield-lock me-1"></i>Privacy</button></li>
                <li class="nav-item"><button class="nav-link" id="notifications-tab" data-bs-toggle="tab" data-bs-target="#notifications" type="button"><i class="bi bi-bell me-1"></i>Notifications</button></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ old('username', $profile->username ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Website</label>
                                    <input type="url" name="website" class="form-control" value="{{ old('website', $profile->website ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Bio</label>
                                    <textarea name="bio" class="form-control" rows="3">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select">
                                        <option value="">Select</option>
                                        <option value="male" @selected(($profile->gender ?? '') == 'male')>Male</option>
                                        <option value="female" @selected(($profile->gender ?? '') == 'female')>Female</option>
                                        <option value="other" @selected(($profile->gender ?? '') == 'other')>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="dob" class="form-control" value="{{ old('dob', $profile->dob ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control" value="{{ old('country', $profile->country ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">State</label>
                                    <input type="text" name="state" class="form-control" value="{{ old('state', $profile->state ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" value="{{ old('city', $profile->city ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <h6 class="fw-bold mb-3 text-white"><i class="bi bi-shield-lock me-2 text-danger"></i>Change Password</h6>
                        <form action="{{ route('settings.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Current Password</label>
                                <input type="password" name="current_password" class="form-control" placeholder="Enter current password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="new_password" class="form-control" placeholder="Enter new password (min. 8 characters)" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control" placeholder="Confirm new password" required>
                            </div>
                            <button type="submit" class="btn btn-primary px-4"><i class="bi bi-check-circle me-1"></i>Update Password</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="avatar" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <h6 class="fw-bold mb-3 text-white">Current Avatar</h6>
                        <img src="{{ asset($profile->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle mb-3" width="100" height="100" alt="">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Upload New Avatar</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Avatar</button>
                        </form>
                        <hr class="border-secondary my-4">
                        <h6 class="fw-bold mb-3 text-white">Current Cover</h6>
                        <img src="{{ asset($profile->cover ?? 'images/default-cover.jpg') }}" class="img-fluid rounded mb-3" style="max-height:150px;" alt="">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Upload New Cover</label>
                                <input type="file" name="cover" class="form-control" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Cover</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="privacy" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="show_email" value="1" @checked($profile->show_email ?? false) id="showEmail">
                                <label class="form-check-label text-white" for="showEmail">Show email on profile</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="show_subscribers" value="1" @checked($profile->show_subscribers ?? true) id="showSubs">
                                <label class="form-check-label text-white" for="showSubs">Show subscriber count</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="allow_comments" value="1" @checked($profile->allow_comments ?? true) id="allowComments">
                                <label class="form-check-label text-white" for="allowComments">Allow comments on videos</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Privacy Settings</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="notifications" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="new_subscriber" value="1" @checked($profile->notify_new_subscriber ?? true) id="notifSub">
                                <label class="form-check-label text-white" for="notifSub">New subscriber</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="new_comment" value="1" @checked($profile->notify_new_comment ?? true) id="notifComment">
                                <label class="form-check-label text-white" for="notifComment">New comment on video</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="new_like" value="1" @checked($profile->notify_new_like ?? true) id="notifLike">
                                <label class="form-check-label text-white" for="notifLike">New like on video</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Notification Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
