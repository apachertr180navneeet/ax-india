@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-0 text-dark">Creator Verification Requests</h2>
            <p class="text-muted">Review identity documents and approve badge applications</p>
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
                        <th>User</th>
                        <th>Document Type</th>
                        <th>Document / ID</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle p-2 me-3 fw-bold">
                                        {{ strtoupper(substr($req->user->name ?? 'U', 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $req->user->name ?? 'Unknown User' }}</div>
                                        <div class="small text-muted">{{ $req->user->email ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge bg-secondary">{{ strtoupper($req->document_type ?? 'ID') }}</span></td>
                            <td>
                                @if($req->document_path)
                                    <a href="{{ asset('storage/' . $req->document_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="bi bi-file-earmark-text me-1"></i>View Document
                                    </a>
                                @else
                                    <span class="text-muted small">No file provided</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $req->status === 'approved' ? 'success' : ($req->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($req->status ?? 'pending') }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $req->created_at ? $req->created_at->diffForHumans() : '-' }}</td>
                            <td>
                                @if($req->status !== 'approved')
                                    <form action="{{ route('admin.verifications.approve', $req->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill me-1">
                                            <i class="bi bi-check-circle me-1"></i>Approve
                                        </button>
                                    </form>
                                @endif
                                @if($req->status !== 'rejected')
                                    <form action="{{ route('admin.verifications.reject', $req->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>Reject
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No creator verification requests found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($requests->hasPages())
            <div class="mt-3">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
