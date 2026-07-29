@extends('web.layouts.app')
@section('title', $channel->full_name . ' - AX India')
@section('content')
    <div class="mb-4">
        <div class="bg-secondary rounded" style="height:200px;background:url('{{ asset($channel->profile?->cover ?? 'images/default-cover.jpg') }}') center/cover no-repeat;"></div>
        <div class="d-flex align-items-end mt-n4 px-3">
            <img src="{{ asset($channel->profile?->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle border border-4 border-white shadow-sm" width="80" height="80" alt="">
            <div class="ms-3 mb-1 flex-grow-1">
                <h5 class="fw-bold mb-0">{{ $channel->full_name }}</h5>
                <p class="text-muted small mb-0">@ {{ $channel->profile?->username ?? $channel->username }}</p>
                <p class="text-muted small mb-0">{{ number_format($subscriberCount) }} subscribers · {{ $videos->count() }} videos</p>
            </div>
            @auth
                @if (Auth::id() !== $channel->id)
                    <button class="btn btn-danger subscribe-btn mb-2" data-creator-id="{{ $channel->id }}">{{ $isSubscribed ? 'Subscribed' : 'Subscribe' }}</button>
                @endif
            @endauth
        </div>
    </div>
    <ul class="nav nav-tabs mb-4" id="channelTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="videos-tab" data-bs-toggle="tab" data-bs-target="#videos" type="button"><i class="fas fa-video me-1"></i>Videos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="playlists-tab" data-bs-toggle="tab" data-bs-target="#playlists" type="button"><i class="fas fa-list me-1"></i>Playlists</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button"><i class="fas fa-info-circle me-1"></i>About</button>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="videos" role="tabpanel">
            <div class="row g-3">
                @forelse ($videos as $video)
                    <div class="col-lg-3 col-md-4 col-sm-6">@include('partials.video-card')</div>
                @empty
                    <div class="col-12 text-center py-5"><i class="fas fa-video fa-3x text-muted mb-3"></i><p class="text-muted">No videos yet.</p></div>
                @endforelse
            </div>
        </div>
        <div class="tab-pane fade" id="playlists" role="tabpanel">
            <div class="row g-3">
                @forelse ($playlists as $playlist)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card border-0 shadow-sm h-100">
                            <img src="{{ asset($playlist->thumbnail ?? 'images/default-thumbnail.jpg') }}" class="card-img-top" alt="" style="aspect-ratio:16/9;object-fit:cover;">
                            <div class="card-body">
                                <h6 class="fw-semibold">{{ $playlist->name }}</h6>
                                <p class="text-muted small mb-0">{{ $playlist->videos_count ?? 0 }} videos</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5"><i class="fas fa-list fa-3x text-muted mb-3"></i><p class="text-muted">No playlists yet.</p></div>
                @endforelse
            </div>
        </div>
        <div class="tab-pane fade" id="about" role="tabpanel">
            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-semibold">Description</h6>
                <p>{{ $channel->profile?->bio ?? 'No description.' }}</p>
                <h6 class="fw-semibold mt-3">Details</h6>
                <p class="mb-1 small"><i class="fas fa-calendar me-2"></i>Joined {{ $channel->created_at?->format('F Y') ?? 'N/A' }}</p>
                @if ($channel->profile?->website)
                    <p class="mb-1 small"><i class="fas fa-link me-2"></i><a href="{{ $channel->profile->website }}" target="_blank">{{ $channel->profile->website }}</a></p>
                @endif
            </div>
        </div>
    </div>
@endsection
