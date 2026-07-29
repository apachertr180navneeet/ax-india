@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-white">Subscriptions & Payments Management</h2>
            <p class="text-muted">Review creator earnings, payouts, and subscription revenue shares</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Creator</th>
                        <th>Period</th>
                        <th>Ad Revenue</th>
                        <th>Membership Share</th>
                        <th>Total Payable</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payout)
                        <tr>
                            <td class="fw-bold text-white">{{ $payout->user->name ?? 'Creator' }}</td>
                            <td class="text-muted">{{ $payout->month ?? date('M Y') }}</td>
                            <td class="text-white">${{ number_format($payout->ad_revenue ?? 0, 2) }}</td>
                            <td class="text-white">${{ number_format($payout->membership_share ?? 0, 2) }}</td>
                            <td class="fw-bold text-success">${{ number_format($payout->amount ?? 0, 2) }}</td>
                            <td>
                                <span class="badge bg-{{ ($payout->status ?? 'pending') === 'completed' ? 'success' : 'warning' }}">
                                    {{ ucfirst($payout->status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                @if(($payout->status ?? 'pending') !== 'completed')
                                    <form action="{{ route('admin.payments.process', $payout->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill me-1">
                                            <i class="bi bi-currency-dollar me-1"></i>Process Payout
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted small"><i class="bi bi-check-circle-fill text-success me-1"></i>Completed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No pending creator payouts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
