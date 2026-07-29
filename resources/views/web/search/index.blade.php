@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm rounded-4 p-3 mb-4">
        <form action="{{ route('search') }}" method="GET" class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="q" class="form-control border-start-0" placeholder="Search videos or creators..." value="{{ $query }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="sort" class="form-select">
                    <option value="latest" {{ $sortBy == 'latest' ? 'selected' : '' }}>Latest</option>
                    <option value="views" {{ $sortBy == 'views' ? 'selected' : '' }}>Most Viewed</option>
                    <option value="likes" {{ $sortBy == 'likes' ? 'selected' : '' }}>Most Liked</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100"><i class="bi bi-filter me-1"></i>Filter</button>
            </div>
        </form>
    </div>

    <h5 class="fw-bold mb-3">Search Results @if($query) for "{{ $query }}" @endif</h5>

    @if(count($videos) > 0)
        <div class="row g-4 mb-4">
            @foreach($videos as $video)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 p-3">
                        <div class="row align-items-center">
                            <div class="col-md-3 col-12 mb-2 mb-md-0">
                                <a href="{{ route('watch', $video->slug) }}">
                                    <img src="{{ asset($video->thumbnail ?? 'images/default-thumbnail.jpg') }}" class="img-fluid rounded-3" alt="" style="aspect-ratio: 16/9; object-fit: cover; width: 100%;">
                                </a>
                            </div>
                            <div class="col-md-9 col-12">
                                <h5 class="fw-bold mb-1">
                                    <a href="{{ route('watch', $video->slug) }}" class="text-dark text-decoration-none">{{ $video->title }}</a>
                                </h5>
                                <p class="text-muted small mb-2">{{ $video->user?->full_name }} · {{ number_format($video->views_count) }} views · {{ $video->created_at?->diffForHumans() }}</p>
                                <p class="text-muted small mb-0 text-truncate" style="max-width: 900px;">{{ $video->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            {{ $videos->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-search display-1 text-muted opacity-50"></i>
            <h5 class="mt-3 text-muted">No videos found matching your search.</h5>
        </div>
    @endif
</div>
@endsection
