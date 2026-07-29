@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Creator Dashboard</h2>
            <p class="text-secondary">Manage your channel, track performance and live streams</p>
        </div>
        <div>
            <a href="{{ route('videos.upload') }}" class="btn btn-danger me-2">
                <i class="bi bi-upload me-1"></i> Upload Video
            </a>
            <a href="{{ route('creator.live') }}" class="btn btn-outline-danger">
                <i class="bi bi-broadcast me-1"></i> Go Live
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-danger bg-opacity-25 text-danger rounded-circle p-3 me-3">
                        <i class="bi bi-play-btn fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Videos</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalVideos) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-25 text-primary rounded-circle p-3 me-3">
                        <i class="bi bi-eye fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Total Views</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalViews) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-25 text-warning rounded-circle p-3 me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Subscribers</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($totalSubscribers) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-25 text-success rounded-circle p-3 me-3">
                        <i class="bi bi-currency-dollar fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Estimated Revenue</div>
                        <h4 class="fw-bold mb-0 text-dark">${{ number_format($totalEarnings, 2) }}</h4>
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
                                <span class="badge bg-{{ $video->status === 'approved' ? 'success' : ($video->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($video->status) }}
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
