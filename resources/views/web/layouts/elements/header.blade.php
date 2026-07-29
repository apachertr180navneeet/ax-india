<header class="site-header">
    <a class="brand-logo" href="{{ url('/') }}">
        <div class="logo-icon">
            <i class="bi bi-play-btn-fill"></i>
        </div>
        <span>AX-India</span>
    </a>
    
    <div class="search-bar-container">
        <i class="bi bi-search search-icon"></i>
        <input type="text" class="search-input" placeholder="Search videos, creators, or topics...">
    </div>

    <div class="nav-actions">
        <a href="{{ route('admin.login') }}" class="btn-custom btn-outline-custom">
            <i class="bi bi-person-lock"></i> Admin Portal
        </a>
        <button class="btn-custom btn-primary-custom">
            <i class="bi bi-cloud-upload-fill"></i> Upload Video
        </button>
    </div>
</header>
