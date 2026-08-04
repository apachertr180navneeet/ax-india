@extends('web.layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-transparent border-bottom p-4">
                    <h4 class="mb-0 fw-bold text-dark serif-font"><i class="bi bi-cloud-arrow-up text-primary me-2"></i>Upload New Video</h4>
                    <p class="text-muted small mb-0 mt-1">Publish standard videos or short clips to your channel</p>
                </div>
                <div class="card-body p-4">
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('videos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Video File <span class="text-danger">*</span></label>
                            <input type="file" name="video_file" class="form-control form-control-lg" accept="video/*" required>
                            <small class="text-muted">Supported formats: MP4, MOV, AVI, MKV (Max: 200MB)</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" placeholder="Enter video title" value="{{ old('title') }}" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Description</label>
                            <textarea name="description" class="form-control" rows="4" placeholder="Tell viewers about your video">{{ old('description') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold text-dark">Category <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold text-dark">Visibility</label>
                                <select name="visibility" class="form-select">
                                    <option value="public">Public</option>
                                    <option value="unlisted">Unlisted</option>
                                    <option value="private">Private</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Tags</label>
                            <input type="text" name="tags" id="tagInput" class="form-control" placeholder="Type a tag and press Enter" autocomplete="off">
                            <div class="d-flex flex-wrap gap-2 mt-2" id="tagChips"></div>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @foreach(['trending','tutorial','music','review','shorts','viral'] as $suggest)
                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill tag-suggest" data-tag="{{ $suggest }}">#{{ $suggest }}</button>
                                @endforeach
                            </div>
                            <small class="text-muted">UI only — tags are for display on upload form</small>
                            <input type="hidden" name="tags_json" id="tagsJson" value="[]">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-dark">Custom Thumbnail</label>
                            <input type="file" name="thumbnail" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended aspect ratio: 16:9 (JPEG, PNG, WebP)</small>
                        </div>

                        <div class="form-check mb-4">
                            <input type="checkbox" name="allow_downloads" value="1" class="form-check-input" id="allowDownloads" checked>
                            <label class="form-check-label fw-semibold text-dark" for="allowDownloads">Allow viewers to download this video</label>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-2">
                            <a href="{{ route('home') }}" class="btn-custom btn-outline-custom">Cancel</a>
                            <button type="submit" class="btn-custom btn-primary-custom px-4"><i class="bi bi-upload me-2"></i>Publish Video</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
(function () {
    const input = document.getElementById('tagInput');
    const chips = document.getElementById('tagChips');
    const hidden = document.getElementById('tagsJson');
    if (!input || !chips) return;
    const tags = [];

    function render() {
        chips.innerHTML = tags.map(function (t, i) {
            return '<span class="badge rounded-pill text-bg-primary d-inline-flex align-items-center gap-1 px-3 py-2">#' + t +
                ' <button type="button" class="btn-close btn-close-white" style="font-size:.55rem" data-i="' + i + '" aria-label="Remove"></button></span>';
        }).join('');
        hidden.value = JSON.stringify(tags);
    }

    function addTag(raw) {
        const t = String(raw || '').trim().replace(/^#/, '').toLowerCase();
        if (!t || tags.includes(t) || tags.length >= 12) return;
        tags.push(t);
        render();
    }

    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag(input.value);
            input.value = '';
        }
    });

    chips.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-i]');
        if (!btn) return;
        tags.splice(parseInt(btn.dataset.i, 10), 1);
        render();
    });

    document.querySelectorAll('.tag-suggest').forEach(function (btn) {
        btn.addEventListener('click', function () { addTag(btn.dataset.tag); });
    });
})();
</script>
@endsection
