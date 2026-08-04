@extends('web.layouts.app')

@section('content')
<div class="container py-4 monetization-page">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-white">
                <i class="bi bi-wallet2 text-warning me-2"></i>Creator Payments & Earnings Dashboard
            </h2>
            <p class="mb-0" style="color:#aaaaaa;">Manage your revenue sources, monthly bank transfers, payout threshold, and tax deductions.</p>
        </div>
        <span class="badge rounded-pill px-3 py-2 fs-6 bg-{{ $monetization->status === 'approved' ? 'success' : ($monetization->status === 'pending_approval' ? 'warning text-dark' : 'info') }}">
            <i class="bi bi-shield-check me-1"></i>Status: {{ ucfirst(str_replace('_', ' ', $monetization->status ?? 'ineligible')) }}
        </span>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="mono-stat-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="mono-stat-label">Total Gross Earnings</span>
                    <i class="bi bi-currency-dollar text-success fs-4"></i>
                </div>
                <div class="mono-stat-value text-success">${{ number_format($totalGrossEarnings, 2) }}</div>
                <div class="mono-stat-foot">Lifetime accumulated</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mono-stat-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="mono-stat-label">Tax Deductions (TDS)</span>
                    <i class="bi bi-receipt-cutoff text-danger fs-4"></i>
                </div>
                <div class="mono-stat-value text-danger">${{ number_format($totalTaxDeducted, 2) }}</div>
                <div class="mono-stat-foot">{{ number_format($monetization->tax_deduction_rate ?? 10, 0) }}% rate applicable</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mono-stat-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="mono-stat-label">Pending Monthly Payout</span>
                    <i class="bi bi-clock-history text-warning fs-4"></i>
                </div>
                <div class="mono-stat-value text-warning">${{ number_format($pendingPayout, 2) }}</div>
                <div class="mono-stat-foot">Min Threshold: ${{ number_format($minimumThreshold, 2) }}</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="mono-stat-card h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <span class="mono-stat-label">Paid Out (Bank)</span>
                    <i class="bi bi-bank text-info fs-4"></i>
                </div>
                <div class="mono-stat-value text-info">${{ number_format($paidOutTotal, 2) }}</div>
                <div class="mono-stat-foot">Completed monthly transfers</div>
            </div>
        </div>
    </div>

    <div class="mono-banner mb-4 {{ $eligibleForPayout ? 'is-ready' : 'is-pending' }}">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-start gap-3">
                <div class="mono-banner-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Monthly Payout Status</h5>
                    <p class="mb-0 small text-secondary">
                        @if($eligibleForPayout)
                            <span class="text-success fw-semibold"><i class="bi bi-check-circle me-1"></i>Threshold Met!</span>
                            Your pending balance of <strong>${{ number_format($pendingPayout, 2) }}</strong> exceeds the minimum of <strong>${{ number_format($minimumThreshold, 2) }}</strong>.
                        @else
                            <span class="text-warning fw-semibold"><i class="bi bi-info-circle me-1"></i>Minimum Payout Threshold Pending.</span>
                            You need <strong>${{ number_format(max(0, $minimumThreshold - $pendingPayout), 2) }}</strong> more to reach <strong>${{ number_format($minimumThreshold, 2) }}</strong>.
                        @endif
                    </p>
                </div>
            </div>
            <button type="button" class="btn btn-outline-warning fw-semibold text-nowrap rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#payoutMethodModal">
                <i class="bi bi-safe2 me-1"></i>Payout & Bank Setup
            </button>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="mono-panel h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Revenue Sources</h5>
                    <span class="badge rounded-pill text-bg-primary">Net Earnings Share</span>
                </div>
                <div class="mono-revenue-list">
                    @foreach([
                        ['bi-badge-ad', 'text-warning', 'Ads Revenue', 'In-stream video ads & banner display revenue (55% Share)', $revenueSources['ads'] ?? 0],
                        ['bi-star-fill', 'text-info', 'Premium Membership Share', 'Earnings generated from AX Premium member watch time', $revenueSources['premium_membership'] ?? 0],
                        ['bi-tablet', 'text-primary', 'Brand Sponsorships', 'Direct brand deals & sponsored video placements', $revenueSources['brand_sponsorship'] ?? 0],
                        ['bi-heart-fill', 'text-danger', 'Fan Contributions', 'Superchats, live stream gifts, and direct channel support', $revenueSources['fan_contribution'] ?? 0],
                        ['bi-trophy-fill', 'text-warning', 'Platform Incentives', 'Shorts fund bonuses & milestone creator rewards', $revenueSources['platform_incentive'] ?? 0],
                    ] as $row)
                        <div class="mono-revenue-item">
                            <div class="d-flex align-items-start gap-2">
                                <i class="bi {{ $row[0] }} {{ $row[1] }} fs-5 mt-1"></i>
                                <div>
                                    <div class="fw-bold text-dark">{{ $row[2] }}</div>
                                    <div class="small text-muted">{{ $row[3] }}</div>
                                </div>
                            </div>
                            <div class="fw-bold fs-5 text-success text-nowrap">${{ number_format($row[4], 2) }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="mono-panel h-100">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-gear-wide-connected text-warning me-2"></i>Eligibility Requirements</h5>
                </div>

                <div class="mono-elig-item">
                    <div>
                        <div class="fw-bold text-dark">Verified Creator Profile</div>
                        <div class="small text-muted">Govt ID & identity verified</div>
                    </div>
                    <i class="bi fs-4 {{ $isVerified ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                </div>
                <div class="mono-elig-item">
                    <div>
                        <div class="fw-bold text-dark">Subscribers</div>
                        <div class="small text-muted">{{ number_format($subscribersCount) }} / 1,000 required</div>
                    </div>
                    <i class="bi fs-4 {{ $subscribersCount >= 1000 ? 'bi-check-circle-fill text-success' : 'bi-dash-circle-fill text-warning' }}"></i>
                </div>
                <div class="mono-elig-item">
                    <div>
                        <div class="fw-bold text-dark">Watch Time / Views</div>
                        <div class="small text-muted">{{ number_format($totalViews) }} / 40,000 views</div>
                    </div>
                    <i class="bi fs-4 {{ $totalViews >= 40000 ? 'bi-check-circle-fill text-success' : 'bi-dash-circle-fill text-warning' }}"></i>
                </div>
                <div class="mono-elig-item">
                    <div>
                        <div class="fw-bold text-dark">Copyright Violations</div>
                        <div class="small text-muted">{{ $copyrightViolations }} Active Strikes</div>
                    </div>
                    <i class="bi fs-4 {{ $copyrightViolations === 0 ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                </div>

                @if(($monetization->status ?? '') === 'ineligible' || ($monetization->status ?? '') === 'eligible')
                    <form action="{{ route('creator.monetization.apply') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="btn btn-warning w-100 fw-bold py-2 rounded-pill" {{ !$meetsCriteria ? 'disabled' : '' }}>
                            <i class="bi bi-rocket-takeoff me-2"></i>Apply for Monetization
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="mono-panel mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-table text-info me-2"></i>Earnings Ledger & Payout History</h5>
            <span class="badge rounded-pill text-bg-secondary">Monthly Statements</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0 mono-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Revenue Source</th>
                        <th>Gross Amount</th>
                        <th>Tax Deducted (TDS)</th>
                        <th>Net Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($earnings as $item)
                        <tr>
                            <td>{{ $item->created_at->format('M d, Y') }}</td>
                            <td><span class="badge rounded-pill text-bg-light border text-dark text-capitalize">{{ str_replace('_', ' ', $item->type) }}</span></td>
                            <td class="fw-semibold">${{ number_format($item->amount, 2) }}</td>
                            <td class="text-danger">-${{ number_format($item->tax_deducted, 2) }}</td>
                            <td class="fw-bold text-success">${{ number_format($item->net_amount, 2) }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $item->status === 'paid_out' ? 'success' : ($item->status === 'credited' ? 'info' : 'warning text-dark') }}">
                                    {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">No earnings ledger records found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($earnings, 'links'))
            <div class="pt-3">{{ $earnings->links() }}</div>
        @endif
    </div>

    <div class="mono-note">
        <i class="bi bi-info-square-fill text-warning"></i>
        <div>
            <strong>Important Policy Note:</strong> AX India may update monetization policies, eligibility criteria, payout methods, minimum payout thresholds, and revenue sharing percentages based on business, operational, and legal requirements.
        </div>
    </div>
</div>

<div class="modal fade" id="payoutMethodModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-bank text-warning me-2"></i>Payout & Bank Transfer Setup
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('creator.monetization.payout') }}" method="POST">
                @csrf
                <div class="modal-body pt-0">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Preferred Payout Method</label>
                        <select name="payout_method" class="form-select" id="payoutMethodSelect" required>
                            <option value="bank_transfer" {{ ($monetization->payout_method ?? 'bank_transfer') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer (NEFT/IMPS/SWIFT)</option>
                            <option value="upi" {{ ($monetization->payout_method ?? '') === 'upi' ? 'selected' : '' }}>UPI Payment (India)</option>
                            <option value="paypal" {{ ($monetization->payout_method ?? '') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                        </select>
                    </div>

                    <div id="bankFields" class="p-3 border rounded-3 mb-3 bg-light">
                        <div class="mb-3">
                            <label class="form-label small">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" placeholder="e.g. HDFC Bank" value="{{ $monetization->payout_details['bank_name'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Account Number</label>
                            <input type="text" name="account_number" class="form-control" placeholder="Enter bank account number" value="{{ $monetization->payout_details['account_number'] ?? '' }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small">IFSC / SWIFT Code</label>
                            <input type="text" name="ifsc_code" class="form-control" placeholder="e.g. HDFC0001234" value="{{ $monetization->payout_details['ifsc_code'] ?? '' }}">
                        </div>
                    </div>

                    <div id="upiFields" class="p-3 border rounded-3 mb-3 bg-light d-none">
                        <label class="form-label small">UPI ID</label>
                        <input type="text" name="upi_id" class="form-control" placeholder="username@upi" value="{{ $monetization->payout_details['upi_id'] ?? '' }}">
                    </div>

                    <div id="paypalFields" class="p-3 border rounded-3 mb-3 bg-light d-none">
                        <label class="form-label small">PayPal Email</label>
                        <input type="email" name="paypal_email" class="form-control" placeholder="email@example.com" value="{{ $monetization->payout_details['paypal_email'] ?? '' }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold">PAN / Tax ID</label>
                        <input type="text" name="pan_tax_id" class="form-control text-uppercase" placeholder="e.g. ABCDE1234F" value="{{ $monetization->payout_details['pan_tax_id'] ?? '' }}" required>
                        <small class="text-muted">Required for TDS compliance.</small>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-secondary rounded-pill" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4">Save Payout Details</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.monetization-page .mono-stat-card {
    background: #fff;
    border: 1px solid var(--yt-border);
    border-radius: 16px;
    padding: 1.15rem 1.2rem;
    box-shadow: var(--shadow-soft);
}
.mono-stat-label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.04em;
    text-transform: uppercase;
    color: #64748b;
}
.mono-stat-value {
    font-size: 1.75rem;
    font-weight: 800;
    margin: 0.45rem 0 0.15rem;
    line-height: 1.1;
}
.mono-stat-foot { font-size: 0.8rem; color: #94a3b8; }
.mono-banner {
    background: #fff;
    border: 1px solid var(--yt-border);
    border-radius: 16px;
    padding: 1.1rem 1.25rem;
    box-shadow: var(--shadow-soft);
}
.mono-banner.is-pending { border-color: #fcd34d; background: #fffbeb; }
.mono-banner.is-ready { border-color: #86efac; background: #f0fdf4; }
.mono-banner-icon {
    width: 52px; height: 52px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    background: rgba(245, 158, 11, 0.15); color: #d97706; font-size: 1.5rem; flex-shrink: 0;
}
.mono-panel {
    background: #fff;
    border: 1px solid var(--yt-border);
    border-radius: 16px;
    padding: 1.25rem;
    box-shadow: var(--shadow-soft);
}
.mono-revenue-item {
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    padding: 0.95rem 0;
    border-bottom: 1px solid #eef2ff;
}
.mono-revenue-item:last-child { border-bottom: none; }
.mono-elig-item {
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    padding: 0.9rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 0.75rem;
    background: #f8fafc;
}
.mono-table th {
    font-size: 0.78rem; text-transform: uppercase; letter-spacing: 0.04em;
    color: #64748b; background: transparent; border-bottom-color: #e2e8f0;
}
.mono-table td { border-color: #eef2ff; color: #334155; }
.mono-note {
    display: flex; gap: 0.75rem; align-items: flex-start;
    background: #fff; border: 1px solid var(--yt-border); border-radius: 14px;
    padding: 1rem 1.15rem; color: #64748b; font-size: 0.9rem;
}
</style>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('payoutMethodSelect');
    const bankFields = document.getElementById('bankFields');
    const upiFields = document.getElementById('upiFields');
    const paypalFields = document.getElementById('paypalFields');
    if (!select) return;

    function toggleFields() {
        bankFields.classList.add('d-none');
        upiFields.classList.add('d-none');
        paypalFields.classList.add('d-none');
        if (select.value === 'bank_transfer') bankFields.classList.remove('d-none');
        else if (select.value === 'upi') upiFields.classList.remove('d-none');
        else if (select.value === 'paypal') paypalFields.classList.remove('d-none');
    }
    select.addEventListener('change', toggleFields);
    toggleFields();
});
</script>
@endsection
