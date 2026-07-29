@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Live Streaming Center</h2>
            <p class="text-secondary">Set up your RTMP stream key and live broadcast settings</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-3 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-7">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-broadcast text-danger me-2"></i>Create New Live Broadcast</h5>
                <form action="{{ route('creator.live.key') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary">Stream Title</label>
                        <input type="text" name="title" class="form-control bg-secondary bg-opacity-10 border-0 text-white" placeholder="My Epic Live Stream" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Description</label>
                        <textarea name="description" class="form-control bg-secondary bg-opacity-10 border-0 text-white" rows="4" placeholder="Tell viewers what your stream is about..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger btn-lg w-100 rounded-3 fw-bold">
                        <i class="bi bi-key-fill me-2"></i>Generate Stream Key
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-info-circle text-primary me-2"></i>Current Stream Status</h5>
                @if($liveStream)
                    <div class="mb-3">
                        <span class="badge bg-{{ $liveStream->live_status === 'live' ? 'danger' : 'secondary' }} fs-6">
                            STATUS: {{ strtoupper($liveStream->live_status) }}
                        </span>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Server URL (RTMP)</label>
                        <input type="text" class="form-control bg-secondary bg-opacity-10 border-0 text-white" value="rtmp://live.axvideo.com/live" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Stream Key</label>
                        <input type="text" class="form-control bg-secondary bg-opacity-10 border-0 text-white" value="{{ $liveStream->stream_key }}" readonly>
                    </div>
                @else
                    <div class="text-center py-4 text-secondary">
                        <i class="bi bi-camera-video-off fs-1 d-block mb-2"></i>
                        No active stream configured. Generate a stream key to start live broadcasting.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
