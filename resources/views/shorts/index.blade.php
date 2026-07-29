@extends('layouts.app')

@section('content')
<div class="container-fluid py-4 bg-black text-white min-vh-100">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <h3 class="fw-bold mb-4 text-center"><i class="bi bi-lightning-charge-fill text-danger me-2"></i>Shorts</h3>
            
            @forelse($shorts as $short)
                <div class="card border-0 rounded-4 bg-dark text-white mb-4 shadow-lg overflow-hidden position-relative" style="height: 700px;">
                    <video src="{{ asset('storage/' . $short->file_path) }}" class="w-100 h-100 object-fit-cover" controls autoplay loop muted></video>
                    <div class="position-absolute bottom-0 start-0 p-4 w-100 bg-gradient bg-dark bg-opacity-75">
                        <h5 class="fw-bold mb-1">{{ $short->title }}</h5>
                        <p class="small text-secondary mb-2">@ {{ $short->user->name ?? 'Creator' }}</p>
                        <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-outline-light btn-sm rounded-circle"><i class="bi bi-heart"></i></button>
                            <span class="small">{{ $short->likes_count }}</span>
                            <button class="btn btn-outline-light btn-sm rounded-circle"><i class="bi bi-chat-left-text"></i></button>
                            <span class="small">{{ $short->comments_count }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-secondary">
                    <i class="bi bi-camera-reels fs-1 d-block mb-3"></i>
                    No shorts available right now.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
