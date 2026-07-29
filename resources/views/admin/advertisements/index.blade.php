@extends('admin.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h5 class="fw-bold mb-3">Create Advertisement</h5>
                <form action="{{ route('admin.advertisements.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-muted">Campaign Title</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Ad Placement Type</label>
                        <select name="type" class="form-select">
                            <option value="banner">Banner Ad</option>
                            <option value="pre_roll">Pre-Roll Video</option>
                            <option value="sidebar">Sidebar Ad</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-muted">Target URL</label>
                        <input type="url" name="target_url" class="form-control" placeholder="https://example.com">
                    </div>
                    <button type="submit" class="btn btn-primary-custom w-100 rounded-3 fw-bold">Add Campaign</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-3">
                <h5 class="fw-bold mb-3">Active Campaigns</h5>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Impressions</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ads as $ad)
                                <tr>
                                    <td class="fw-bold text-dark">{{ $ad->title }}</td>
                                    <td><span class="badge bg-info">{{ strtoupper($ad->type) }}</span></td>
                                    <td class="text-dark">{{ number_format($ad->impressions) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $ad->is_active ? 'success' : 'secondary' }}">
                                            {{ $ad->is_active ? 'Active' : 'Disabled' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.advertisements.toggle', $ad->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning rounded-circle me-1"><i class="bi bi-power"></i></button>
                                        </form>
                                        <form action="{{ route('admin.advertisements.destroy', $ad->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No ad campaigns found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
