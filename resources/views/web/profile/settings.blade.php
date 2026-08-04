@extends('web.layouts.app')
@section('title', 'Settings - AX India')
@section('content')
    <div class="container settings-page py-3 px-3 px-md-2">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
            <h3 class="fw-bold mb-4 text-white"><i class="bi bi-gear-fill me-2 text-danger"></i>Account Settings</h3>
            <div class="settings-pill-tabs mb-4" id="settingsTabs" role="tablist">
                <button class="settings-pill-tab active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile"
                    type="button" role="tab" aria-selected="true"><i class="bi bi-person me-1"></i>Profile</button>
                <button class="settings-pill-tab" id="password-tab" data-bs-toggle="tab" data-bs-target="#password"
                    type="button" role="tab" aria-selected="false"><i class="bi bi-key me-1"></i>Password
                    Security</button>
                <button class="settings-pill-tab" id="twofa-tab" data-bs-toggle="tab" data-bs-target="#twofa" type="button"
                    role="tab" aria-selected="false"><i class="bi bi-shield-check me-1"></i>2FA</button>
                <button class="settings-pill-tab" id="avatar-tab" data-bs-toggle="tab" data-bs-target="#avatar"
                    type="button" role="tab" aria-selected="false"><i class="bi bi-camera me-1"></i>Avatar &
                    Cover</button>
                <button class="settings-pill-tab" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy"
                    type="button" role="tab" aria-selected="false"><i
                        class="bi bi-shield-lock me-1"></i>Privacy</button>
                <button class="settings-pill-tab" id="notifications-tab" data-bs-toggle="tab"
                    data-bs-target="#notifications" type="button" role="tab" aria-selected="false"><i
                        class="bi bi-bell me-1"></i>Notifications</button>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="profile" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg"
                        style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{ old('username', $profile->username ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Website</label>
                                    <input type="url" name="website" class="form-control"
                                        value="{{ old('website', $profile->website ?? '') }}">
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
                                    <input type="date" name="dob" class="form-control"
                                        value="{{ old('dob', $profile->dob ?? '') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control"
                                        value="{{ old('country', $profile->country ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">State</label>
                                    <input type="text" name="state" class="form-control"
                                        value="{{ old('state', $profile->state ?? '') }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ old('city', $profile->city ?? '') }}">
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="password" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg"
                        style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <h6 class="fw-bold mb-3 text-white"><i class="bi bi-shield-lock me-2 text-danger"></i>Change
                            Password</h6>
                        <form action="{{ route('settings.password.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Current Password</label>
                                <input type="password" name="current_password" class="form-control"
                                    placeholder="Enter current password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">New Password</label>
                                <input type="password" name="new_password" class="form-control"
                                    placeholder="Enter new password (min. 8 characters)" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" class="form-control"
                                    placeholder="Confirm new password" required>
                            </div>
                            <button type="submit" class="btn btn-primary px-4"><i
                                    class="bi bi-check-circle me-1"></i>Update Password</button>
                        </form>
                    </div>
                </div>

                <div class="tab-pane fade" id="twofa" role="tabpanel">
                    <div class="row g-4" id="settingsTwoFa">
                        <div class="col-lg-8">
                            <div class="card border-0 rounded-4 p-4 shadow-lg h-100"
                                style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                                <div class="d-flex flex-wrap align-items-start justify-content-between gap-2 mb-4">
                                    <div>
                                        <h6 class="fw-bold mb-1 text-white"><i
                                                class="bi bi-shield-check me-2 text-danger"></i>Two-Factor Authentication
                                        </h6>
                                        <p class="text-muted small mb-0">Protect your account with an authenticator app (UI
                                            demo)</p>
                                    </div>
                                    <span class="badge rounded-pill bg-secondary px-3 py-2"
                                        id="settingsTwoFaBadge">Off</span>
                                </div>

                                <div id="settingsTwoFaOff">
                                    <ol class="text-muted small mb-4 ps-3">
                                        <li class="mb-2">Install Google Authenticator, Microsoft Authenticator, or Authy
                                        </li>
                                        <li class="mb-2">Scan the QR code or enter the setup key</li>
                                        <li>Enter the 6-digit code to confirm</li>
                                    </ol>
                                    <div class="row g-4 align-items-center mb-4">
                                        <div class="col-auto">
                                            <div class="rounded-4 d-flex align-items-center justify-content-center"
                                                style="width:140px;height:140px;background:#111;border:1px dashed #555;color:#aaa;">
                                                <div class="text-center">
                                                    <i class="bi bi-qr-code display-6"></i>
                                                    <div class="small mt-2">Demo QR</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label class="form-label small fw-semibold mb-1" for="settingsSetupKey">Setup
                                                key</label>
                                            <div class="settings-setup-key mb-3">
                                                <input type="text" id="settingsSetupKey"
                                                    value="AXIN-DEMO-2FA-KEY-9X7Q" readonly>
                                                <button type="button" id="settingsCopyKey" title="Copy setup key">
                                                    <i class="bi bi-clipboard"></i>
                                                    <span>Copy</span>
                                                </button>
                                            </div>
                                            <label class="form-label small fw-semibold mb-1"
                                                for="settingsOtp">Verification code</label>
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <input type="text" class="form-control settings-otp-input"
                                                    id="settingsOtp" maxlength="6" placeholder="000000"
                                                    inputmode="numeric">
                                                <button type="button" class="btn btn-primary rounded-pill px-4"
                                                    id="settingsEnable2fa"><i class="bi bi-shield-plus me-1"></i>Enable
                                                    2FA</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="settingsTwoFaOn" class="d-none">
                                    <div class="alert alert-success border-0 mb-3 d-flex align-items-center gap-2">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>2FA is enabled on your account.</span>
                                    </div>
                                    <h6 class="text-white fw-bold mb-1">Backup codes</h6>
                                    <p class="text-muted small mb-3">Store these somewhere safe. Each code can be used
                                        once.</p>
                                    <div class="row g-2 mb-4">
                                        @foreach (['492183', '837104', '550291', '118473', '904562', '667320'] as $code)
                                            <div class="col-6 col-md-4">
                                                <code class="d-block text-center text-white px-3 py-2 rounded"
                                                    style="background:#1a1a1a;">{{ $code }}</code>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-outline-secondary rounded-pill"
                                            id="settingsDownloadCodes"><i class="bi bi-download me-1"></i>Download
                                            codes</button>
                                        <a href="{{ route('settings.devices') }}"
                                            class="btn btn-outline-secondary rounded-pill"><i
                                                class="bi bi-laptop me-1"></i>Manage devices</a>
                                        <button type="button" class="btn btn-outline-danger rounded-pill"
                                            id="settingsDisable2fa">Disable 2FA</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card border-0 rounded-4 p-4 shadow-lg mb-3"
                                style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                                <h6 class="fw-bold text-white mb-2"><i class="bi bi-phone me-2 text-danger"></i>SMS backup
                                </h6>
                                <p class="text-muted small mb-3">Optional — receive codes by SMS if you lose your
                                    authenticator.</p>
                                <input type="tel" class="form-control mb-2" id="settingsSmsPhone"
                                    placeholder="+91 98765 43210">
                                <button type="button" class="btn btn-outline-secondary rounded-pill w-100"
                                    id="settingsSaveSms">Save phone (UI)</button>
                            </div>
                            <div class="card border-0 rounded-4 p-4 shadow-lg"
                                style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                                <h6 class="fw-bold text-white mb-2"><i
                                        class="bi bi-info-circle me-2 text-danger"></i>Security tips</h6>
                                <ul class="text-muted small mb-0 ps-3">
                                    <li class="mb-2">Never share OTP codes with anyone</li>
                                    <li class="mb-2">Keep backup codes offline</li>
                                    <li>Review signed-in devices regularly</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="avatar" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg"
                        style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <h6 class="fw-bold mb-3 text-white">Current Avatar</h6>
                        <img src="{{ asset($profile->avatar ?? 'images/default-avatar.png') }}"
                            class="rounded-circle mb-3" width="100" height="100" alt="">
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
                        <img src="{{ asset($profile->cover ?? 'images/default-cover.jpg') }}"
                            class="img-fluid rounded mb-3" style="max-height:150px;" alt="">
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
                    <div class="card border-0 rounded-4 p-4 shadow-lg"
                        style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="show_email" value="1"
                                    @checked($profile->show_email ?? false) id="showEmail">
                                <label class="form-check-label text-white" for="showEmail">Show email on profile</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="show_subscribers" value="1"
                                    @checked($profile->show_subscribers ?? true) id="showSubs">
                                <label class="form-check-label text-white" for="showSubs">Show subscriber count</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="allow_comments" value="1"
                                    @checked($profile->allow_comments ?? true) id="allowComments">
                                <label class="form-check-label text-white" for="allowComments">Allow comments on
                                    videos</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Privacy Settings</button>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="notifications" role="tabpanel">
                    <div class="card border-0 rounded-4 p-4 shadow-lg"
                        style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                        <form action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="new_subscriber" value="1"
                                    @checked($profile->notify_new_subscriber ?? true) id="notifSub">
                                <label class="form-check-label text-white" for="notifSub">New subscriber</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="new_comment" value="1"
                                    @checked($profile->notify_new_comment ?? true) id="notifComment">
                                <label class="form-check-label text-white" for="notifComment">New comment on video</label>
                            </div>
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" name="new_like" value="1"
                                    @checked($profile->notify_new_like ?? true) id="notifLike">
                                <label class="form-check-label text-white" for="notifLike">New like on video</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Notification Settings</button>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <style>
        .settings-page {
            max-width: 1140px;
        }

        .settings-page .card {
            margin: 0;
        }
        .settings-pill-tabs {
            display: inline-flex;
            flex-wrap: nowrap;
            align-items: center;
            gap: 2px;
            padding: 4px;
            background: rgba(105, 108, 255, 0.08);
            border: 1px solid rgba(105, 108, 255, 0.22);
            border-radius: 999px;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        .settings-pill-tabs::-webkit-scrollbar {
            display: none;
        }

        .settings-pill-tab {
            border: none;
            background: transparent;
            color: #8592a3;
            font-size: 0.8125rem;
            font-weight: 600;
            line-height: 1.2;
            padding: 0.45rem 0.95rem;
            border-radius: 999px;
            cursor: pointer;
            white-space: nowrap;
            flex: 0 0 auto;
            transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
        }

        .settings-pill-tab:hover {
            color: #696cff;
            background: rgba(105, 108, 255, 0.1);
        }

        .settings-pill-tab.active {
            color: #fff !important;
            background: #696cff !important;
            box-shadow: 0 2px 8px rgba(105, 108, 255, 0.35);
        }

        .settings-setup-key {
            display: flex;
            align-items: stretch;
            max-width: 360px;
            height: 42px;
            background: #fff;
            border: 1px solid rgba(105, 108, 255, 0.28);
            border-radius: 999px;
            overflow: hidden;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }

        .settings-setup-key:focus-within {
            border-color: #696cff;
            box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.15);
        }

        .settings-setup-key input {
            flex: 1 1 auto;
            min-width: 0;
            border: 0;
            outline: 0;
            background: transparent;
            color: #2f3349;
            font-size: 0.875rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            padding: 0 1rem;
        }

        .settings-setup-key button {
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            border: 0;
            border-left: 1px solid rgba(105, 108, 255, 0.2);
            background: rgba(105, 108, 255, 0.08);
            color: #696cff;
            font-size: 0.8125rem;
            font-weight: 600;
            padding: 0 1rem;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.15s ease, color 0.15s ease;
        }

        .settings-setup-key button:hover {
            background: #696cff;
            color: #fff;
        }

        .settings-otp-input {
            max-width: 160px;
            border-radius: 999px !important;
            border-color: rgba(105, 108, 255, 0.28) !important;
            letter-spacing: 0.25em;
            font-weight: 700;
            text-align: center;
        }

        .settings-otp-input:focus {
            border-color: #696cff !important;
            box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.15) !important;
        }

        @media (max-width: 991.98px) {
            .settings-pill-tabs {
                display: flex;
                width: 100%;
            }
        }

        @media (max-width: 767.98px) {
            .settings-page {
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }

            .settings-page .card {
                border-radius: 1rem !important;
                padding: 1rem !important;
            }

            .settings-pill-tabs {
                width: 100%;
                padding: 3px;
            }

            .settings-pill-tab {
                padding: 0.42rem 0.8rem;
                font-size: 0.75rem;
            }

            .settings-setup-key {
                max-width: 100%;
            }

            .settings-otp-input {
                max-width: 100%;
                flex: 1 1 auto;
            }

            #settingsEnable2fa {
                width: 100%;
            }
        }
    </style>
