@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="serif-font fw-bold mb-1 text-dark">Creator Dashboard</h2>
            <p class="text-muted mb-0">Manage your channel, track performance and live streams</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('videos.upload') }}" class="btn-custom btn-primary-custom">
                <i class="bi bi-cloud-arrow-up me-1"></i> Upload Video
            </a>
            <a href="{{ route('creator.live') }}" class="btn-custom btn-outline-custom">
                <i class="bi bi-broadcast me-1 text-danger"></i> Go Live
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3">
                        <i class="bi bi-play-btn-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Videos</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalVideos) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Total Views</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalViews) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Subscribers</div>
                        <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalSubscribers) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-semibold">Estimated Revenue</div>
                        <h3 class="fw-bold mb-0 text-dark">${{ number_format($totalEarnings, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Uploads Table -->
    <div class="card border-0 shadow-sm rounded-4 p-3">
        <h5 class="fw-bold mb-3">Recent Uploads</h5>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Video</th>
                        <th>Status</th>
                        <th>Views</th>
                        <th>Likes</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentVideos as $video)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $video->thumbnail ?? 'https://via.placeholder.com/120x68' }}" class="rounded me-3" style="width: 80px; height: 45px; object-fit: cover;">
                                    <div>
                                        <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $video->title }}</div>
                                        <div class="small text-muted">{{ $video->is_short ? 'Short Video' : 'Standard Video' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ ($video->status->value ?? $video->status) === 'approved' ? 'success' : (($video->status->value ?? $video->status) === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($video->status->value ?? $video->status) }}
                                </span>
                            </td>
                            <td>{{ number_format($video->views_count) }}</td>
                            <td>{{ number_format($video->likes_count) }}</td>
                            <td>{{ $video->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-secondary">No videos uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
