<div class="card video-card h-100 border-0 shadow-sm">
    <div class="position-relative">
        <img src="{{ asset($video->thumbnail ?? 'images/default-thumbnail.jpg') }}" class="card-img-top" alt="{{ $video->title }}" style="aspect-ratio:16/9;object-fit:cover;">
        <span class="position-absolute bottom-0 end-0 bg-dark text-white px-1 small m-1 rounded">{{ $video->formatted_duration ?? '00:00' }}</span>
    </div>
    <div class="card-body px-0">
        <div class="d-flex">
            <a href="{{ route('channel', $video->user?->profile?->username ?? $video->user_id) }}">
                <img src="{{ asset($video->user?->profile?->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle me-2" width="36" height="36" alt="">
            </a>
            <div class="flex-grow-1 min-width-0">
                <h6 class="card-title mb-1 text-truncate-2 fw-semibold" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
                    <a href="{{ route('watch', $video->slug) }}" class="text-decoration-none text-dark">{{ $video->title }}</a>
                </h6>
                <p class="card-text text-muted small mb-0">{{ $video->user?->full_name ?? 'Unknown' }}</p>
                <p class="card-text text-muted small">{{ number_format($video->views_count) }} views · {{ $video->created_at?->diffForHumans() }}</p>
            </div>
        </div>
    </div>
</div>
