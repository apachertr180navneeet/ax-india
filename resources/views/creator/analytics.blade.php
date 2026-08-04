@extends('web.layouts.app')

@section('content')
<div class="container py-4" id="creatorAnalyticsPage">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-white">Channel Analytics</h2>
            <p class="mb-0" style="color: #aaaaaa;">Track views, engagement, and top performing videos</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('creator.dashboard') }}" class="btn-custom btn-outline-custom">
                <i class="bi bi-speedometer2 me-1"></i> Dashboard
            </a>
            <a href="{{ route('creator.subscribers') }}" class="btn-custom btn-outline-custom">
                <i class="bi bi-people me-1"></i> Subscribers
            </a>
            <a href="{{ route('creator.monetization') }}" class="btn-custom btn-outline-custom">
                <i class="bi bi-wallet2 me-1"></i> Revenue
            </a>
            <a href="{{ route('videos.upload') }}" class="btn-custom btn-primary-custom">
                <i class="bi bi-cloud-arrow-up me-1"></i> Upload
            </a>
        </div>
    </div>

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-4">
        <div class="analytics-period-filters" role="tablist" aria-label="Analytics period">
            <button type="button" class="analytics-period-btn active" data-period="7">Last 7 days</button>
            <button type="button" class="analytics-period-btn" data-period="28">Last 28 days</button>
            <button type="button" class="analytics-period-btn" data-period="90">Last 90 days</button>
            <button type="button" class="analytics-period-btn" data-period="lifetime">Lifetime</button>
        </div>
        <span class="small" style="color: #aaaaaa;" id="analyticsPeriodLabel">Showing last 7 days (UI demo)</span>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(62, 166, 255, 0.15); color: #3ea6ff; font-size: 1.35rem;">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Total Views</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.45rem;">{{ number_format($totalViews) }}</h3>
                        <div class="small text-success fw-semibold"><i class="bi bi-arrow-up-right"></i> +12.4%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(255, 0, 51, 0.15); color: var(--accent-red); font-size: 1.35rem;">
                        <i class="bi bi-hand-thumbs-up-fill"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Total Likes</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.45rem;">{{ number_format($totalLikes) }}</h3>
                        <div class="small text-success fw-semibold"><i class="bi bi-arrow-up-right"></i> +8.1%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(168, 85, 247, 0.15); color: #a855f7; font-size: 1.35rem;">
                        <i class="bi bi-chat-dots-fill"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Comments</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.45rem;">{{ number_format($totalComments) }}</h3>
                        <div class="small text-success fw-semibold"><i class="bi bi-arrow-up-right"></i> +5.6%</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex align-items-center">
                    <div class="me-3 d-flex align-items-center justify-content-center rounded-circle" style="width: 48px; height: 48px; background: rgba(34, 197, 94, 0.15); color: #22c55e; font-size: 1.35rem;">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <div class="small fw-semibold" style="color: #aaaaaa;">Est. Revenue</div>
                        <h3 class="fw-bold mb-0 text-white" style="font-size: 1.45rem;">${{ number_format($totalEarnings, 2) }}</h3>
                        <div class="small text-success fw-semibold"><i class="bi bi-arrow-up-right"></i> +3.2%</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="card border-0 rounded-4 p-4 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 text-white">Views over time</h5>
                    <span class="badge rounded-pill" style="background: rgba(62,166,255,0.15); color: #3ea6ff;">UI chart</span>
                </div>
                <div class="analytics-chart" id="analyticsChart">
                    @php
                        $bars = [
                            ['label' => 'Mon', 'h' => 42],
                            ['label' => 'Tue', 'h' => 58],
                            ['label' => 'Wed', 'h' => 35],
                            ['label' => 'Thu', 'h' => 72],
                            ['label' => 'Fri', 'h' => 64],
                            ['label' => 'Sat', 'h' => 88],
                            ['label' => 'Sun', 'h' => 76],
                        ];
                    @endphp
                    @foreach($bars as $bar)
                        <div class="analytics-bar-col">
                            <div class="analytics-bar" style="height: {{ $bar['h'] }}%;" data-base="{{ $bar['h'] }}"></div>
                            <span>{{ $bar['label'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 rounded-4 p-4 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <h5 class="fw-bold mb-3 text-white">Traffic sources</h5>
                @php
                    $sources = [
                        ['name' => 'AX India search', 'pct' => 38, 'color' => '#3ea6ff'],
                        ['name' => 'Suggested videos', 'pct' => 27, 'color' => '#a855f7'],
                        ['name' => 'External / shared', 'pct' => 18, 'color' => '#22c55e'],
                        ['name' => 'Channel pages', 'pct' => 11, 'color' => '#f59e0b'],
                        ['name' => 'Direct / other', 'pct' => 6, 'color' => '#94a3b8'],
                    ];
                @endphp
                @foreach($sources as $source)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small mb-1">
                            <span class="text-white fw-semibold">{{ $source['name'] }}</span>
                            <span style="color: #aaaaaa;">{{ $source['pct'] }}%</span>
                        </div>
                        <div class="analytics-source-track">
                            <div class="analytics-source-fill" style="width: {{ $source['pct'] }}%; background: {{ $source['color'] }};"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="small fw-semibold mb-1" style="color: #aaaaaa;">Avg. view duration</div>
                <h4 class="fw-bold text-white mb-0">4:32</h4>
                <div class="small text-success mt-1"><i class="bi bi-arrow-up-right"></i> +18 sec vs last period</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="small fw-semibold mb-1" style="color: #aaaaaa;">Click-through rate</div>
                <h4 class="fw-bold text-white mb-0">6.8%</h4>
                <div class="small text-success mt-1"><i class="bi bi-arrow-up-right"></i> +0.4% vs last period</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="small fw-semibold mb-1" style="color: #aaaaaa;">Returning viewers</div>
                <h4 class="fw-bold text-white mb-0">41%</h4>
                <div class="small" style="color: #aaaaaa;">of total watch time</div>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 p-4" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0 text-white">Top videos</h5>
            <span class="small" style="color: #aaaaaa;">By views</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0" style="background-color: var(--yt-dark-card); color: #f1f1f1; border-color: var(--yt-border);">
                <thead>
                    <tr style="border-bottom: 1px solid var(--yt-border); color: #aaaaaa; font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.05em;">
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">#</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Video</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Views</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Likes</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Comments</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Published</th>
                    </tr>
                </thead>
                <tbody style="border-top: none;">
                    @forelse($topVideos as $index => $video)
                        <tr style="border-bottom: 1px solid var(--yt-border);">
                            <td style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">{{ $index + 1 }}</td>
                            <td style="background: transparent; padding: 0.85rem 1rem;">
                                <div class="d-flex align-items-center">
                                    @if($video->thumbnail)
                                        <img src="{{ asset($video->thumbnail) }}" class="rounded me-3" alt="" style="width: 84px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="rounded me-3 d-flex align-items-center justify-content-center" style="width: 84px; height: 48px; background: #282828; color: #717171; font-size: 1.2rem;">
                                            <i class="bi bi-play-btn"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold text-white text-truncate" style="max-width: 280px; font-size: 0.92rem;">{{ $video->title }}</div>
                                        <div class="small" style="color: #aaaaaa;">{{ !empty($video->is_short) ? 'Short Video' : 'Standard Video' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="background: transparent; color: #f1f1f1; padding: 0.85rem 1rem;">{{ number_format($video->views_count ?? 0) }}</td>
                            <td style="background: transparent; color: #f1f1f1; padding: 0.85rem 1rem;">{{ number_format($video->likes_count ?? 0) }}</td>
                            <td style="background: transparent; color: #f1f1f1; padding: 0.85rem 1rem;">{{ number_format($video->comments_count ?? 0) }}</td>
                            <td style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">{{ optional($video->created_at)->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4" style="background: transparent; color: #aaaaaa;">No videos yet. Upload content to see analytics.</td>
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
    .analytics-period-filters {
        display: inline-flex;
        flex-wrap: wrap;
        gap: 2px;
        padding: 4px;
        background: var(--lavender-light);
        border: 1px solid var(--yt-border);
        border-radius: 999px;
    }
    .analytics-period-btn {
        border: none;
        background: transparent;
        color: var(--text-muted);
        font-size: 0.82rem;
        font-weight: 600;
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .analytics-period-btn:hover { color: var(--accent-red); }
    .analytics-period-btn.active {
        background: var(--accent-red);
        color: #fff;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.35);
    }
    .analytics-chart {
        display: flex;
        align-items: flex-end;
        gap: 0.65rem;
        height: 220px;
        padding-top: 0.5rem;
    }
    .analytics-bar-col {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        justify-content: flex-end;
        gap: 0.45rem;
    }
    .analytics-bar {
        width: 100%;
        max-width: 42px;
        border-radius: 10px 10px 4px 4px;
        background: linear-gradient(180deg, #60a5fa, #3b82f6);
        min-height: 8px;
        transition: height 0.35s ease;
    }
    .analytics-bar-col span {
        font-size: 0.75rem;
        color: #aaaaaa;
        font-weight: 600;
    }
    .analytics-source-track {
        height: 8px;
        border-radius: 999px;
        background: rgba(148, 163, 184, 0.25);
        overflow: hidden;
    }
    .analytics-source-fill {
        height: 100%;
        border-radius: 999px;
    }
</style>
@endsection

@section('script')
<script>
(function () {
    const page = document.getElementById('creatorAnalyticsPage');
    if (!page) return;

    const label = document.getElementById('analyticsPeriodLabel');
    const labels = {
        '7': 'Showing last 7 days (UI demo)',
        '28': 'Showing last 28 days (UI demo)',
        '90': 'Showing last 90 days (UI demo)',
        'lifetime': 'Showing lifetime (UI demo)'
    };
    const scales = { '7': 1, '28': 1.15, '90': 1.3, lifetime: 1.45 };

    page.querySelectorAll('.analytics-period-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            page.querySelectorAll('.analytics-period-btn').forEach(function (b) { b.classList.remove('active'); });
            btn.classList.add('active');
            const period = btn.dataset.period;
            label.textContent = labels[period] || labels['7'];
            const scale = scales[period] || 1;
            page.querySelectorAll('.analytics-bar').forEach(function (bar) {
                const base = parseFloat(bar.dataset.base) || 40;
                bar.style.height = Math.min(100, Math.round(base * scale)) + '%';
            });
        });
    });
})();
</script>
@endsection
