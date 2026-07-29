@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="text-dark"><i class="bi bi-cash-coin me-2 text-warning"></i>Creator Monetization Program</h2>
        <span class="badge fs-6 bg-{{ $monetization->status === 'approved' ? 'success' : ($monetization->status === 'pending_approval' ? 'warning' : 'secondary') }}">
            Status: {{ ucfirst(str_replace('_', ' ', $monetization->status)) }}
        </span>
    </div>

    <!-- Eligibility Status Card -->
    <div class="card mb-4">
        <div class="card-header border-0 bg-transparent fw-bold">
            <h5 class="mb-0 text-dark">Program Eligibility Overview</h5>
        </div>
        <div class="card-body">
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <i class="bi me-2 fs-3 {{ $isVerified ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                        <h6 class="mt-2 text-muted">Verified Account</h6>
                        <span class="fw-bold text-dark">{{ $isVerified ? 'Verified' : 'Not Verified' }}</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <i class="bi me-2 fs-3 {{ $subscribersCount >= 1000 ? 'bi-check-circle-fill text-success' : 'bi-dash-circle-fill text-warning' }}"></i>
                        <h6 class="mt-2 text-muted">Subscribers</h6>
                        <span class="fw-bold text-dark">{{ number_format($subscribersCount) }} / 1,000</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <i class="bi me-2 fs-3 {{ $totalViews >= 40000 ? 'bi-check-circle-fill text-success' : 'bi-dash-circle-fill text-warning' }}"></i>
                        <h6 class="mt-2 text-muted">Total Views</h6>
                        <span class="fw-bold text-dark">{{ number_format($totalViews) }} / 40,000</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 border rounded">
                        <i class="bi me-2 fs-3 {{ $copyrightViolations === 0 ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                        <h6 class="mt-2 text-muted">Copyright Violations</h6>
                        <span class="fw-bold text-dark">{{ $copyrightViolations }} Active</span>
                    </div>
                </div>
            </div>

            @if($monetization->status === 'ineligible' || $monetization->status === 'eligible')
                <div class="mt-4 text-end">
                    <form action="{{ route('creator.monetization.apply') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning fw-bold px-4" {{ !$meetsCriteria ? 'disabled' : '' }}>
                            <i class="bi bi-rocket-takeoff me-2"></i>Apply for Monetization
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <!-- Revenue & Earnings Breakdown -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header border-0 bg-transparent fw-bold">
                    <h5 class="mb-0 text-dark">Earnings Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Total Revenue Share (55%)</span>
                        <span class="fs-4 fw-bold text-success">${{ number_format($monetization->total_earnings, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Pending Payout</span>
                        <span class="fs-5 fw-bold text-warning">${{ number_format($monetization->pending_payout, 2) }}</span>
                    </div>
                    <hr>
                    <div class="small text-muted">
                        Revenue streams include Video Ads, Performance Bonuses, Brand Collaborations, Premium Content Earnings, Live Gifts, and Fan Subscriptions.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header border-0 bg-transparent fw-bold">
                    <h5 class="mb-0 text-dark">Brand Collaborations</h5>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush bg-transparent">
                        @forelse($brandDeals as $deal)
                            <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                                <div>
                                    <div class="fw-bold text-dark">{{ $deal->campaign_title }}</div>
                                    <small class="text-muted">Brand: {{ $deal->brand_name }}</small>
                                </div>
                                <div>
                                    <span class="badge bg-primary me-2">${{ number_format($deal->compensation, 2) }}</span>
                                    <span class="badge bg-secondary">{{ ucfirst($deal->status) }}</span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item bg-dark text-muted text-center py-4 border-secondary">No active brand collaborations.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
