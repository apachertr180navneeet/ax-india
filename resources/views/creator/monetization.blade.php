@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <!-- Top Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 pb-3 border-bottom border-secondary">
        <div>
            <h2 class="text-light fw-bold mb-1">
                <i class="bi bi-wallet2 text-warning me-2"></i>Creator Payments & Earnings Dashboard
            </h2>
            <p class="text-muted small mb-0">Manage your revenue sources, monthly bank transfers, payout threshold, and tax deductions.</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex align-items-center gap-2">
            <span class="badge fs-6 px-3 py-2 bg-{{ $monetization->status === 'approved' ? 'success' : ($monetization->status === 'pending_approval' ? 'warning text-dark' : 'secondary') }}">
                <i class="bi bi-shield-check me-1"></i>Status: {{ ucfirst(str_replace('_', ' ', $monetization->status)) }}
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show bg-dark text-success border-success" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Earnings Overview Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-dark border-secondary text-light h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-semibold text-uppercase">Total Gross Earnings</span>
                        <i class="bi bi-currency-dollar text-success fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-success mt-2 mb-0">${{ number_format($totalGrossEarnings, 2) }}</h3>
                    <small class="text-muted">Lifetime accumulated</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark border-secondary text-light h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-semibold text-uppercase">Tax Deductions (TDS)</span>
                        <i class="bi bi-receipt-cutoff text-danger fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-danger mt-2 mb-0">${{ number_format($totalTaxDeducted, 2) }}</h3>
                    <small class="text-muted">{{ number_format($monetization->tax_deduction_rate ?? 10, 0) }}% rate applicable</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark border-secondary text-light h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-semibold text-uppercase">Pending Monthly Payout</span>
                        <i class="bi bi-clock-history text-warning fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-warning mt-2 mb-0">${{ number_format($pendingPayout, 2) }}</h3>
                    <small class="text-muted">Min Threshold: ${{ number_format($minimumThreshold, 2) }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-dark border-secondary text-light h-100 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small fw-semibold text-uppercase">Paid Out (Bank)</span>
                        <i class="bi bi-bank text-info fs-4"></i>
                    </div>
                    <h3 class="fw-bold text-info mt-2 mb-0">${{ number_format($paidOutTotal, 2) }}</h3>
                    <small class="text-muted">Completed monthly transfers</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Payout Status Banner -->
    <div class="card bg-dark border-secondary text-light mb-4">
        <div class="card-body d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle p-3 bg-{{ $eligibleForPayout ? 'success' : 'secondary' }} bg-opacity-25 text-{{ $eligibleForPayout ? 'success' : 'warning' }}">
                    <i class="bi bi-calendar-check fs-2"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1">Monthly Payout Status</h5>
                    <p class="mb-0 text-muted small">
                        @if($eligibleForPayout)
                            <span class="text-success fw-bold"><i class="bi bi-check-circle me-1"></i>Threshold Met!</span> Your pending balance of <strong>${{ number_format($pendingPayout, 2) }}</strong> exceeds the minimum payout threshold of <strong>${{ number_format($minimumThreshold, 2) }}</strong>. Payment will process in the next monthly payout cycle.
                        @else
                            <span class="text-warning fw-bold"><i class="bi bi-info-circle me-1"></i>Minimum Payout Threshold Pending</span> You need <strong>${{ number_format($minimumThreshold - $pendingPayout, 2) }}</strong> more to reach the minimum payout threshold of <strong>${{ number_format($minimumThreshold, 2) }}</strong>.
                        @endif
                    </p>
                </div>
            </div>
            <button class="btn btn-outline-warning text-nowrap" data-bs-toggle="modal" data-bs-target="#payoutMethodModal">
                <i class="bi bi-bank me-2"></i>Payout & Bank Setup
            </button>
        </div>
    </div>

    <!-- Revenue Sources & Program Eligibility -->
    <div class="row g-4 mb-4">
        <!-- Revenue Sources Breakdown -->
        <div class="col-lg-7">
            <div class="card bg-dark border-secondary text-light h-100 shadow-sm">
                <div class="card-header border-secondary bg-transparent d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-light fw-bold"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Revenue Sources</h5>
                    <span class="badge bg-primary">Net Earnings Share</span>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush bg-transparent">
                        <!-- Ads -->
                        <div class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold"><i class="bi bi-badge-ad text-warning me-2"></i>Ads Revenue</div>
                                <small class="text-muted">In-stream video ads & banner display revenue (55% Share)</small>
                            </div>
                            <span class="fw-bold fs-5 text-success">${{ number_format($revenueSources['ads'], 2) }}</span>
                        </div>
                        <!-- Premium Membership Share -->
                        <div class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold"><i class="bi bi-star-fill text-info me-2"></i>Premium Membership Share</div>
                                <small class="text-muted">Earnings generated from AX Premium member watch time</small>
                            </div>
                            <span class="fw-bold fs-5 text-success">${{ number_format($revenueSources['premium_membership'], 2) }}</span>
                        </div>
                        <!-- Brand Sponsorships -->
                        <div class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold"><i class="bi bi-briefcase-fill text-primary me-2"></i>Brand Sponsorships</div>
                                <small class="text-muted">Direct brand deals & sponsored video placements</small>
                            </div>
                            <span class="fw-bold fs-5 text-success">${{ number_format($revenueSources['brand_sponsorship'], 2) }}</span>
                        </div>
                        <!-- Fan Contributions -->
                        <div class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold"><i class="bi bi-heart-fill text-danger me-2"></i>Fan Contributions</div>
                                <small class="text-muted">Superchats, live stream gifts, and direct channel support</small>
                            </div>
                            <span class="fw-bold fs-5 text-success">${{ number_format($revenueSources['fan_contribution'], 2) }}</span>
                        </div>
                        <!-- Platform Incentives -->
                        <div class="list-group-item bg-transparent text-light border-secondary d-flex justify-content-between align-items-center py-3">
                            <div>
                                <div class="fw-bold"><i class="bi bi-trophy-fill text-warning me-2"></i>Platform Incentives</div>
                                <small class="text-muted">Shorts fund bonuses & milestone creator rewards</small>
                            </div>
                            <span class="fw-bold fs-5 text-success">${{ number_format($revenueSources['platform_incentive'], 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Program Eligibility Overview -->
        <div class="col-lg-5">
            <div class="card bg-dark border-secondary text-light h-100 shadow-sm">
                <div class="card-header border-secondary bg-transparent d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 text-light fw-bold"><i class="bi bi-patch-check-fill text-warning me-2"></i>Eligibility Requirements</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between p-3 mb-3 border rounded border-secondary">
                        <div>
                            <div class="fw-bold">Verified Creator Profile</div>
                            <small class="text-muted">Govt ID & identity verified</small>
                        </div>
                        <i class="bi fs-4 {{ $isVerified ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 mb-3 border rounded border-secondary">
                        <div>
                            <div class="fw-bold">Subscribers</div>
                            <small class="text-muted">{{ number_format($subscribersCount) }} / 1,000 required</small>
                        </div>
                        <i class="bi fs-4 {{ $subscribersCount >= 1000 ? 'bi-check-circle-fill text-success' : 'bi-dash-circle-fill text-warning' }}"></i>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 mb-3 border rounded border-secondary">
                        <div>
                            <div class="fw-bold">Watch Time / Views</div>
                            <small class="text-muted">{{ number_format($totalViews) }} / 40,000 views</small>
                        </div>
                        <i class="bi fs-4 {{ $totalViews >= 40000 ? 'bi-check-circle-fill text-success' : 'bi-dash-circle-fill text-warning' }}"></i>
                    </div>

                    <div class="d-flex align-items-center justify-content-between p-3 mb-3 border rounded border-secondary">
                        <div>
                            <div class="fw-bold">Copyright Violations</div>
                            <small class="text-muted">{{ $copyrightViolations }} Active Strikes</small>
                        </div>
                        <i class="bi fs-4 {{ $copyrightViolations === 0 ? 'bi-check-circle-fill text-success' : 'bi-x-circle-fill text-danger' }}"></i>
                    </div>

                    @if($monetization->status === 'ineligible' || $monetization->status === 'eligible')
                        <div class="mt-4 text-center">
                            <form action="{{ route('creator.monetization.apply') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning w-100 fw-bold py-2" {{ !$meetsCriteria ? 'disabled' : '' }}>
                                    <i class="bi bi-rocket-takeoff me-2"></i>Apply for Monetization
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings History & Tax Deductions Table -->
    <div class="card bg-dark border-secondary text-light mb-4 shadow-sm">
        <div class="card-header border-secondary bg-transparent d-flex align-items-center justify-content-between">
            <h5 class="mb-0 text-light fw-bold"><i class="bi bi-table text-info me-2"></i>Earnings Ledger & Payout History</h5>
            <span class="badge bg-secondary">Monthly Statements</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover align-middle mb-0 border-secondary">
                    <thead>
                        <tr class="table-active">
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
                                <td>
                                    <span class="badge bg-outline-secondary text-capitalize border border-secondary text-light">
                                        {{ str_replace('_', ' ', $item->type) }}
                                    </span>
                                </td>
                                <td class="fw-bold">${{ number_format($item->amount, 2) }}</td>
                                <td class="text-danger">-${{ number_format($item->tax_deducted, 2) }}</td>
                                <td class="fw-bold text-success">${{ number_format($item->net_amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status === 'paid_out' ? 'success' : ($item->status === 'credited' ? 'info' : 'warning text-dark') }}">
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
            <div class="p-3">
                {{ $earnings->links() }}
            </div>
        </div>
    </div>

    <!-- Policy Note Banner -->
    <div class="alert alert-secondary bg-dark text-muted border-secondary small d-flex align-items-start gap-2">
        <i class="bi bi-info-square-fill fs-5 text-warning flex-shrink-0"></i>
        <div>
            <strong>Important Policy Note:</strong> AX India may update monetization policies, eligibility criteria, payout methods, minimum payout thresholds, and revenue sharing percentages based on business, operational, and legal requirements.
        </div>
    </div>
</div>

<!-- Payout & Bank Method Setup Modal -->
<div class="modal fade" id="payoutMethodModal" tabindex="-1" aria-labelledby="payoutMethodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-light border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold" id="payoutMethodModalLabel">
                    <i class="bi bi-bank text-warning me-2"></i>Payout & Bank Transfer Setup
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('creator.monetization.payout') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Preferred Payout Method</label>
                        <select name="payout_method" class="form-select bg-dark text-light border-secondary" id="payoutMethodSelect" required>
                            <option value="bank_transfer" {{ ($monetization->payout_method ?? 'bank_transfer') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer (NEFT/IMPS/SWIFT)</option>
                            <option value="upi" {{ ($monetization->payout_method ?? '') === 'upi' ? 'selected' : '' }}>UPI Payment (India)</option>
                            <option value="paypal" {{ ($monetization->payout_method ?? '') === 'paypal' ? 'selected' : '' }}>PayPal</option>
                        </select>
                    </div>

                    <!-- Bank Transfer Fields -->
                    <div id="bankFields" class="p-3 border rounded border-secondary mb-3 bg-black bg-opacity-25">
                        <div class="mb-3">
                            <label class="form-label small">Bank Name</label>
                            <input type="text" name="bank_name" class="form-control bg-dark text-light border-secondary" placeholder="e.g. HDFC Bank, State Bank of India" value="{{ $monetization->payout_details['bank_name'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small">Account Number</label>
                            <input type="text" name="account_number" class="form-control bg-dark text-light border-secondary" placeholder="Enter bank account number" value="{{ $monetization->payout_details['account_number'] ?? '' }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label small">IFSC / SWIFT Code</label>
                            <input type="text" name="ifsc_code" class="form-control bg-dark text-light border-secondary" placeholder="e.g. HDFC0001234" value="{{ $monetization->payout_details['ifsc_code'] ?? '' }}">
                        </div>
                    </div>

                    <!-- UPI Field -->
                    <div id="upiFields" class="p-3 border rounded border-secondary mb-3 bg-black bg-opacity-25 d-none">
                        <div class="mb-0">
                            <label class="form-label small">UPI ID / Virtual Payment Address</label>
                            <input type="text" name="upi_id" class="form-control bg-dark text-light border-secondary" placeholder="username@upi / mobile@paytm" value="{{ $monetization->payout_details['upi_id'] ?? '' }}">
                        </div>
                    </div>

                    <!-- PayPal Field -->
                    <div id="paypalFields" class="p-3 border rounded border-secondary mb-3 bg-black bg-opacity-25 d-none">
                        <div class="mb-0">
                            <label class="form-label small">PayPal Email Address</label>
                            <input type="email" name="paypal_email" class="form-control bg-dark text-light border-secondary" placeholder="email@example.com" value="{{ $monetization->payout_details['paypal_email'] ?? '' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">PAN / Tax Identification Number (Required for Tax Deduction/TDS)</label>
                        <input type="text" name="pan_tax_id" class="form-control bg-dark text-light border-secondary text-uppercase" placeholder="e.g. ABCDE1234F" value="{{ $monetization->payout_details['pan_tax_id'] ?? '' }}" required>
                        <small class="text-muted">Tax deduction (TDS) compliance requires a valid Tax ID/PAN.</small>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning fw-bold">Save Payout Details</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('payoutMethodSelect');
    const bankFields = document.getElementById('bankFields');
    const upiFields = document.getElementById('upiFields');
    const paypalFields = document.getElementById('paypalFields');

    function toggleFields() {
        bankFields.classList.add('d-none');
        upiFields.classList.add('d-none');
        paypalFields.classList.add('d-none');

        if (select.value === 'bank_transfer') {
            bankFields.classList.remove('d-none');
        } else if (select.value === 'upi') {
            upiFields.classList.remove('d-none');
        } else if (select.value === 'paypal') {
            paypalFields.classList.remove('d-none');
        }
    }

    select.addEventListener('change', toggleFields);
    toggleFields();
});
</script>
@endsection
