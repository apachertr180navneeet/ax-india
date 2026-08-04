@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" id="adminSpamPage">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-white mb-1"><i class="bx bx-bot me-1"></i> AI Spam Detection</h4>
            <p class="text-muted small mb-0">Review flagged comments, accounts, and uploads (UI only)</p>
        </div>
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="spamAiToggle" checked>
            <label class="form-check-label text-white" for="spamAiToggle">AI scanning On</label>
        </div>
    </div>

    <div class="row mb-4">
        @foreach([['Flagged today','38','danger'],['Auto-removed','12','warning'],['False positives','3','info'],['Risk score','Medium','primary']] as $s)
            <div class="col-6 col-lg-3 mb-3">
                <div class="card h-100"><div class="card-body">
                    <div class="text-muted text-uppercase small fw-bold">{{ $s[0] }}</div>
                    <h3 class="fw-bold text-white mt-2 mb-0">{{ $s[1] }}</h3>
                </div></div>
            </div>
        @endforeach
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between gap-2">
            <div class="admin-notif-filters" role="tablist">
                <button type="button" class="admin-notif-filter active" data-spam="all">All</button>
                <button type="button" class="admin-notif-filter" data-spam="comment">Comments</button>
                <button type="button" class="admin-notif-filter" data-spam="account">Accounts</button>
                <button type="button" class="admin-notif-filter" data-spam="video">Videos</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" id="btnRefreshSpam">Refresh</button>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Item</th><th>Type</th><th>Score</th><th>Reason</th><th>Detected</th><th>Action</th></tr></thead>
                <tbody id="spamTable">
                    @foreach([
                        ['Buy followers cheap!!!', 'comment', '92', 'Promotional spam', '8 min ago'],
                        ['user_spam_bot_441', 'account', '88', 'Bot-like activity', '22 min ago'],
                        ['FREE CRYPTO GIVEAWAY.mp4', 'video', '95', 'Scam keywords', '1 hr ago'],
                        ['Check my link in bio 🔥🔥', 'comment', '71', 'External link spam', '2 hr ago'],
                    ] as $row)
                        <tr class="spam-row" data-spam="{{ $row[1] }}">
                            <td class="text-white fw-semibold">{{ $row[0] }}</td>
                            <td><span class="badge bg-label-secondary text-uppercase">{{ $row[1] }}</span></td>
                            <td><span class="badge bg-danger">{{ $row[2] }}%</span></td>
                            <td class="text-muted">{{ $row[3] }}</td>
                            <td class="text-muted">{{ $row[4] }}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-success rounded-pill btn-spam-keep">Keep</button>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill btn-spam-remove">Remove</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
.admin-notif-filters{display:inline-flex;gap:2px;padding:4px;background:rgba(105,108,255,.08);border:1px solid rgba(105,108,255,.22);border-radius:999px}
.admin-notif-filter{border:none;background:transparent;color:#8592a3;font-size:.8125rem;font-weight:600;padding:.4rem .9rem;border-radius:999px;cursor:pointer}
.admin-notif-filter.active{color:#fff;background:#696cff}
.spam-row.is-hidden{display:none!important}
</style>
@endsection

@section('script')
<script>
(function(){
    const page=document.getElementById('adminSpamPage'); if(!page) return;
    let filter='all';
    page.querySelectorAll('[data-spam]').forEach(function(btn){
        if(!btn.classList.contains('admin-notif-filter')) return;
        btn.addEventListener('click', function(){
            page.querySelectorAll('.admin-notif-filter').forEach(b=>b.classList.remove('active'));
            btn.classList.add('active'); filter=btn.dataset.spam;
            page.querySelectorAll('.spam-row').forEach(row=>{
                row.classList.toggle('is-hidden', filter!=='all' && row.dataset.spam!==filter);
            });
        });
    });
    page.addEventListener('click', function(e){
        if(e.target.closest('.btn-spam-keep')||e.target.closest('.btn-spam-remove')){
            e.target.closest('tr')?.remove();
            alert((e.target.closest('.btn-spam-keep')?'Kept':'Removed')+' (UI demo)');
        }
    });
    document.getElementById('btnRefreshSpam').addEventListener('click', ()=>alert('Spam queue refreshed (UI demo)'));
    document.getElementById('spamAiToggle').addEventListener('change', function(){
        alert(this.checked ? 'AI scanning enabled (UI)' : 'AI scanning paused (UI)');
    });
})();
</script>
@endsection
