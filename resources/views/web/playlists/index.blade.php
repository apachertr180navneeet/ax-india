@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="bi bi-collection-play-fill text-primary me-2"></i>My Playlists</h4>
            <p class="text-muted small mb-0">Organize and watch your favorite video collections</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#createPlaylistModal">
            <i class="bi bi-plus-lg me-1"></i> New Playlist
        </button>
    </div>

    @if(count($playlists) > 0)
        <div class="row g-4">
            @foreach($playlists as $playlist)
                <div class="col-xl-3 col-lg-4 col-md-6" id="playlist-card-{{ $playlist->id }}">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-3">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-3 p-3 me-3">
                                <i class="bi bi-music-note-list fs-3"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">
                                    <a href="{{ route('playlists.show', $playlist->id) }}" class="text-dark text-decoration-none">{{ $playlist->title }}</a>
                                </h6>
                                <small class="text-muted">{{ $playlist->videos_count ?? count($playlist->videos) }} videos</small>
                            </div>
                        </div>
                        <p class="text-muted small mb-3 text-truncate">{{ $playlist->description ?? 'No description' }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <span class="badge bg-light text-dark text-capitalize">{{ $playlist->visibility }}</span>
                            <button class="btn btn-outline-danger btn-sm rounded-circle delete-playlist-btn" data-id="{{ $playlist->id }}" title="Delete playlist">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-folder-plus display-1 text-muted opacity-50"></i>
            <h5 class="mt-3 text-muted">No playlists created yet.</h5>
        </div>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="createPlaylistModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Create New Playlist</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form id="createPlaylistForm">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" id="playlistTitle" class="form-control" placeholder="Playlist title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea id="playlistDescription" class="form-control" rows="3" placeholder="Optional description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Visibility</label>
                        <select id="playlistVisibility" class="form-select">
                            <option value="public">Public</option>
                            <option value="private">Private</option>
                            <option value="unlisted">Unlisted</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-semibold">Create Playlist</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('#createPlaylistForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("playlists.store") }}',
                method: 'POST',
                data: {
                    title: $('#playlistTitle').val(),
                    description: $('#playlistDescription').val(),
                    visibility: $('#playlistVisibility').val(),
                },
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res) {
                    location.reload();
                }
            });
        });

        $('.delete-playlist-btn').click(function() {
            let id = $(this).data('id');
            if(confirm('Delete this playlist?')) {
                $.ajax({
                    url: '/playlists/' + id,
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    success: function(res) {
                        $('#playlist-card-' + id).fadeOut(300, function() { $(this).remove(); });
                    }
                });
            }
        });
    });
</script>
@endsection
