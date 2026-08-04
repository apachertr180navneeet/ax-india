@extends('web.layouts.app')

@section('content')
<div class="container py-4" id="twoFaPage">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-white"><i class="bi bi-shield-lock me-2 text-danger"></i>Two-Factor Authentication</h2>
            <p class="mb-0" style="color:#aaaaaa;">Add an extra layer of security to your AX India account (UI demo)</p>
        </div>
        <a href="{{ route('settings.devices') }}" class="btn-custom btn-outline-custom"><i class="bi bi-laptop me-1"></i> Device Management</a>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 rounded-4 p-4" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="fw-bold text-white mb-0">Authenticator app</h5>
                    <span class="badge rounded-pill bg-secondary" id="twoFaStatusBadge">Off</span>
                </div>

                <div id="twoFaStep1">
                    <p class="text-muted mb-3">Use Google Authenticator, Microsoft Authenticator, or Authy to generate login codes.</p>
                    <ol class="text-muted small mb-4">
                        <li class="mb-2">Install an authenticator app on your phone</li>
                        <li class="mb-2">Scan the QR code (demo)</li>
                        <li>Enter the 6-digit code to confirm</li>
                    </ol>
                    <div class="d-flex flex-wrap gap-3 align-items-center mb-4">
                        <div class="rounded-4 d-flex align-items-center justify-content-center" style="width:160px;height:160px;background:#111;border:1px dashed #555;color:#aaa;">
                            <div class="text-center">
                                <i class="bi bi-qr-code display-5"></i>
                                <div class="small mt-2">Demo QR</div>
                            </div>
                        </div>
                        <div>
                            <div class="small text-muted mb-1">Or enter setup key</div>
                            <code class="text-white">AXIN-DEMO-2FA-KEY-9X7Q</code>
                            <button type="button" class="btn btn-sm btn-outline-secondary ms-2" id="btnCopyKey">Copy</button>
                        </div>
                    </div>
                    <div class="mb-3" style="max-width:220px;">
                        <label class="form-label text-white">Verification code</label>
                        <input type="text" class="form-control" id="otpInput" maxlength="6" placeholder="000000" inputmode="numeric">
                    </div>
                    <button type="button" class="btn-custom btn-primary-custom" id="btnEnable2fa">Enable 2FA</button>
                </div>

                <div id="twoFaStep2" class="d-none">
                    <div class="alert alert-success border-0 mb-3">2FA is enabled on this account (UI demo).</div>
                    <h6 class="text-white fw-bold">Backup codes</h6>
                    <p class="text-muted small">Store these codes somewhere safe. Each can be used once.</p>
                    <div class="row g-2 mb-3" id="backupCodes">
                        @foreach(['492183','837104','550291','118473','904562','667320'] as $code)
                            <div class="col-6 col-md-4"><code class="d-block p-2 rounded text-center text-white" style="background:#1a1a1a;">{{ $code }}</code></div>
                        @endforeach
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn-custom btn-outline-custom" id="btnDownloadCodes">Download codes</button>
                        <button type="button" class="btn btn-outline-danger rounded-pill px-3" id="btnDisable2fa">Disable 2FA</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 rounded-4 p-4 mb-3" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <h6 class="fw-bold text-white">SMS backup (optional)</h6>
                <p class="text-muted small">Receive codes by SMS if you lose access to your authenticator.</p>
                <input type="tel" class="form-control mb-2" placeholder="+91 98765 43210" id="smsPhone">
                <button type="button" class="btn-custom btn-outline-custom w-100" id="btnSaveSms">Save phone (UI)</button>
            </div>
            <div class="card border-0 rounded-4 p-4" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <h6 class="fw-bold text-white">Security tips</h6>
                <ul class="text-muted small mb-0 ps-3">
                    <li class="mb-2">Never share OTP codes with anyone</li>
                    <li class="mb-2">Keep backup codes offline</li>
                    <li>Review devices regularly</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
(function(){
    const page=document.getElementById('twoFaPage'); if(!page) return;
    const step1=document.getElementById('twoFaStep1');
    const step2=document.getElementById('twoFaStep2');
    const badge=document.getElementById('twoFaStatusBadge');
    function toast(msg){ alert(msg); }

    document.getElementById('btnCopyKey').addEventListener('click', function(){
        navigator.clipboard?.writeText('AXIN-DEMO-2FA-KEY-9X7Q');
        toast('Setup key copied (UI)');
    });

    document.getElementById('btnEnable2fa').addEventListener('click', function(){
        const code=document.getElementById('otpInput').value.trim();
        if(code.length!==6){ toast('Enter a 6-digit code (UI)'); return; }
        step1.classList.add('d-none'); step2.classList.remove('d-none');
        badge.textContent='Active'; badge.className='badge rounded-pill bg-success';
        toast('2FA enabled (UI demo)');
    });

    document.getElementById('btnDisable2fa').addEventListener('click', function(){
        step2.classList.add('d-none'); step1.classList.remove('d-none');
        badge.textContent='Off'; badge.className='badge rounded-pill bg-secondary';
        document.getElementById('otpInput').value='';
        toast('2FA disabled (UI demo)');
    });

    document.getElementById('btnDownloadCodes').addEventListener('click', function(){
        const blob=new Blob(['AX India 2FA backup codes\n492183\n837104\n550291\n118473\n904562\n667320\n'],{type:'text/plain'});
        const a=document.createElement('a'); a.href=URL.createObjectURL(blob); a.download='ax-india-2fa-backup.txt'; a.click();
    });

    document.getElementById('btnSaveSms').addEventListener('click', function(){
        toast('SMS backup saved (UI demo)');
    });
})();
</script>
@endsection
