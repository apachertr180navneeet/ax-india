<header class="site-header">
    <a class="brand-logo" href="{{ url('/') }}">
        <div class="logo-icon">
            <i class="bi bi-play-btn-fill"></i>
        </div>
        <span>AX-India</span>
    </a>
    
    <div class="search-bar-container">
        <form action="{{ route('search') }}" method="GET" class="w-100 m-0">
            <i class="bi bi-search search-icon"></i>
            <input type="text" name="q" class="search-input" placeholder="Search videos, creators, or topics..." value="{{ request('q') }}">
        </form>
    </div>

    <div class="nav-actions flex-shrink-0 d-flex align-items-center gap-2">
        @auth
            <a href="{{ route('videos.upload') }}" class="btn-custom btn-primary-custom d-flex align-items-center text-decoration-none">
                <i class="bi bi-cloud-upload-fill me-1"></i> Upload
            </a>

            <div class="dropdown ms-2">
                <button class="user-avatar-btn dropdown-toggle d-flex align-items-center gap-2 border-0 bg-transparent p-1 rounded-pill" type="button" id="userMenuDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->first_name }}" class="rounded-circle" width="36" height="36" style="object-fit: cover;">
                    @else
                        <div class="avatar-placeholder rounded-circle text-white fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background: linear-gradient(135deg, #d5bdaf, #e3d5ca); color: #333 !important; font-size: 0.9rem;">
                            {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->full_name ?? 'U', 0, 1)) }}
                        </div>
                    @endif
                    <span class="user-name fw-medium d-none d-sm-inline-block text-dark small">{{ auth()->user()->first_name ?? auth()->user()->full_name ?? 'Account' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-4 border-0 py-2 mt-2" aria-labelledby="userMenuDropdown" style="min-width: 220px; font-size: 0.9rem;">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold text-dark text-truncate">{{ auth()->user()->full_name ?? auth()->user()->first_name }}</div>
                        <div class="text-muted small text-truncate">{{ auth()->user()->email }}</div>
                    </li>
                    <li><a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('creator.dashboard') }}"><i class="bi bi-speedometer2 text-primary"></i> Creator Studio</a></li>
                    <li><a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('settings') }}"><i class="bi bi-gear text-secondary"></i> Account Settings</a></li>
                    <li><a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('history.index') }}"><i class="bi bi-clock-history text-info"></i> Watch History</a></li>
                    <li><a class="dropdown-item py-2 px-3 d-flex align-items-center gap-2" href="{{ route('favorites.index') }}"><i class="bi bi-heart text-danger"></i> Favorites</a></li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 px-3 text-danger d-flex align-items-center gap-2 border-0 bg-transparent w-100 text-start">
                                <i class="bi bi-box-arrow-right"></i> Log Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn-custom btn-outline-custom text-decoration-none">
                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
            </a>
            <a href="{{ route('register') }}" class="btn-custom btn-primary-custom text-decoration-none">
                <i class="bi bi-person-plus-fill me-1"></i> Register
            </a>
        @endauth
    </div>
</header>
