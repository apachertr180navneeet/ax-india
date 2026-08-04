@extends('admin.layouts.app')

@section('content')
<div class="container-fluid flex-grow-1 container-p-y" id="adminNotificationsPage">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold text-white mb-1">
                <i class="bx bx-bell me-1"></i> Notifications
            </h4>
            <p class="text-muted mb-0 small">Manage admin alerts and platform broadcasts</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill px-3" id="btnMarkAllRead">
                <i class="bx bx-check-double me-1"></i> Mark all read
            </button>
            <button type="button" class="btn btn-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#composeNotificationModal">
                <i class="bx bx-plus me-1"></i> Compose
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-muted text-uppercase small fw-bold">Unread</span>
                        <span class="badge bg-label-danger rounded-pill" id="statUnread">{{ $stats['unread'] }}</span>
                    </div>
                    <h3 class="fw-bold text-white mb-0 mt-2">{{ $stats['unread'] }}</h3>
                    <small class="text-muted">Needs attention</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-muted text-uppercase small fw-bold">Today</span>
                        <i class="bx bx-calendar text-primary fs-5"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-0 mt-2">{{ $stats['today'] }}</h3>
                    <small class="text-muted">Sent / received</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-muted text-uppercase small fw-bold">Scheduled</span>
                        <i class="bx bx-time-five text-warning fs-5"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-0 mt-2">{{ $stats['scheduled'] }}</h3>
                    <small class="text-muted">Upcoming broadcasts</small>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="text-muted text-uppercase small fw-bold">Total</span>
                        <i class="bx bx-list-ul text-info fs-5"></i>
                    </div>
                    <h3 class="fw-bold text-white mb-0 mt-2">{{ $stats['total'] }}</h3>
                    <small class="text-muted">All notifications</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-bottom d-flex flex-wrap align-items-center justify-content-between gap-2 py-3">
            <div class="admin-notif-filters" role="tablist" aria-label="Filter notifications">
                <button type="button" class="admin-notif-filter active" data-filter="all" role="tab" aria-selected="true">All</button>
                <button type="button" class="admin-notif-filter" data-filter="unread" role="tab" aria-selected="false">Unread</button>
                <button type="button" class="admin-notif-filter" data-filter="system" role="tab" aria-selected="false">System</button>
                <button type="button" class="admin-notif-filter" data-filter="creator" role="tab" aria-selected="false">Creators</button>
                <button type="button" class="admin-notif-filter" data-filter="user" role="tab" aria-selected="false">Users</button>
                <button type="button" class="admin-notif-filter" data-filter="broadcast" role="tab" aria-selected="false">Broadcasts</button>
            </div>
            <div class="admin-notif-search">
                <i class="bx bx-search"></i>
                <input type="search" id="notifSearch" placeholder="Search notifications..." aria-label="Search notifications">
            </div>
        </div>

        <div class="card-body p-0">
            <div class="list-group list-group-flush" id="adminNotifList">
                @foreach($notifications as $notif)
                    <div class="list-group-item admin-notif-item {{ $notif['is_read'] ? 'is-read' : 'is-unread' }}"
                         data-id="{{ $notif['id'] }}"
                         data-type="{{ $notif['type'] }}"
                         data-read="{{ $notif['is_read'] ? '1' : '0' }}"
                         data-search="{{ strtolower($notif['title'] . ' ' . $notif['message']) }}">
                        <div class="d-flex align-items-start gap-3 p-1">
                            <div class="admin-notif-icon bg-label-{{ $notif['color'] }}">
                                <i class="bx {{ $notif['icon'] }}"></i>
                            </div>
                            <div class="flex-grow-1 min-width-0">
                                <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                                    <h6 class="mb-0 fw-bold text-white admin-notif-title">{{ $notif['title'] }}</h6>
                                    @unless($notif['is_read'])
                                        <span class="badge bg-danger rounded-pill admin-unread-dot">New</span>
                                    @endunless
                                    <span class="badge bg-label-secondary text-uppercase" style="font-size: 0.65rem;">{{ $notif['type'] }}</span>
                                </div>
                                <p class="mb-1 text-muted small">{{ $notif['message'] }}</p>
                                <div class="d-flex flex-wrap gap-3 small text-muted">
                                    <span><i class="bx bx-group me-1"></i>{{ $notif['audience'] }}</span>
                                    <span><i class="bx bx-time-five me-1"></i>{{ $notif['time'] }}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row gap-1 flex-shrink-0">
                                @unless($notif['is_read'])
                                    <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 btn-mark-read" title="Mark as read">
                                        <i class="bx bx-check"></i>
                                    </button>
                                @endunless
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 btn-delete-notif" title="Delete">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center py-5 d-none" id="adminNotifEmpty">
                <i class="bx bx-bell-off display-4 text-muted"></i>
                <p class="text-muted mt-2 mb-0">No notifications match this filter.</p>
            </div>
        </div>
    </div>
