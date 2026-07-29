@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-bell-fill text-primary me-2"></i>Notifications</h4>
            <p class="text-muted small mb-0">Stay updated with channel activity, comments, and likes</p>
        </div>
        @if(count($notifications) > 0)
            <button id="readAllBtn" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                <i class="bi bi-check2-all me-1"></i> Mark All as Read
            </button>
        @endif
    </div>

    @if(count($notifications) > 0)
        <div class="list-group border-0 shadow-sm rounded-4 overflow-hidden">
            @foreach($notifications as $notif)
                <div class="list-group-item list-group-item-action border-0 p-3 {{ $notif->is_read ? 'bg-white' : 'bg-light fw-semibold' }}" id="notif-item-{{ $notif->id }}">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary text-white rounded-circle p-2 me-3">
                                <i class="bi bi-bell fs-5"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $notif->title }}</h6>
                                <p class="mb-0 text-muted small">{{ $notif->message }}</p>
                                <small class="text-muted opacity-75">{{ $notif->created_at?->diffForHumans() }}</small>
                            </div>
                        </div>
                        @if(!$notif->is_read)
                            <button class="btn btn-sm btn-light text-primary mark-read-btn" data-id="{{ $notif->id }}">
                                Mark Read
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-bell-slash display-1 text-muted opacity-50"></i>
            <h5 class="mt-3 text-muted">You have no notifications.</h5>
        </div>
    @endif
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#readAllBtn').click(function() {
            $.ajax({
                url: '{{ route("notifications.read-all") }}',
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res) {
                    location.reload();
                }
            });
        });

        $('.mark-read-btn').click(function() {
            let id = $(this).data('id');
            $.ajax({
                url: '/notifications/' + id + '/read',
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res) {
                    location.reload();
                }
            });
        });
    });
</script>
@endsection
