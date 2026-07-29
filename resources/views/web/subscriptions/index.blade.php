@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1"><i class="bi bi-bell-fill text-primary me-2"></i>Subscriptions Feed</h4>
        <p class="text-muted small mb-0">Latest uploads from channels you follow</p>
    </div>

    @if(count($subscriptions) > 0)
        <div class="d-flex gap-3 overflow-auto pb-3 mb-4">
            @foreach($subscriptions as $sub)
                @if($sub->creator)
                    <a href="{{ route('channel', $sub->creator->profile?->username ?? $sub->creator_id) }}" class="text-center text-decoration-none text-dark flex-shrink-0" style="width: 80px;">
                        <img src="{{ asset($sub->creator->profile?->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle mb-1 border border-2 border-primary p-1" width="60" height="60" style="object-fit: cover;">
                        <p class="small text-truncate mb-0 fw-semibold">{{ $sub->creator->full_name }}</p>
                    </a>
                @endif
            @endforeach
        </div>
    @endif

    @if(count($feed) > 0)
        <div class="row g-4">
            @foreach($feed as $video)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                        <a href="{{ route('watch', $video->slug) }}">
                            <img src="{{ asset($video->thumbnail ?? 'images/default-thumbnail.jpg') }}" class="card-img-top" alt="" style="aspect-ratio: 16/9; object-fit: cover;">
                        </a>
                        <div class="card-body p-3">
                            <h6 class="fw-bold card-title text-truncate mb-1">
                                <a href="{{ route('watch', $video->slug) }}" class="text-dark text-decoration-none">{{ $video->title }}</a>
                            </h6>
                            <p class="text-muted small mb-2">{{ $video->user?->full_name }} · {{ number_format($video->views_count) }} views</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-youtube display-1 text-muted opacity-50"></i>
            <h5 class="mt-3 text-muted">No recent videos from your subscriptions.</h5>
        </div>
    @endif
</div>
@endsection
