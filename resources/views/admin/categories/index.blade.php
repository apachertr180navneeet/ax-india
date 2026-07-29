@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-4">
                <h5 class="fw-bold mb-3">Add New Category</h5>
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label text-secondary">Category Name</label>
                        <input type="text" name="name" class="form-control bg-secondary bg-opacity-10 border-0 text-white" placeholder="Gaming, Music, Tech..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-secondary">Icon Class (Bootstrap Icons)</label>
                        <input type="text" name="icon" class="form-control bg-secondary bg-opacity-10 border-0 text-white" placeholder="bi bi-controller">
                    </div>
                    <button type="submit" class="btn btn-danger w-100 rounded-3 fw-bold">Create Category</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 bg-dark text-white p-3">
                <h5 class="fw-bold mb-3">Categories</h5>
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Icon</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Videos Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                                <tr>
                                    <td><i class="{{ $category->icon ?? 'bi bi-folder' }} fs-5"></i></td>
                                    <td class="fw-bold">{{ $category->name }}</td>
                                    <td class="text-secondary">{{ $category->slug }}</td>
                                    <td>{{ $category->videos_count }}</td>
                                    <td>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-secondary">No categories created yet.</td>
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
