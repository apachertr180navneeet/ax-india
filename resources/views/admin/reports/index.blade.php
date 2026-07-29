@extends('admin.layouts.app')
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <h4 class="py-2 mb-2 text-white fw-bold">
        <span>Reports Management</span>
    </h4>
    <div class="row">
        <div class="col-xl-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Reporter</th>
                                    <th>Video</th>
                                    <th>Reason</th>
                                    <th>Description</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reports as $report)
                                <tr>
                                    <td>{{ $report->user?->full_name ?? 'Unknown' }}</td>
                                    <td>
                                        <a href="{{ route('admin.moderation.index') }}?id={{ $report->video_id }}">
                                            {{ $report->video?->title ?? 'Deleted Video' }}
                                        </a>
                                    </td>
                                    <td><span class="badge bg-warning">{{ $report->reason?->value ?? $report->reason }}</span></td>
                                    <td>{{ Str::limit($report->description, 50) }}</td>
                                    <td>{{ $report->created_at->diffForHumans() }}</td>
                                    <td>
                                        <form action="{{ route('admin.reports.resolve', $report->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill" onclick="return confirm('Resolve this report?')">
                                                <i class="bi bi-check-lg"></i> Resolve
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No reports found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $reports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
