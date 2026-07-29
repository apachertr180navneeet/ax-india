@extends('web.layouts.app')
@section('title', $video->title . ' - AX India')
@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-3 rounded overflow-hidden">
                @include('partials.video-player')
            </div>
            <h5 class="fw-semibold mb-2">{{ $video->title }}</h5>
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted small">{{ number_format($video->views_count) }} views · {{ $video->created_at?->diffForHumans() }}</span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-sm btn-outline-secondary like-btn" data-id="{{ $video->id }}" data-type="like">
                        <i class="far fa-thumbs-up"></i> <span class="like-count">{{ $video->likes_count ?? 0 }}</span>
                    </button>
                    <button class="btn btn-sm btn-outline-secondary like-btn" data-id="{{ $video->id }}" data-type="dislike">
                        <i class="far fa-thumbs-down"></i> <span class="dislike-count">{{ $video->dislikes_count ?? 0 }}</span>
                    </button>
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-share-alt"></i> Share</button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item copy-link-btn" data-url="{{ route('watch', $video->slug) }}"><i class="fas fa-link me-2"></i>Copy Link</button></li>
                            <li><a class="dropdown-item" href="https://wa.me/?text={{ urlencode(route('watch', $video->slug)) }}" target="_blank"><i class="fab fa-whatsapp me-2"></i>WhatsApp</a></li>
                            <li><a class="dropdown-item" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('watch', $video->slug)) }}" target="_blank"><i class="fab fa-facebook me-2"></i>Facebook</a></li>
                            <li><a class="dropdown-item" href="https://twitter.com/intent/tweet?url={{ urlencode(route('watch', $video->slug)) }}" target="_blank"><i class="fab fa-twitter me-2"></i>Twitter</a></li>
                            <li><a class="dropdown-item" href="https://telegram.me/share/url?url={{ urlencode(route('watch', $video->slug)) }}" target="_blank"><i class="fab fa-telegram me-2"></i>Telegram</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded mb-3">
                <div class="d-flex align-items-center">
                    <a href="{{ route('channel', $video->user_id) }}">
                        <img src="{{ asset($video->user?->profile?->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle me-2" width="40" height="40" alt="">
                    </a>
                    <div>
                        <a href="{{ route('channel', $video->user_id) }}" class="text-decoration-none fw-semibold text-dark">{{ $video->user?->full_name ?? 'Unknown' }}</a>
                        <p class="mb-0 text-muted small">{{ number_format($video->user?->profile?->subscribers_count ?? 0) }} subscribers</p>
                    </div>
                </div>
                @auth
                    <button class="btn btn-danger btn-sm subscribe-btn" data-creator-id="{{ $video->user_id }}">
                        {{ $isSubscribed ?? false ? 'Subscribed' : 'Subscribe' }}
                    </button>
                @endauth
            </div>
            <div class="bg-light p-3 rounded mb-4">
                <p class="mb-1 text-break">{{ $video->description ?? 'No description.' }}</p>
            </div>
            <h6 class="fw-semibold mb-3">{{ count($comments) }} Comments</h6>
            @auth
                <form action="{{ route('comments.store', $video->id) }}" method="POST" class="mb-4">
                    @csrf
                    <div class="d-flex gap-2">
                        <img src="{{ asset(Auth::user()->profile?->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle" width="36" height="36" alt="">
                        <div class="flex-grow-1">
                            <textarea name="body" class="form-control" rows="2" placeholder="Add a comment..." required></textarea>
                            <div class="mt-2 text-end">
                                <button type="submit" class="btn btn-primary btn-sm">Comment</button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <p class="text-muted mb-4"><a href="{{ route('login') }}">Sign in</a> to add a comment.</p>
            @endauth
            @foreach ($comments as $comment)
                <div class="d-flex mb-3">
                    <img src="{{ asset($comment->user?->profile?->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle me-2" width="36" height="36" alt="">
                    <div>
                        <p class="mb-0 small fw-semibold">{{ $comment->user?->full_name ?? 'Unknown' }} <span class="text-muted fw-normal ms-2">{{ $comment->created_at?->diffForHumans() }}</span></p>
                        <p class="mb-1">{{ $comment->body }}</p>
                        <button class="btn btn-sm btn-outline-secondary comment-like-btn" data-id="{{ $comment->id }}"><i class="far fa-thumbs-up"></i> {{ $comment->likes_count ?? 0 }}</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-lg-4">
            <h6 class="fw-semibold mb-3">Related Videos</h6>
            @forelse ($relatedVideos as $related)
                <div class="d-flex mb-3">
                    <a href="{{ route('watch', $related->slug) }}" class="flex-shrink-0 me-2">
                        <img src="{{ asset($related->thumbnail ?? 'images/default-thumbnail.jpg') }}" alt="" width="168" height="94" style="object-fit:cover;border-radius:8px;">
                    </a>
                    <div class="flex-grow-1 min-width-0">
                        <a href="{{ route('watch', $related->slug) }}" class="text-decoration-none text-dark fw-semibold small" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $related->title }}</a>
                        <p class="text-muted small mb-0">{{ $related->user?->full_name ?? 'Unknown' }}</p>
                        <p class="text-muted small">{{ number_format($related->views_count) }} views</p>
                    </div>
                </div>
            @empty
                <p class="text-muted small">No related videos.</p>
            @endforelse
        </div>
    </div>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('.copy-link-btn').click(function() {
            navigator.clipboard.writeText($(this).data('url'));
            alert('Link copied!');
        });
    });
</script>
@endpush
