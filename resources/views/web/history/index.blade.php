@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-white"><i class="bi bi-clock-history text-danger me-2"></i>Watch History</h4>
            <p class="text-muted small mb-0">Videos you have recently watched</p>
        </div>
        @if(count($history) > 0)
            <button id="clearHistoryBtn" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                <i class="bi bi-trash me-1"></i> Clear All History
            </button>
        @endif
    </div>

    @if(count($history) > 0)
        <div class="row g-3">
            @foreach($history as $item)
                @if($item->video)
                    <div class="col-12" id="history-item-{{ $item->video_id }}">
                        <div class="card border-0 shadow-sm rounded-3 p-3" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                            <div class="row align-items-center">
                                <div class="col-md-3 col-4">
                                    <a href="{{ route('watch', $item->video->slug) }}">
                                        <img src="{{ asset($item->video->thumbnail ?? 'images/default-thumbnail.jpg') }}" class="img-fluid rounded" alt="" style="aspect-ratio: 16/9; object-fit: cover;">
                                    </a>
                                </div>
                                <div class="col-md-8 col-7">
                                    <h6 class="fw-bold mb-1">
                                        <a href="{{ route('watch', $item->video->slug) }}" class="text-light text-decoration-none">{{ $item->video->title }}</a>
                                    </h6>
                                    <p class="text-muted small mb-1">{{ $item->video->user?->full_name }} · {{ number_format($item->video->views_count) }} views</p>
                                    <span class="badge bg-secondary text-light small">Watched {{ $item->updated_at?->diffForHumans() }}</span>
                                </div>
                                <div class="col-md-1 col-1 text-end">
                                    <button class="btn btn-link text-muted p-0 remove-item-btn" data-id="{{ $item->video_id }}" title="Remove item">
                                        <i class="bi bi-x-lg"></i>
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
            <i class="bi bi-clock-history display-1 text-muted opacity-50"></i>
            <h5 class="mt-3 text-muted">Your watch history is empty.</h5>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#clearHistoryBtn').click(function() {
            if(confirm('Are you sure you want to clear your entire watch history?')) {
                $.ajax({
                    url: '{{ route("history.clear") }}',
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(res) {
                        location.reload();
                    }
                });
            }
        });

        $('.remove-item-btn').click(function() {
            let videoId = $(this).data('id');
            $.ajax({
                url: '/history/' + videoId,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res) {
                    $('#history-item-' + videoId).fadeOut(300, function() { $(this).remove(); });
                }
            });
        });
    });
</script>
@endsection
