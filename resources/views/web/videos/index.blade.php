@extends('layouts.app')
@section('title', 'AX India - Watch Videos')
@section('content')
    <div class="row g-3">
        @forelse ($videos as $video)
            <div class="col-lg-3 col-md-4 col-sm-6">
                @include('partials.video-card')
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <i class="fas fa-video fa-3x text-muted mb-3"></i>
                <p class="text-muted">No videos available yet.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-4 d-flex justify-content-center">
        {{ $videos->links() }}
    </div>
@endsection
