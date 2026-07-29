@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 mb-4 p-4" style="background: linear-gradient(135deg, var(--almond-silk), var(--almond-cream)); border: 1px solid var(--bone) !important;">
        <h4 class="fw-bold mb-1 text-dark serif-font">{{ $playlist->title }}</h4>
        <p class="mb-2 text-dark opacity-75">{{ $playlist->description ?? 'No description' }}</p>
        <span class="badge bg-white text-dark align-self-start text-capitalize border fw-semibold">{{ $playlist->visibility }} · {{ count($playlist->videos) }} videos</span>
    </div>

    @if(count($playlist->videos) > 0)
        <div class="row g-3">
            @foreach($playlist->videos as $video)
                <div class="col-12" id="playlist-video-{{ $video->id }}">
                    <div class="card border-0 shadow-sm rounded-3 p-3">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-4">
                                <a href="{{ route('watch', $video->slug) }}">
                                    <img src="{{ asset($video->thumbnail ?? 'images/default-thumbnail.jpg') }}" class="img-fluid rounded" alt="" style="aspect-ratio: 16/9; object-fit: cover;">
                                </a>
                            </div>
                            <div class="col-md-8 col-7">
                                <h6 class="fw-bold mb-1">
                                    <a href="{{ route('watch', $video->slug) }}" class="text-dark text-decoration-none">{{ $video->title }}</a>
                                </h6>
                                <p class="text-muted small mb-0">{{ $video->user?->full_name }} · {{ number_format($video->views_count) }} views</p>
                            </div>
                            @auth
                                @if(Auth::id() === $playlist->user_id)
                                    <div class="col-md-1 col-1 text-end">
                                        <button class="btn btn-link text-danger p-0 remove-video-btn" data-playlist-id="{{ $playlist->id }}" data-video-id="{{ $video->id }}" title="Remove from playlist">
                                            <i class="bi bi-x-circle-fill fs-5"></i>
                                        </button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-music-note-list display-1 text-muted opacity-50"></i>
            <h5 class="mt-3 text-muted">This playlist is empty.</h5>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.remove-video-btn').click(function() {
            let playlistId = $(this).data('playlist-id');
            let videoId = $(this).data('video-id');
            $.ajax({
                url: '/playlists/' + playlistId + '/videos/' + videoId,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res) {
                    $('#playlist-video-' + videoId).fadeOut(300, function() { $(this).remove(); });
                }
            });
        });
    });
</script>
@endsection
