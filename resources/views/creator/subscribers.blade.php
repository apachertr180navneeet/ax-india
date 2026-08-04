@extends('web.layouts.app')

@section('content')
<div class="container py-4" id="creatorSubscribersPage">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
        <div>
            <h2 class="fw-bold mb-1 text-white">Subscriber Management</h2>
            <p class="mb-0" style="color: #aaaaaa;">View and manage people subscribed to your channel</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('creator.dashboard') }}" class="btn-custom btn-outline-custom"><i class="bi bi-speedometer2 me-1"></i> Dashboard</a>
            <a href="{{ route('creator.analytics') }}" class="btn-custom btn-outline-custom"><i class="bi bi-graph-up me-1"></i> Analytics</a>
            <button type="button" class="btn-custom btn-primary-custom" id="btnExportSubs"><i class="bi bi-download me-1"></i> Export (UI)</button>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="small fw-semibold" style="color: #aaaaaa;">Total subscribers</div>
                <h3 class="fw-bold text-white mb-0 mt-1">{{ number_format($totalSubscribers ?? ($subscribers->total() ?? 0)) }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="small fw-semibold" style="color: #aaaaaa;">New this week</div>
                <h3 class="fw-bold text-white mb-0 mt-1">+{{ $newThisWeek ?? 24 }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="small fw-semibold" style="color: #aaaaaa;">Notifications on</div>
                <h3 class="fw-bold text-white mb-0 mt-1">{{ $notifOn ?? '68%' }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 rounded-4 p-3 h-100" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
                <div class="small fw-semibold" style="color: #aaaaaa;">Unsubscribed (30d)</div>
                <h3 class="fw-bold text-white mb-0 mt-1">{{ $unsubscribed ?? 9 }}</h3>
            </div>
        </div>
    </div>

    <div class="card border-0 rounded-4 p-3" style="background-color: var(--yt-dark-card); border: 1px solid var(--yt-border) !important;">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-3 px-1">
            <div class="sub-filters">
                <button type="button" class="sub-filter active" data-filter="all">All</button>
                <button type="button" class="sub-filter" data-filter="active">Active</button>
                <button type="button" class="sub-filter" data-filter="bell">Bell on</button>
            </div>
            <div class="sub-search">
                <i class="bi bi-search"></i>
                <input type="search" id="subSearch" placeholder="Search subscribers...">
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle mb-0" style="background-color: var(--yt-dark-card); color: #f1f1f1;">
                <thead>
                    <tr style="border-bottom: 1px solid var(--yt-border); font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.04em;">
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Subscriber</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Joined</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Notifications</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;">Status</th>
                        <th style="background: transparent; color: #aaaaaa; padding: 0.85rem 1rem;" class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody id="subTableBody">
                    @forelse($subscribers as $sub)
                        @php
                            $user = $sub->subscriber ?? null;
                            $name = $user->full_name ?? $user->name ?? 'Subscriber';
                            $email = $user->email ?? '—';
                            $bell = (bool) ($sub->notifications_enabled ?? true);
                        @endphp
                        <tr class="sub-row" data-filter="{{ $bell ? 'bell active' : 'active' }}" data-search="{{ strtolower($name . ' ' . $email) }}" style="border-bottom: 1px solid var(--yt-border);">
                            <td style="background: transparent; padding: 0.85rem 1rem;">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:36px;height:36px;background:#333;">{{ strtoupper(substr($name, 0, 1)) }}</div>
                                    <div>
                                        <div class="fw-semibold text-white">{{ $name }}</div>
                                        <div class="small" style="color:#aaaaaa;">{{ $email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="background: transparent; color:#aaaaaa; padding: 0.85rem 1rem;">{{ optional($sub->created_at)->diffForHumans() ?? 'Recently' }}</td>
                            <td style="background: transparent; padding: 0.85rem 1rem;">
                                <span class="badge rounded-pill {{ $bell ? 'bg-success' : 'bg-secondary' }}">{{ $bell ? 'On' : 'Off' }}</span>
                            </td>
                            <td style="background: transparent; padding: 0.85rem 1rem;"><span class="badge bg-primary rounded-pill">Active</span></td>
                            <td style="background: transparent; padding: 0.85rem 1rem;" class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill btn-sub-msg">Message</button>
                            </td>
                        </tr>
                    @empty
                        @foreach([
                            ['AX Fan', 'fan1@axindia.com', '2 days ago', true],
                            ['Riya Kapoor', 'riya@example.com', '5 days ago', true],
                            ['Arjun Mehta', 'arjun@example.com', '1 week ago', false],
                            ['Neha Sharma', 'neha@example.com', '2 weeks ago', true],
                        ] as $demo)
                            <tr class="sub-row" data-filter="{{ $demo[3] ? 'bell active' : 'active' }}" data-search="{{ strtolower($demo[0].' '.$demo[1]) }}" style="border-bottom: 1px solid var(--yt-border);">
                                <td style="background: transparent; padding: 0.85rem 1rem;">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:36px;height:36px;background:#333;">{{ strtoupper(substr($demo[0],0,1)) }}</div>
                                        <div>
                                            <div class="fw-semibold text-white">{{ $demo[0] }}</div>
                                            <div class="small" style="color:#aaaaaa;">{{ $demo[1] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="background: transparent; color:#aaaaaa; padding: 0.85rem 1rem;">{{ $demo[2] }}</td>
                                <td style="background: transparent; padding: 0.85rem 1rem;"><span class="badge rounded-pill {{ $demo[3] ? 'bg-success' : 'bg-secondary' }}">{{ $demo[3] ? 'On' : 'Off' }}</span></td>
                                <td style="background: transparent; padding: 0.85rem 1rem;"><span class="badge bg-primary rounded-pill">Active</span></td>
                                <td style="background: transparent; padding: 0.85rem 1rem;" class="text-end"><button type="button" class="btn btn-sm btn-outline-secondary rounded-pill btn-sub-msg">Message</button></td>
                            </tr>
                        @endforeach
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($subscribers, 'links'))
            <div class="mt-3">{{ $subscribers->links() }}</div>
        @endif
    </div>
</div>

<div class="position-fixed bottom-0 start-50 translate-middle-x p-3" style="z-index:1100;">
    <div id="subToast" class="toast align-items-center text-bg-dark border-0"><div class="d-flex"><div class="toast-body" id="subToastBody">Done</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>
</div>
@endsection

@section('style')
<style>
.sub-filters{display:inline-flex;gap:2px;padding:4px;background:var(--lavender-light);border:1px solid var(--yt-border);border-radius:999px}
.sub-filter{border:none;background:transparent;color:var(--text-muted);font-size:.82rem;font-weight:600;padding:.4rem .85rem;border-radius:999px;cursor:pointer}
.sub-filter.active{background:var(--accent-red);color:#fff}
.sub-search{position:relative;max-width:240px;width:100%}
.sub-search i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8}
.sub-search input{width:100%;height:36px;border:1px solid var(--yt-border);border-radius:999px;padding:.4rem .9rem .4rem 2.2rem;outline:none}
.sub-row.is-hidden{display:none!important}
</style>
@endsection

@section('script')
<script>
(function(){
    const page=document.getElementById('creatorSubscribersPage'); if(!page) return;
    let filter='all';
    const toastEl=document.getElementById('subToast');
    const toast=toastEl?new bootstrap.Toast(toastEl,{delay:2000}):null;
    function show(m){ if(!toast) return; document.getElementById('subToastBody').textContent=m; toast.show(); }
    function apply(){
        const q=(document.getElementById('subSearch').value||'').toLowerCase();
        page.querySelectorAll('.sub-row').forEach(function(row){
            const f=row.dataset.filter||'';
            let ok=filter==='all'||f.includes(filter);
            if(q && !(row.dataset.search||'').includes(q)) ok=false;
            row.classList.toggle('is-hidden', !ok);
        });
    }
    page.querySelectorAll('.sub-filter').forEach(function(btn){
        btn.addEventListener('click', function(){
            page.querySelectorAll('.sub-filter').forEach(b=>b.classList.remove('active'));
            btn.classList.add('active'); filter=btn.dataset.filter; apply();
        });
    });
    document.getElementById('subSearch').addEventListener('input', apply);
    document.getElementById('btnExportSubs').addEventListener('click', ()=>show('Export started (UI demo)'));
    page.addEventListener('click', function(e){ if(e.target.closest('.btn-sub-msg')) show('Message composer (UI demo)'); });
})();
</script>
@endsection