@endsection

@section('script')
    <script>
        (function() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('tab') === '2fa') {
                const tab = document.getElementById('twofa-tab');
                if (tab) new bootstrap.Tab(tab).show();
            }

            const offBox = document.getElementById('settingsTwoFaOff');
            const onBox = document.getElementById('settingsTwoFaOn');
            const badge = document.getElementById('settingsTwoFaBadge');
            if (!offBox || !onBox) return;

            function toast(msg) {
                let el = document.getElementById('settingsToast');
                if (!el) {
                    el = document.createElement('div');
                    el.id = 'settingsToast';
                    el.style.cssText =
                        'position:fixed;bottom:24px;left:50%;transform:translateX(-50%);z-index:9999;background:#222;color:#fff;padding:10px 18px;border-radius:999px;font-size:0.9rem;box-shadow:0 8px 24px rgba(0,0,0,.25);opacity:0;transition:opacity .2s;';
                    document.body.appendChild(el);
                }
                el.textContent = msg;
                el.style.opacity = '1';
                clearTimeout(el._t);
                el._t = setTimeout(function() {
                    el.style.opacity = '0';
                }, 2200);
            }

            document.getElementById('settingsCopyKey')?.addEventListener('click', function() {
                const key = document.getElementById('settingsSetupKey')?.value || 'AXIN-DEMO-2FA-KEY-9X7Q';
                navigator.clipboard?.writeText(key);
                const input = document.getElementById('settingsSetupKey');
                if (input) {
                    input.select();
                    input.setSelectionRange(0, key.length);
                }
                toast('Setup key copied');
            });

            document.getElementById('settingsEnable2fa')?.addEventListener('click', function() {
                const code = (document.getElementById('settingsOtp')?.value || '').trim();
                if (code.length !== 6) {
                    toast('Enter a 6-digit code');
                    return;
                }
                offBox.classList.add('d-none');
                onBox.classList.remove('d-none');
                badge.textContent = 'Active';
                badge.className = 'badge rounded-pill bg-success px-3 py-2';
                toast('2FA enabled');
            });

            document.getElementById('settingsDisable2fa')?.addEventListener('click', function() {
                onBox.classList.add('d-none');
                offBox.classList.remove('d-none');
                badge.textContent = 'Off';
                badge.className = 'badge rounded-pill bg-secondary px-3 py-2';
                const otp = document.getElementById('settingsOtp');
                if (otp) otp.value = '';
                toast('2FA disabled');
            });

            document.getElementById('settingsDownloadCodes')?.addEventListener('click', function() {
                toast('Backup codes downloaded (UI)');
            });

            document.getElementById('settingsSaveSms')?.addEventListener('click', function() {
                const phone = (document.getElementById('settingsSmsPhone')?.value || '').trim();
                toast(phone ? 'SMS backup saved (UI)' : 'Enter a phone number');
            });
        })();
    </script>
@endsection