</div>

{{-- Compose Modal --}}
<div class="modal fade" id="composeNotificationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Compose Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control" id="composeTitle" placeholder="Notification title" maxlength="120">
                </div>
                <div class="mb-3">
                    <label class="form-label">Message</label>
                    <textarea class="form-control" id="composeMessage" rows="3" placeholder="Write your message..." maxlength="500"></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Audience</label>
                        <select class="form-select" id="composeAudience">
                            <option value="All Users">All Users</option>
                            <option value="Creators">Creators only</option>
                            <option value="Admins">Admins only</option>
                            <option value="Moderators">Moderators</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" id="composeType">
                            <option value="broadcast">Broadcast</option>
                            <option value="system">System</option>
                            <option value="creator">Creator</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="composeSchedule">
                    <label class="form-check-label" for="composeSchedule">Schedule for later (UI demo)</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btnSendNotification">
                    <i class="bx bx-send me-1"></i> Send now
                </button>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 start-50 translate-middle-x p-3" style="z-index: 1100;">
    <div id="adminNotifToast" class="toast align-items-center text-bg-dark border-0" role="status" aria-live="polite">
        <div class="d-flex">
            <div class="toast-body" id="adminNotifToastBody">Done</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>
@endsection

@section('style')
<style>
    .admin-notif-item {
        border-left: 3px solid transparent;
        transition: background 0.2s ease, border-color 0.2s ease;
    }
    .admin-notif-item.is-unread {
        border-left-color: #696cff;
        background: rgba(105, 108, 255, 0.06);
    }
    .admin-notif-item:hover {
        background: rgba(255, 255, 255, 0.03);
    }
    .admin-notif-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }
    .admin-notif-filters {
        display: inline-flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 2px;
        padding: 4px;
        background: rgba(105, 108, 255, 0.08);
        border: 1px solid rgba(105, 108, 255, 0.22);
        border-radius: 999px;
    }
    .admin-notif-filter {
        border: none;
        background: transparent;
        color: #8592a3;
        font-size: 0.8125rem;
        font-weight: 600;
        line-height: 1.2;
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
    }
    .admin-notif-filter:hover {
        color: #696cff;
        background: rgba(105, 108, 255, 0.1);
    }
    .admin-notif-filter.active {
        color: #fff;
        background: #696cff;
        box-shadow: 0 2px 8px rgba(105, 108, 255, 0.35);
    }
    .admin-notif-item.is-hidden {
        display: none !important;
    }
    .admin-notif-search {
        position: relative;
        width: 100%;
        max-width: 260px;
    }
    .admin-notif-search i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #8592a3;
        font-size: 1rem;
        pointer-events: none;
    }
    .admin-notif-search input {
        width: 100%;
        height: 36px;
        border: 1px solid rgba(105, 108, 255, 0.25);
        border-radius: 999px;
        background: #fff;
        padding: 0.4rem 0.9rem 0.4rem 2.2rem;
        font-size: 0.85rem;
        color: #566a7f;
        outline: none;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }
    .admin-notif-search input::placeholder {
        color: #a1acb8;
    }
    .admin-notif-search input:focus {
        border-color: #696cff;
        box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.15);
    }
    @media (max-width: 576px) {
        .admin-notif-filters {
            width: 100%;
            border-radius: 14px;
        }
        .admin-notif-filter {
            flex: 1 1 auto;
            text-align: center;
            padding: 0.45rem 0.55rem;
        }
        .admin-notif-search {
            max-width: 100%;
        }
    }
</style>
@endsection

