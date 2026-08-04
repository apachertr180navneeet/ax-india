@extends('web.layouts.app')

@section('content')
    <!-- Category Filter Bar -->
    <div class="category-bar">
        <div class="category-pill active"><i class="bi bi-compass"></i> Discover</div>
        <div class="category-pill"><i class="bi bi-fire"></i> Trending</div>
        <div class="category-pill"><i class="bi bi-music-note-beaming"></i> Music & Audio</div>
        <div class="category-pill"><i class="bi bi-camera-reels"></i> Documentaries</div>
        <div class="category-pill"><i class="bi bi-palette"></i> Design & Arts</div>
        <div class="category-pill"><i class="bi bi-cpu"></i> Tech & Innovation</div>
        <div class="category-pill"><i class="bi bi-globe"></i> World Stories</div>
        <div class="category-pill"><i class="bi bi-broadcast"></i> Live Events</div>
    </div>

    <!-- Hero Featured Spotlight -->
    <div class="hero-featured">
        <div class="hero-card">
            <div class="hero-content">
                <span class="hero-tag"><i class="bi bi-fire"></i> Premier Spotlight</span>
                <h1 class="hero-title">High-Definition Visual Masterpieces & Creator Stories</h1>
                <p class="hero-desc">Experience ultra-smooth streaming, curated high-definition video collections, dynamic
                    channel feeds, and creator studios in YouTube Dark style.</p>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <a href="{{ route('play.demo', 1) }}" class="btn-custom btn-primary-custom">
                        <i class="bi bi-play-fill" style="font-size: 1.2rem;"></i> Watch Premier Now
                    </a>
                    <button class="btn-custom btn-outline-custom">
                        <i class="bi bi-bookmark-plus"></i> Watchlist
                    </button>
                </div>
            </div>
            <div class="hero-media">
                <a href="{{ route('play.demo', 1) }}" class="d-block position-relative">
                    <img src="{{ asset('assets/web/img/hero.png') }}" alt="Featured Video">
                    <div class="play-overlay-btn">
                        <i class="bi bi-play-fill" style="font-size: 2.2rem; color: #ffffff; margin-left: 4px;"></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Video Stream Feed Grid -->
    <div class="section-container">
        <div class="section-header">
            <div>
                <h2 class="section-title">Recommended Videos</h2>
                <p style="color: var(--text-muted); font-size: 0.9rem;">Handpicked releases tailored for your aesthetic
                    taste</p>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <button class="btn-custom btn-outline-custom" style="padding: 0.4rem 0.8rem; font-size: 0.82rem;">
                    <i class="bi bi-sliders"></i> Filter
                </button>
            </div>
        </div>

        <div class="video-grid">
            <a href="{{ route('play.demo', 1) }}" class="video-card text-decoration-none">
                <div class="thumbnail-wrapper">
                    <img src="{{ asset('assets/web/img/thumb1.png') }}" alt="Sanctuary of Light">
                    <span class="video-duration">14:28</span>
                </div>
                <div class="video-info">
                    <div class="channel-avatar">AX</div>
                    <div class="video-details">
                        <h3 class="video-card-title">Sanctuary of Light: Architectural Calm & Linen Spaces</h3>
                        <div class="channel-name">AX Studio • Heritage Series</div>
                        <div class="video-meta">48K views • 2 days ago</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('play.demo', 2) }}" class="video-card text-decoration-none">
                <div class="thumbnail-wrapper">
                    <img src="{{ asset('assets/web/img/hero.png') }}" alt="Mountain Whispers">
                    <span class="video-duration">22:05</span>
                </div>
                <div class="video-info">
                    <div class="channel-avatar">HS</div>
                    <div class="video-details">
                        <h3 class="video-card-title">Whispers of the Summit: Golden Hour Cinematic Journey</h3>
                        <div class="channel-name">Highland Stories</div>
                        <div class="video-meta">125K views • 5 days ago</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('play.demo', 3) }}" class="video-card text-decoration-none">
                <div class="thumbnail-wrapper">
                    <img src="{{ asset('assets/web/img/thumb1.png') }}" alt="Crafting Manuscripts">
                    <span class="video-duration">08:42</span>
                </div>
                <div class="video-info">
                    <div class="channel-avatar">PM</div>
                    <div class="video-details">
                        <h3 class="video-card-title">The Art of Parchment Calligraphy & Bone Inlays</h3>
                        <div class="channel-name">Paper & Ink Masters</div>
                        <div class="video-meta">19K views • 1 week ago</div>
                    </div>
                </div>
            </a>

            <a href="{{ route('play.demo', 4) }}" class="video-card text-decoration-none">
                <div class="thumbnail-wrapper">
                    <img src="{{ asset('assets/web/img/hero.png') }}" alt="Almond Silk Harmonies">
                    <span class="video-duration">45:10</span>
                </div>
                <div class="video-info">
                    <div class="channel-avatar">AS</div>
                    <div class="video-details">
                        <h3 class="video-card-title">Almond Silk Harmonies: Acoustic Ambient Live Performance</h3>
                        <div class="channel-name">Almond Sessions</div>
                        <div class="video-meta">310K views • 2 weeks ago</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection
