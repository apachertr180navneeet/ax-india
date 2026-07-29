@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <!-- Welcome Spotlight Banner -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: linear-gradient(135deg, var(--linen), var(--almond-cream)) !important; border-color: var(--bone);">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge-custom badge-active mb-2"><i class="bi bi-shield-check"></i> Video Admin Console</span>
                        <h2 class="serif-font mb-2">Welcome Back, {{ Auth::user()->name ?? 'Administrator' }}</h2>
                        <p class="mb-0 text-secondary" style="max-width: 600px;">
                            Monitor platform streaming performance, manage video channels, upload queues, and system settings in Parchment & Linen aesthetic.
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <button class="btn-custom btn-primary-custom" onclick="alert('Opening video uploader...')">
                            <i class="bi bi-cloud-upload"></i> New Video Upload
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Platform Stat Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Video Views</span>
                    <i class="bi bi-eye-fill fs-4" style="color: var(--almond-silk);"></i>
                </div>
                <div class="stat-number">1.42M</div>
                <div class="text-success small font-weight-bold"><i class="bi bi-arrow-up-right"></i> +14.2% from last month</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Active Creators</span>
                    <i class="bi bi-people-fill fs-4" style="color: var(--almond-silk);"></i>
                </div>
                <div class="stat-number">8,420</div>
                <div class="text-success small font-weight-bold"><i class="bi bi-arrow-up-right"></i> +8.5% new creators</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Total Streams</span>
                    <i class="bi bi-play-circle-fill fs-4" style="color: var(--almond-silk);"></i>
                </div>
                <div class="stat-number">34.8K</div>
                <div class="text-secondary small font-weight-bold"><i class="bi bi-dash-lg"></i> Stable streaming load</div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted text-uppercase fw-bold" style="font-size: 0.75rem; letter-spacing: 0.05em;">Storage Capacity</span>
                    <i class="bi bi-hdd-network-fill fs-4" style="color: var(--almond-silk);"></i>
                </div>
                <div class="stat-number">4.2 TB</div>
                <div class="text-muted small">Of 10 TB allocated</div>
            </div>
        </div>
    </div>

    <!-- Recent Uploads Table -->
    <div class="row">
        <div class="col-12">
            <div class="card p-3">
                <div class="d-flex align-items-center justify-content-between mb-3 px-2">
                    <h4 class="serif-font m-0">Recent Video Submissions</h4>
                    <button class="btn-custom btn-outline-custom style-sm" style="padding: 0.4rem 0.8rem; font-size: 0.82rem;">
                        <i class="bi bi-arrow-clockwise"></i> Refresh List
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table-custom">
                        <thead>
                            <tr>
                                <th>Thumbnail & Title</th>
                                <th>Channel</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('assets/web/img/thumb1.png') }}" alt="Thumb" style="width: 54px; height: 32px; object-fit: cover; border-radius: 4px;">
                                        <span class="fw-bold">Sanctuary of Light</span>
                                    </div>
                                </td>
                                <td>AX Studio</td>
                                <td>Architecture</td>
                                <td><span class="badge-custom badge-active">Published</span></td>
                                <td>48,210</td>
                                <td>2026-07-27</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('assets/web/img/hero.png') }}" alt="Thumb" style="width: 54px; height: 32px; object-fit: cover; border-radius: 4px;">
                                        <span class="fw-bold">Whispers of the Summit</span>
                                    </div>
                                </td>
                                <td>Highland Stories</td>
                                <td>Documentary</td>
                                <td><span class="badge-custom badge-active">Published</span></td>
                                <td>125,000</td>
                                <td>2026-07-24</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('assets/web/img/thumb1.png') }}" alt="Thumb" style="width: 54px; height: 32px; object-fit: cover; border-radius: 4px;">
                                        <span class="fw-bold">Parchment Calligraphy Craft</span>
                                    </div>
                                </td>
                                <td>Paper & Ink Masters</td>
                                <td>Art & Craft</td>
                                <td><span class="badge-custom badge-inactive">Processing</span></td>
                                <td>19,400</td>
                                <td>2026-07-22</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection