@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y" id="adminSecurityPage">
        <div class="mb-4">
            <h4 class="fw-bold text-white mb-1"><i class="bx bx-lock-alt me-1"></i> Data Encryption & Daily Backups</h4>
            <p class="text-muted small mb-0">Platform security & backup status (UI only — no real ops)</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="mb-0 text-white">Data Encryption</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded"
                            style="background:rgba(113,221,55,.08)">
                            <div>
                                <div class="fw-bold text-white">At-rest encryption</div>
                                <small class="text-muted">AES-256 for media & database volumes</small>
                            </div>
                            <span class="badge bg-success">Enabled</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 rounded"
                            style="background:rgba(105,108,255,.08)">
                            <div>
                                <div class="fw-bold text-white">In-transit (TLS)</div>
                                <small class="text-muted">HTTPS / TLS 1.3 for all public traffic</small>
                            </div>
                            <span class="badge bg-success">Enabled</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Key rotation policy</label>
                            <select class="form-select" id="keyRotation">
                                <option>Every 90 days</option>
                                <option>Every 30 days</option>
                                <option>Manual only</option>
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary rounded-pill" id="btnRotateKeys">Rotate keys
                            (UI)</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-white">Daily Backups</h5>
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" id="backupToggle" checked>
                            <label class="form-check-label" for="backupToggle">Auto backup</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="text-muted small text-uppercase fw-bold">Last backup</div>
                                <div class="text-white fw-bold">Today, 03:00 AM</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small text-uppercase fw-bold">Next scheduled</div>
                                <div class="text-white fw-bold">Tomorrow, 03:00 AM</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small text-uppercase fw-bold">Retention</div>
                                <div class="text-white fw-bold">30 days</div>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small text-uppercase fw-bold">Status</div>
                                <div class="text-success fw-bold">Healthy</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Backup window</label>
                            <select class="form-select" id="backupWindow">
                                <option>03:00 AM IST</option>
                                <option>01:00 AM IST</option>
                                <option>11:00 PM IST</option>
                            </select>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary rounded-pill" id="btnRunBackup">Run backup now
                                (UI)</button>
                            <button type="button" class="btn btn-outline-secondary rounded-pill"
                                id="btnRestoreBackup">Restore wizard (UI)</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 text-white">Recent backup history</h5>
            </div>
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ([['31 Jul 2026, 03:00', 'Full', '42.8 GB', '18 min', 'Success'], ['30 Jul 2026, 03:00', 'Incremental', '6.1 GB', '4 min', 'Success'], ['29 Jul 2026, 03:00', 'Incremental', '5.4 GB', '3 min', 'Success'], ['28 Jul 2026, 03:00', 'Full', '41.2 GB', '17 min', 'Success']] as $b)
                            <tr>
                                <td class="text-white">{{ $b[0] }}</td>
                                <td>{{ $b[1] }}</td>
                                <td>{{ $b[2] }}</td>
                                <td>{{ $b[3] }}</td>
                                <td><span class="badge bg-success">{{ $b[4] }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        (function() {
            const page = document.getElementById('adminSecurityPage');
            if (!page) return;
            document.getElementById('btnRotateKeys').addEventListener('click', () => alert(
                'Key rotation queued (UI demo)'));
            document.getElementById('btnRunBackup').addEventListener('click', () => alert(
                'Manual backup started (UI demo)'));
            document.getElementById('btnRestoreBackup').addEventListener('click', () => alert(
                'Restore wizard opened (UI demo)'));
            document.getElementById('backupToggle').addEventListener('change', function() {
                alert(this.checked ? 'Daily backups enabled (UI)' : 'Daily backups paused (UI)');
            });
        })();
    </script>
@endsection
