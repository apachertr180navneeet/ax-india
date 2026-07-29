@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-white"><i class="bi bi-shield-lock me-2 text-primary"></i>Device Management & Active Sessions</h2>

    <div class="card bg-dark text-white border-secondary mb-4">
        <div class="card-header border-secondary d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Logged In Devices</h5>
            <span class="badge bg-success"><i class="bi bi-shield-check me-1"></i>2FA Active</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-dark table-hover mb-0 align-middle">
                    <thead>
                        <tr>
                            <th>Device / Platform</th>
                            <th>IP Address</th>
                            <th>Last Active</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-laptop fs-3 text-info me-3"></i>
                                        <div>
                                            <div class="fw-bold">{{ $device->device_name ?: 'Web Session' }}</div>
                                            <small class="text-muted">{{ $device->browser }} on {{ $device->platform }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><code>{{ $device->ip_address ?: '127.0.0.1' }}</code></td>
                                <td>{{ $device->last_active_at ? $device->last_active_at->diffForHumans() : 'Just now' }}</td>
                                <td>
                                    @if($device->is_current_device)
                                        <span class="badge bg-primary">Current Device</span>
                                    @else
                                        <span class="badge bg-secondary">Active Session</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if(!$device->is_current_device)
                                        <form action="{{ route('settings.devices.revoke', $device->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Revoke</button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-secondary" disabled>Current</button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">No active devices recorded.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
