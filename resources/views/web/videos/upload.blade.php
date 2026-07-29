@extends('web.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-primary text-white py-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-cloud-arrow-up me-2"></i>Upload New Video</h5>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Video File <span class="text-danger">*</span></label>
                            <input type="file" name="video_file" class="form-control form-control-lg" accept="video/*" required>
                            <small class="text-muted">Supported formats: MP4, MOV, AVI, MKV (Max: 200MB)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Enter video title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Tell viewers about your video">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Visibility</label>
                                <select name="visibility" class="form-select">
                                    <option value="public">Public</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Custom Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended aspect ratio: 16:9 (JPEG, PNG, WebP)</small>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" name="allow_downloads" value="1" class="form-check-input" id="allowDownloads" checked>
                            <label class="form-check-label fw-semibold" for="allowDownloads">Allow viewers to download this video</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('home') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 fw-semibold"><i class="bi bi-upload me-2"></i>Publish Video</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
