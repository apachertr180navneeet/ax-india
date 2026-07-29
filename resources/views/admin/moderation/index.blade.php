@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Video Moderation</h2>

    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Video</th>
                        <th>Uploader</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($videos as $video)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $video->thumbnail ?? 'https://via.placeholder.com/120x68' }}" class="rounded me-3" style="width: 80px; height: 45px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark">{{ $video->title }}</div>
                                        <div class="small text-muted">{{ $video->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-dark">{{ $video->user->name ?? 'Unknown' }}</td>
                            <td>
                                <span class="badge bg-{{ $video->status === 'approved' ? 'success' : ($video->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($video->status->value) }}
                                </span>
                            </td>
                            <td>
                                @if($video->status !== 'approved')
                                    <form action="{{ route('admin.moderation.approve', $video->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill me-1"><i class="bi bi-check-lg"></i> Approve</button>
                                    </form>
                                @endif
                                @if($video->status !== 'rejected')
                                    <form action="{{ route('admin.moderation.reject', $video->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger rounded-pill"><i class="bi bi-x-lg"></i> Reject</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">No videos found for moderation.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