@section('script')
<script>
(function () {
    const page = document.getElementById('adminNotificationsPage');
    if (!page) return;

    const list = document.getElementById('adminNotifList');
    const empty = document.getElementById('adminNotifEmpty');
    const searchInput = document.getElementById('notifSearch');
    const unreadStat = document.getElementById('statUnread');
    let currentFilter = 'all';

    const toastEl = document.getElementById('adminNotifToast');
    const toastBody = document.getElementById('adminNotifToastBody');
    const toast = toastEl ? new bootstrap.Toast(toastEl, { delay: 2200 }) : null;

    function showToast(msg) {
        if (!toast) return;
        toastBody.textContent = msg;
        toast.show();
    }

    function updateUnreadCount() {
        const count = list.querySelectorAll('.admin-notif-item.is-unread:not(.is-hidden)').length;
        const allUnread = list.querySelectorAll('.admin-notif-item.is-unread').length;
        unreadStat.textContent = String(allUnread);
        unreadStat.closest('.card-body').querySelector('h3').textContent = String(allUnread);
    }

    function applyFilters() {
        const q = (searchInput.value || '').trim().toLowerCase();
        let visible = 0;
        list.querySelectorAll('.admin-notif-item').forEach(function (item) {
            const type = item.dataset.type;
            const read = item.dataset.read === '1';
            const hay = item.dataset.search || '';
            let match = true;
            if (currentFilter === 'unread') match = !read;
            else if (currentFilter !== 'all') match = type === currentFilter;
            if (q && !hay.includes(q)) match = false;
            item.classList.toggle('is-hidden', !match);
            if (match) visible += 1;
        });
        empty.classList.toggle('d-none', visible > 0);
    }

    page.querySelectorAll('.admin-notif-filters [data-filter]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            page.querySelectorAll('.admin-notif-filters [data-filter]').forEach(function (b) {
                b.classList.remove('active');
                b.setAttribute('aria-selected', 'false');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-selected', 'true');
            currentFilter = btn.dataset.filter;
            applyFilters();
        });
    });

    searchInput.addEventListener('input', applyFilters);

    list.addEventListener('click', function (e) {
        const item = e.target.closest('.admin-notif-item');
        if (!item) return;

        if (e.target.closest('.btn-mark-read')) {
            item.classList.remove('is-unread');
            item.classList.add('is-read');
            item.dataset.read = '1';
            const badge = item.querySelector('.admin-unread-dot');
            if (badge) badge.remove();
            e.target.closest('.btn-mark-read').remove();
            updateUnreadCount();
            applyFilters();
            showToast('Marked as read');
            return;
        }

        if (e.target.closest('.btn-delete-notif')) {
            item.remove();
            updateUnreadCount();
            applyFilters();
            showToast('Notification removed');
        }
    });

    document.getElementById('btnMarkAllRead').addEventListener('click', function () {
        list.querySelectorAll('.admin-notif-item.is-unread').forEach(function (item) {
            item.classList.remove('is-unread');
            item.classList.add('is-read');
            item.dataset.read = '1';
            item.querySelector('.admin-unread-dot')?.remove();
            item.querySelector('.btn-mark-read')?.remove();
        });
        updateUnreadCount();
        applyFilters();
        showToast('All notifications marked as read');
    });

    document.getElementById('btnSendNotification').addEventListener('click', function () {
        const title = document.getElementById('composeTitle').value.trim();
        const message = document.getElementById('composeMessage').value.trim();
        const audience = document.getElementById('composeAudience').value;
        const type = document.getElementById('composeType').value;
        const scheduled = document.getElementById('composeSchedule').checked;

        if (!title || !message) {
            showToast('Title and message are required');
            return;
        }

        const icons = { broadcast: 'bx-broadcast', system: 'bx-error-circle', creator: 'bx-badge-check', user: 'bx-user' };
        const colors = { broadcast: 'info', system: 'danger', creator: 'success', user: 'primary' };
        const id = Date.now();

        const html =
            '<div class="list-group-item admin-notif-item is-unread" data-id="' + id + '" data-type="' + type + '" data-read="0" data-search="' +
            (title + ' ' + message).toLowerCase().replace(/"/g, '') + '">' +
            '<div class="d-flex align-items-start gap-3 p-1">' +
            '<div class="admin-notif-icon bg-label-' + (colors[type] || 'secondary') + '"><i class="bx ' + (icons[type] || 'bx-bell') + '"></i></div>' +
            '<div class="flex-grow-1 min-width-0">' +
            '<div class="d-flex flex-wrap align-items-center gap-2 mb-1">' +
            '<h6 class="mb-0 fw-bold text-white admin-notif-title"></h6>' +
            '<span class="badge bg-danger rounded-pill admin-unread-dot">New</span>' +
            '<span class="badge bg-label-secondary text-uppercase" style="font-size: 0.65rem;">' + type + '</span></div>' +
            '<p class="mb-1 text-muted small"></p>' +
            '<div class="d-flex flex-wrap gap-3 small text-muted">' +
            '<span><i class="bx bx-group me-1"></i></span>' +
            '<span><i class="bx bx-time-five me-1"></i>Just now</span></div></div>' +
            '<div class="d-flex flex-column flex-sm-row gap-1 flex-shrink-0">' +
            '<button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-2 btn-mark-read" title="Mark as read"><i class="bx bx-check"></i></button>' +
            '<button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 btn-delete-notif" title="Delete"><i class="bx bx-trash"></i></button>' +
            '</div></div></div>';

        list.insertAdjacentHTML('afterbegin', html);
        const item = list.firstElementChild;
        item.querySelector('.admin-notif-title').textContent = title;
        item.querySelector('p.text-muted').textContent = message;
        item.querySelector('.bx-group').parentElement.appendChild(document.createTextNode(audience));

        document.getElementById('composeTitle').value = '';
        document.getElementById('composeMessage').value = '';
        document.getElementById('composeSchedule').checked = false;
        bootstrap.Modal.getInstance(document.getElementById('composeNotificationModal'))?.hide();
        updateUnreadCount();
        applyFilters();
        showToast(scheduled ? 'Notification scheduled (UI demo)' : 'Notification sent (UI demo)');
    });
})();
</script>
@endsection
