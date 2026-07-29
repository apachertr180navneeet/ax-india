@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-white">Creator Dashboard</h2>
            <p class="mb-0" style="color: #aaaaaa;">Manage your channel, track performance and live streams</p>
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
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(255, 0, 51, 0.15); color: var(--accent-red); font-size: 1.4rem;">
                        <i class="bi bi-play-btn-fill"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Total Videos</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.6rem;">{{ number_format($totalVideos) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(62, 166, 255, 0.15); color: #3ea6ff; font-size: 1.4rem;">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Total Views</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.6rem;">{{ number_format($totalViews) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(168, 85, 247, 0.15); color: #a855f7; font-size: 1.4rem;">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Subscribers</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.6rem;">{{ number_format($totalSubscribers) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="stat-icon-wrapper me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(34, 197, 94, 0.15); color: #22c55e; font-size: 1.4rem;">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Estimated Revenue</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.6rem;">${{ number_format($totalEarnings, 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Uploads Table -->
    <div class="card border-0 rounded-4 p-4" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
        <h5 class="fw-bold mb-3 text-white">Recent Uploads</h5>
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="background-color: var(--yt-dark-card); color: #f1f1f1; border-color: var(--yt-border);">
                <thead>
                    <tr style="border-bottom: 1px solid var(--yt-border); color: #aaaaaa; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Video</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Status</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Views</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Likes</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Date</th>
                    </tr>
                </thead>
                <tbody style="border-top: none;">
                    @forelse($recentVideos as $video)
                        <tr style="border-bottom: 1px solid var(--yt-border);">
                            <td style="background: transparent; padding: 0.85rem 1rem;">
                                <div class="d-flex align-items-center">
                                    @if($video->thumbnail)
                                        <img src="{{ asset($video->thumbnail) }}" class="rounded me-3" style="width: 84px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="rounded me-3 d-flex align-items-center justify-content-center" style="width: 84px; height: 48px; background: #282828; color: #717171; font-size: 1.2rem;">
                                            <i class="bi bi-play-btn"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-white text-truncate" style="max-width: 280px; font-size: 0.92rem;">{{ $video->title }}</div>
                                        <div class="small" style="color: #aaaaaa;">{{ $video->is_short ? 'Short Video' : 'Standard Video' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="background: transparent; padding: 0.85rem 1rem;">
                                <span class="badge px-3 py-2 rounded-pill fw-semibold bg-{{ ($video->status->value ?? $video->status) === 'approved' ? 'success' : (($video->status->value ?? $video->status) === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($video->status->value ?? $video->status) }}
                                </span>
                            </td>
                            <td style="background: transparent; color: #f1f1f1; padding: 0.85rem 1rem;">{{ number_format($video->views_count) }}</td>
                            <td style="background: transparent; color: #f1f1f1; padding: 0.85rem 1rem;">{{ number_format($video->likes_count) }}</td>
                            <td style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">{{ $video->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4" style="background: transparent; color: #aaaaaa;">No videos uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
