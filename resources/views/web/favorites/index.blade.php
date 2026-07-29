@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-white"><i class="bi bi-heart-fill text-danger me-2"></i>Favorite Videos</h4>
        <p class="text-muted small mb-0">Videos you have bookmarked to watch later or save</p>
    </div>

    @if(count($favorites) > 0)
        <div class="row g-4">
            @foreach($favorites as $fav)
                @if($fav->video)
                    <div class="col-xl-3 col-lg-4 col-md-6" id="favorite-card-{{ $fav->video_id }}">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                            <a href="{{ route('watch', $fav->video->slug) }}">
                                <img src="{{ asset($fav->video->thumbnail ?? 'images/default-thumbnail.jpg') }}" class="card-img-top" alt="" style="aspect-ratio: 16/9; object-fit: cover;">
                            </a>
                            <div class="card-body p-3">
                                <h6 class="fw-bold card-title text-truncate mb-1">
                                    <a href="{{ route('watch', $fav->video->slug) }}" class="text-light text-decoration-none">{{ $fav->video->title }}</a>
                                </h6>
                                <p class="text-muted small mb-2">{{ $fav->video->user?->full_name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="text-muted small"><i class="bi bi-eye me-1"></i>{{ number_format($fav->video->views_count) }}</span>
                                    <button class="btn btn-outline-danger btn-sm rounded-circle remove-fav-btn" data-id="{{ $fav->video_id }}" title="Remove from favorites">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-heart-break display-1 text-muted opacity-50"></i>
            <h5 class="mt-3 text-muted">No favorite videos added yet.</h5>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.remove-fav-btn').click(function() {
            let videoId = $(this).data('id');
            $.ajax({
                url: '{{ route("favorites.toggle") }}',
                method: 'POST',
                data: { video_id: videoId },
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res) {
                    $('#favorite-card-' + videoId).fadeOut(300, function() { $(this).remove(); });
                }
            });
        });
    });
</script>
@endsection
