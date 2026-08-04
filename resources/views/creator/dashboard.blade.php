@extends('web.layouts.app')

@section('content')
<div class="container py-4" id="creatorDashboardPage">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-3">
        <div>
            <h2 class="fw-bold mb-1 text-white">Creator Dashboard</h2>
            <p class="mb-0" style="color: #aaaaaa;">Manage your channel, track performance and live streams</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('videos.upload') }}" class="btn-custom btn-primary-custom">
                <i class="bi bi-cloud-arrow-up me-1"></i> Upload Video
            </a>
            <a href="{{ route('creator.live') }}" class="btn-custom btn-outline-custom">
                <i class="bi bi-broadcast me-1 text-danger"></i> Go Live
            </a>
        </div>
    </div>

    <div class="creator-studio-nav mb-4" role="navigation" aria-label="Creator studio">
        <a href="{{ route('creator.dashboard') }}" class="creator-studio-nav-item active"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a>
        <a href="{{ route('creator.analytics') }}" class="creator-studio-nav-item"><i class="bi bi-graph-up me-1"></i>Analytics</a>
        <a href="{{ route('creator.subscribers') }}" class="creator-studio-nav-item"><i class="bi bi-people me-1"></i>Subscribers</a>
        <a href="{{ route('creator.monetization') }}" class="creator-studio-nav-item"><i class="bi bi-wallet2 me-1"></i>Revenue</a>
        <a href="{{ route('creator.live') }}" class="creator-studio-nav-item"><i class="bi bi-broadcast me-1"></i>Live</a>
        <a href="{{ route('videos.upload') }}" class="creator-studio-nav-item"><i class="bi bi-cloud-arrow-up me-1"></i>Upload</a>
        <a href="{{ route('shorts.index') }}" class="creator-studio-nav-item"><i class="bi bi-phone me-1"></i>Shorts</a>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <a href="{{ route('videos.upload') }}" class="text-decoration-none">
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
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('creator.analytics') }}" class="text-decoration-none">
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
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('creator.subscribers') }}" class="text-decoration-none">
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
            </a>
        </div>
        <div class="col-6 col-md-3">
            <a href="{{ route('creator.monetization') }}" class="text-decoration-none">
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
            </a>
        </div>
    </div>

    <!-- Studio options -->
    <div class="mb-4">
        <h5 class="fw-bold mb-3 text-white">Studio</h5>
        <div class="row g-3">
            @php
                $studioLinks = [
                    ['route' => 'creator.analytics', 'icon' => 'bi-graph-up', 'color' => '#696cff', 'bg' => 'rgba(105,108,255,.12)', 'title' => 'Analytics', 'desc' => 'Views, traffic & top videos'],
                    ['route' => 'creator.subscribers', 'icon' => 'bi-people', 'color' => '#a855f7', 'bg' => 'rgba(168,85,247,.12)', 'title' => 'Subscribers', 'desc' => 'Manage your audience'],
                    ['route' => 'creator.monetization', 'icon' => 'bi-wallet2', 'color' => '#22c55e', 'bg' => 'rgba(34,197,94,.12)', 'title' => 'Monetization', 'desc' => 'Revenue, payouts & eligibility'],
                    ['route' => 'creator.live', 'icon' => 'bi-broadcast', 'color' => '#ef4444', 'bg' => 'rgba(239,68,68,.12)', 'title' => 'Go Live', 'desc' => 'Stream key & live studio'],
                    ['route' => 'videos.upload', 'icon' => 'bi-cloud-arrow-up', 'color' => '#3ea6ff', 'bg' => 'rgba(62,166,255,.12)', 'title' => 'Upload Video', 'desc' => 'Title, tags, thumbnail & visibility'],
                    ['route' => 'shorts.index', 'icon' => 'bi-phone', 'color' => '#f59e0b', 'bg' => 'rgba(245,158,11,.12)', 'title' => 'Short Videos', 'desc' => 'Browse & watch Shorts'],
                ];
            @endphp
            @foreach($studioLinks as $link)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route($link['route']) }}" class="text-decoration-none creator-studio-card">
                        <div class="card border-0 rounded-4 p-3 h-100 text-center" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                            <div class="mx-auto mb-2 d-flex align-items-center justify-content-center rounded-circle" style="width:44px;height:44px;background:{{ $link['bg'] }};color:{{ $link['color'] }};font-size:1.25rem;">
                                <i class="bi {{ $link['icon'] }}"></i>
                            </div>
                            <div class="fw-bold text-white" style="font-size:0.92rem;">{{ $link['title'] }}</div>
                            <div class="small mt-1" style="color:#aaaaaa;font-size:0.75rem;">{{ $link['desc'] }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Uploads Table -->
    <div class="card border-0 rounded-4 p-4" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3">
            <h5 class="fw-bold mb-0 text-white">Recent Uploads</h5>
            <a href="{{ route('creator.analytics') }}" class="btn-custom btn-outline-custom btn-sm"><i class="bi bi-graph-up me-1"></i> View Analytics</a>
        </div>
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

@section('style')
<style>
.creator-studio-nav {
    display: inline-flex;
    flex-wrap: nowrap;
    align-items: center;
    gap: 2px;
    padding: 4px;
    background: rgba(105, 108, 255, 0.08);
    border: 1px solid rgba(105, 108, 255, 0.22);
    border-radius: 999px;
    max-width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none;
}
.creator-studio-nav::-webkit-scrollbar {
    display: none;
}
.creator-studio-nav-item {
    display: inline-flex;
    align-items: center;
    border: none;
    background: transparent;
    color: #8592a3;
    font-size: 0.8125rem;
    font-weight: 600;
    line-height: 1.2;
    padding: 0.45rem 0.95rem;
    border-radius: 999px;
    text-decoration: none;
    white-space: nowrap;
    flex: 0 0 auto;
    transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
}
.creator-studio-nav-item:hover {
    color: #696cff;
    background: rgba(105, 108, 255, 0.1);
}
.creator-studio-nav-item.active {
    color: #fff;
    background: #696cff;
    box-shadow: 0 2px 8px rgba(105, 108, 255, 0.35);
}
.creator-studio-card .card {
    transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
}
.creator-studio-card:hover .card {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(105, 108, 255, 0.12);
    border-color: rgba(105, 108, 255, 0.35) !important;
}
@media (max-width: 991.98px) {
    .creator-studio-nav {
        display: flex;
        width: 100%;
    }
}
@media (max-width: 767.98px) {
    .creator-studio-nav-item {
        padding: 0.42rem 0.8rem;
        font-size: 0.75rem;
    }
}
</style>
@endsection
