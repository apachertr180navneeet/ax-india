@extends('web.layouts.app')

@section('title', $video['title'] . ' - AX India')

@section('content')
    <div class="watch-page" id="watchDemoUi" data-title="{{ $video['title'] }}" data-url="{{ url()->current() }}"
        data-video="{{ $video['video_url'] }}" data-likes="3200">
        <div class="watch-layout">
            <div class="watch-main">
                <div class="watch-player-shell" id="playerShell">
                    <video class="watch-player" id="watchPlayer" autoplay playsinline
                        poster="{{ asset($video['thumb']) }}">
                        <source src="{{ $video['video_url'] }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <div class="yt-controls" id="ytControls">
                        <div class="yt-controls-row">
                            <div class="yt-controls-left">
                                <button type="button" class="yt-ctrl-btn" id="ytPlay" aria-label="Play">
                                    <i class="bi bi-play-fill" id="ytPlayIcon"></i>
                                </button>
                                <span class="yt-time" id="ytTime">0:00 / 0:00</span>
                            </div>
                            <div class="yt-controls-right">
                                <div class="yt-volume-wrap">
                                    <button type="button" class="yt-ctrl-btn" id="ytMute" aria-label="Volume">
                                        <i class="bi bi-volume-up-fill" id="ytVolumeIcon"></i>
                                    </button>
                                    <input type="range" class="yt-volume" id="ytVolume" min="0" max="1" step="0.05" value="1" aria-label="Volume">
                                </div>
                                <button type="button" class="yt-ctrl-btn" id="ytFullscreen" aria-label="Full screen">
                                    <i class="bi bi-fullscreen"></i>
                                </button>
                                <div class="yt-more-wrap" id="ytMoreWrap">
                                    <button type="button" class="yt-ctrl-btn" id="ytMore" aria-label="More options" aria-expanded="false">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <div class="yt-more-menu" id="ytMoreMenu" hidden>
                                        <div class="yt-menu-panel" id="ytMenuMain">
                                            <button type="button" class="yt-menu-item" id="ytLoop"><i class="bi bi-arrow-repeat"></i><span>Loop</span></button>
                                            <button type="button" class="yt-menu-item" id="ytPiP"><i class="bi bi-pip"></i><span>Picture in picture</span></button>
                                            <button type="button" class="yt-menu-item yt-menu-next" id="ytOpenQuality">
                                                <span class="yt-menu-item-left"><i class="bi bi-badge-hd"></i><span>Quality</span></span>
                                                <span class="yt-menu-value"><span id="ytQualityLabel">Auto</span> <i class="bi bi-chevron-right"></i></span>
                                            </button>
                                            <button type="button" class="yt-menu-item" data-bs-toggle="modal" data-bs-target="#downloadModal"><i class="bi bi-download"></i><span>Download</span></button>
                                            <button type="button" class="yt-menu-item" data-bs-toggle="modal" data-bs-target="#reportModal"><i class="bi bi-flag"></i><span>Report</span></button>
                                        </div>
                                        <div class="yt-menu-panel" id="ytMenuQuality" hidden>
                                            <button type="button" class="yt-menu-item yt-menu-back" id="ytQualityBack">
                                                <i class="bi bi-chevron-left"></i><span>Quality</span>
                                            </button>
                                            <div class="yt-menu-divider"></div>
                                            <button type="button" class="yt-menu-item yt-quality-option is-selected" data-quality="auto" data-label="Auto">
                                                <span>Auto</span><i class="bi bi-check2 yt-quality-check"></i>
                                            </button>
                                            <button type="button" class="yt-menu-item yt-quality-option" data-quality="1080" data-label="1080p">
                                                <span>1080p <em class="yt-quality-tag">HD</em></span><i class="bi bi-check2 yt-quality-check"></i>
                                            </button>
                                            <button type="button" class="yt-menu-item yt-quality-option" data-quality="720" data-label="720p">
                                                <span>720p <em class="yt-quality-tag">HD</em></span><i class="bi bi-check2 yt-quality-check"></i>
                                            </button>
                                            <button type="button" class="yt-menu-item yt-quality-option" data-quality="480" data-label="480p">
                                                <span>480p</span><i class="bi bi-check2 yt-quality-check"></i>
                                            </button>
                                            <button type="button" class="yt-menu-item yt-quality-option" data-quality="360" data-label="360p">
                                                <span>360p</span><i class="bi bi-check2 yt-quality-check"></i>
                                            </button>
                                            <button type="button" class="yt-menu-item yt-quality-option" data-quality="144" data-label="144p">
                                                <span>144p</span><i class="bi bi-check2 yt-quality-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="yt-progress-wrap" id="ytProgressWrap">
                            <div class="yt-progress" id="ytProgress" role="slider" aria-label="Seek" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" tabindex="0">
                                <div class="yt-progress-track">
                                    <div class="yt-progress-buffered" id="ytBuffered"></div>
                                    <div class="yt-progress-played" id="ytPlayed"></div>
                                </div>
                                <div class="yt-progress-thumb" id="ytThumb"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <h1 class="watch-title">{{ $video['title'] }}</h1>

                <div class="watch-meta-row">
                    <p class="watch-views">{{ $video['views'] }} views · {{ $video['ago'] }}</p>
                    <div class="watch-actions">
                        <button type="button" class="watch-action-btn" id="btnLike" aria-pressed="false">
                            <i class="bi bi-hand-thumbs-up" id="iconLike"></i>
                            <span id="likeCountLabel">{{ $video['likes'] }}</span>
                        </button>
                        <button type="button" class="watch-action-btn" id="btnDislike" aria-pressed="false">
                            <i class="bi bi-hand-thumbs-down" id="iconDislike"></i>
                        </button>
                        <button type="button" class="watch-action-btn" id="btnShare" data-bs-toggle="modal"
                            data-bs-target="#shareModal">
                            <i class="bi bi-share"></i> Share
                        </button>
                        <button type="button" class="watch-action-btn" id="btnDownload" data-bs-toggle="modal"
                            data-bs-target="#downloadModal">
                            <i class="bi bi-download"></i> Download
                        </button>
                        <button type="button" class="watch-action-btn" id="btnSave" data-bs-toggle="modal"
                            data-bs-target="#saveModal" aria-pressed="false">
                            <i class="bi bi-bookmark" id="iconSave"></i> <span id="saveLabel">Save</span>
                        </button>
                        <button type="button" class="watch-action-btn" id="btnReport" data-bs-toggle="modal"
                            data-bs-target="#reportModal">
                            <i class="bi bi-flag"></i> Report
                        </button>
                        <button type="button" class="watch-action-btn" id="btnCopyright" data-bs-toggle="modal"
                            data-bs-target="#copyrightModal">
                            <i class="bi bi-c-circle"></i> Copyright
                        </button>
                    </div>
                </div>

                <div class="watch-channel-card">
                    <div class="watch-channel-left">
                        <div class="channel-avatar watch-channel-avatar">{{ $video['avatar'] }}</div>
                        <div>
                            <div class="watch-channel-name">
                                {{ $video['channel'] }}
                                @if ($video['series'])
                                    <span class="watch-series">· {{ $video['series'] }}</span>
                                @endif
                            </div>
                            <div class="watch-subs"><span id="subsCount">128</span>K subscribers</div>
                        </div>
                    </div>
                    <button type="button" class="btn-custom btn-primary-custom watch-subscribe-btn" id="btnSubscribe"
                        aria-pressed="false">
                        Subscribe
                    </button>
                </div>

                <div class="watch-description">
                    <div class="watch-description-meta">{{ $video['views'] }} views · {{ $video['ago'] }}</div>
                    <p>{!! nl2br(e($video['description'])) !!}</p>
                </div>

                <div class="watch-comments">
                    <h3 class="watch-comments-title"><span id="commentCount">{{ count($comments) }}</span> Comments</h3>

                    <form class="watch-comment-form" id="commentForm">
                        <div class="channel-avatar">YOU</div>
                        <input type="text" class="watch-comment-input" id="commentInput" placeholder="Add a comment..."
                            autocomplete="off">
                        <button type="submit" class="btn-custom btn-primary-custom watch-comment-submit" id="btnComment"
                            disabled>Comment</button>
                    </form>

                    <div id="commentsList">
                        @foreach ($comments as $comment)
                            <div class="watch-comment">
                                <div class="channel-avatar">{{ $comment['avatar'] }}</div>
                                <div>
                                    <div class="watch-comment-head">
                                        <span class="watch-comment-name">{{ $comment['name'] }}</span>
                                        <span class="watch-comment-ago">{{ $comment['ago'] }}</span>
                                    </div>
                                    <p class="watch-comment-body">{{ $comment['body'] }}</p>
                                    <div class="watch-comment-actions">
                                        <button type="button" class="cmt-like"><i class="bi bi-hand-thumbs-up"></i>
                                            <span>0</span></button>
                                        <button type="button" class="cmt-dislike"><i
                                                class="bi bi-hand-thumbs-down"></i></button>
                                        <button type="button" class="cmt-reply">Reply</button>
                                    </div>
                                    <div class="cmt-reply-box d-none">
                                        <input type="text" class="watch-comment-input" placeholder="Add a reply...">
                                        <button type="button" class="btn-custom btn-primary-custom cmt-reply-send"
                                            style="padding:0.35rem 0.9rem;font-size:0.8rem;">Reply</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <aside class="watch-sidebar">
                <h3 class="watch-sidebar-title">Up next</h3>
                @foreach ($related as $item)
                    <a href="{{ route('play.demo', $item['id']) }}" class="watch-related-card">
                        <div class="watch-related-thumb">
                            <img src="{{ asset($item['thumb']) }}" alt="{{ $item['title'] }}">
                            <span class="video-duration">{{ $item['duration'] }}</span>
                        </div>
                        <div class="watch-related-info">
                            <h4>{{ $item['title'] }}</h4>
                            <p>{{ $item['channel'] }}</p>
                            <p>{{ $item['views'] }} views · {{ $item['ago'] }}</p>
                        </div>
                    </a>
                @endforeach
            </aside>
        </div>
    </div>

    {{-- Share Modal --}}
    <div class="modal fade" id="shareModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content watch-ui-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Share</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="watch-share-grid">
                        <button type="button" class="watch-share-item" data-share="copy">
                            <span class="watch-share-icon"><i class="bi bi-link-45deg"></i></span>
                            Copy link
                        </button>
                        <a class="watch-share-item" id="shareWhatsApp" href="#" target="_blank" rel="noopener">
                            <span class="watch-share-icon wa"><i class="bi bi-whatsapp"></i></span>
                            WhatsApp
                        </a>
                        <a class="watch-share-item" id="shareTwitter" href="#" target="_blank" rel="noopener">
                            <span class="watch-share-icon tw"><i class="bi bi-twitter-x"></i></span>
                            X / Twitter
                        </a>
                        <a class="watch-share-item" id="shareFacebook" href="#" target="_blank" rel="noopener">
                            <span class="watch-share-icon fb"><i class="bi bi-facebook"></i></span>
                            Facebook
                        </a>
                        <a class="watch-share-item" id="shareTelegram" href="#" target="_blank" rel="noopener">
                            <span class="watch-share-icon tg"><i class="bi bi-telegram"></i></span>
                            Telegram
                        </a>
                        <button type="button" class="watch-share-item" data-share="embed">
                            <span class="watch-share-icon"><i class="bi bi-code-slash"></i></span>
                            Embed
                        </button>
                    </div>
                    <div class="watch-share-link-row mt-3">
                        <input type="text" class="form-control" id="shareLinkInput" readonly>
                        <button type="button" class="btn-custom btn-primary-custom" id="btnCopyShareLink">Copy</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Save / Playlist Modal --}}
    <div class="modal fade" id="saveModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content watch-ui-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Save to…</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <label class="watch-playlist-item">
                        <input type="checkbox" class="form-check-input playlist-check" data-name="Watch later" checked>
                        <span><i class="bi bi-clock-history me-2"></i>Watch later</span>
                    </label>
                    <label class="watch-playlist-item">
                        <input type="checkbox" class="form-check-input playlist-check" data-name="Favorites">
                        <span><i class="bi bi-heart me-2"></i>Favorites</span>
                    </label>
                    <label class="watch-playlist-item">
                        <input type="checkbox" class="form-check-input playlist-check" data-name="Design Inspiration">
                        <span><i class="bi bi-collection-play me-2"></i>Design Inspiration</span>
                    </label>
                    <button type="button" class="watch-playlist-create" id="btnCreatePlaylist">
                        <i class="bi bi-plus-lg"></i> Create new playlist
                    </button>
                    <div class="d-none mt-2" id="newPlaylistRow">
                        <input type="text" class="form-control mb-2" id="newPlaylistName"
                            placeholder="Playlist name">
                        <button type="button" class="btn-custom btn-primary-custom w-100"
                            id="btnAddPlaylist">Create</button>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn-custom btn-primary-custom w-100" data-bs-dismiss="modal"
                        id="btnSaveDone">Done</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Download Quality Modal --}}
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content watch-ui-modal watch-download-modal">
                <div class="modal-header border-0 pb-2">
                    <h5 class="modal-title fw-bold">Download Quality</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="watch-quality-list" role="radiogroup" aria-label="Download quality">
                        <label class="watch-quality-option">
                            <input type="radio" name="downloadQuality" value="480" data-label="Standard (480p)"
                                checked>
                            <span class="watch-quality-radio" aria-hidden="true"></span>
                            <span class="watch-quality-name">Standard (480p)</span>
                            <span class="watch-quality-size">248 MB</span>
                        </label>
                        <label class="watch-quality-option">
                            <input type="radio" name="downloadQuality" value="144" data-label="Low (144p)">
                            <span class="watch-quality-radio" aria-hidden="true"></span>
                            <span class="watch-quality-name">Low (144p)</span>
                            <span class="watch-quality-size">127 MB</span>
                        </label>
                        <label class="watch-quality-option">
                            <input type="radio" name="downloadQuality" value="720" data-label="High (720p)">
                            <span class="watch-quality-radio" aria-hidden="true"></span>
                            <span class="watch-quality-name">High (720p)</span>
                            <span class="watch-quality-size">381 MB</span>
                        </label>
                        <label class="watch-quality-option">
                            <input type="radio" name="downloadQuality" value="1080" data-label="Full HD (1080p)">
                            <span class="watch-quality-radio" aria-hidden="true"></span>
                            <span class="watch-quality-name">Full HD (1080p)</span>
                            <span class="watch-quality-size">1.4 GB</span>
                        </label>
                    </div>
                    <hr class="watch-download-divider">
                    <label class="watch-download-remember">
                        <input type="checkbox" class="form-check-input" id="rememberDownloadQuality">
                        <span>Remember my settings for 30 days</span>
                    </label>
                </div>
                <div class="modal-footer border-0 pt-0 watch-download-footer">
                    <button type="button" class="watch-download-cancel" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="watch-download-confirm" id="btnConfirmDownload">Download</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Report Modal --}}
    <div class="modal fade" id="reportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content watch-ui-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Report video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="text-muted small mb-3">Select a reason (UI demo — nothing is sent).</p>
                    <div class="watch-report-options">
                        @foreach (['Spam or misleading', 'Harassment or bullying', 'Hate speech', 'Violent or harmful content', 'Sexual content', 'Copyright infringement', 'Other'] as $reason)
                            <label class="watch-report-option">
                                <input type="radio" name="reportReason" value="{{ $reason }}">
                                <span>{{ $reason }}</span>
                            </label>
                        @endforeach
                    </div>
                    <textarea class="form-control mt-3 d-none" id="reportDetails" rows="3"
                        placeholder="Additional details (optional)"></textarea>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-custom btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-custom btn-primary-custom" id="btnSubmitReport" disabled>Submit
                        report</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright Claim Modal (UI only) --}}
    <div class="modal fade" id="copyrightModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content watch-ui-modal">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Copyright claim</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <p class="text-muted small mb-3">Submit a copyright claim for this video (UI demo — nothing is sent).</p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Your full name</label>
                        <input type="text" class="form-control" id="copyrightName" placeholder="Legal name of rights holder">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="copyrightEmail" placeholder="you@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Original work URL / description</label>
                        <textarea class="form-control" id="copyrightWork" rows="3" placeholder="Link or describe your original content"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Claim type</label>
                        <select class="form-select" id="copyrightType">
                            <option>Unauthorized use of my video</option>
                            <option>Unauthorized use of my music / audio</option>
                            <option>Unauthorized use of my image / artwork</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <label class="d-flex align-items-start gap-2 small">
                        <input type="checkbox" class="form-check-input mt-1" id="copyrightConfirm">
                        <span>I confirm I am the copyright owner or authorized to act on their behalf.</span>
                    </label>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn-custom btn-outline-custom" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn-custom btn-primary-custom" id="btnSubmitCopyright">Submit claim</button>
                </div>
            </div>
        </div>
    </div>

    <div class="watch-toast" id="watchToast" role="status" aria-live="polite"></div>
@endsection

@section('script')
    <script>
        (function() {
                const root = document.getElementById('watchDemoUi');
                if (!root) return;

                const pageUrl = root.dataset.url;
                const pageTitle = root.dataset.title;
                const videoUrl = root.dataset.video;
                let likeCount = parseInt(root.dataset.likes, 10) || 3200;
                let liked = false;
                let disliked = false;
                let subscribed = false;
                let commentTotal = parseInt(document.getElementById('commentCount').textContent, 10) || 0;

                function formatLikes(n) {
                    if (n >= 1000) return (n / 1000).toFixed(n % 1000 === 0 ? 0 : 1).replace(/\.0$/, '') + 'K';
                    return String(n);
                }

                function showToast(message) {
                    const toast = document.getElementById('watchToast');
                    toast.textContent = message;
                    toast.classList.add('show');
                    clearTimeout(showToast._t);
                    showToast._t = setTimeout(() => toast.classList.remove('show'), 2200);
                }

                // Custom player controls (UI)
                (function initPlayerUi() {
                    const video = document.getElementById('watchPlayer');
                    const shell = document.getElementById('playerShell');
                    if (!video || !shell) return;

                    const playBtn = document.getElementById('ytPlay');
                    const playIcon = document.getElementById('ytPlayIcon');
                    const timeEl = document.getElementById('ytTime');
                    const progress = document.getElementById('ytProgress');
                    const progressWrap = document.getElementById('ytProgressWrap');
                    const playedBar = document.getElementById('ytPlayed');
                    const bufferedBar = document.getElementById('ytBuffered');
                    const thumb = document.getElementById('ytThumb');
                    let isSeeking = false;
                    const muteBtn = document.getElementById('ytMute');
                    const volumeIcon = document.getElementById('ytVolumeIcon');
                    const volume = document.getElementById('ytVolume');
                    const fsBtn = document.getElementById('ytFullscreen');
                    const loopBtn = document.getElementById('ytLoop');
                    const pipBtn = document.getElementById('ytPiP');
                    let hideTimer = null;

                    function fmt(sec) {
                        if (!isFinite(sec)) return '0:00';
                        sec = Math.max(0, Math.floor(sec));
                        const m = Math.floor(sec / 60);
                        const s = sec % 60;
                        return m + ':' + String(s).padStart(2, '0');
                    }

                    function syncPlayIcon() {
                        const playing = !video.paused;
                        playIcon.className = playing ? 'bi bi-pause-fill' : 'bi bi-play-fill';
                        playBtn.setAttribute('aria-label', playing ? 'Pause' : 'Play');
                        shell.classList.toggle('is-playing', playing);
                    }

                    function syncVolumeIcon() {
                        if (video.muted || video.volume === 0) {
                            volumeIcon.className = 'bi bi-volume-mute-fill';
                        } else if (video.volume < 0.5) {
                            volumeIcon.className = 'bi bi-volume-down-fill';
                        } else {
                            volumeIcon.className = 'bi bi-volume-up-fill';
                        }
                    }

                    function updateProgressFill(pct) {
                        const value = Math.max(0, Math.min(100, pct == null ? 0 : Number(pct)));
                        playedBar.style.width = value + '%';
                        thumb.style.left = value + '%';
                        progress.setAttribute('aria-valuenow', String(Math.round(value)));
                    }

                    function updateBuffered() {
                        try {
                            if (!video.duration || !video.buffered.length) {
                                bufferedBar.style.width = '0%';
                                return;
                            }
                            const end = video.buffered.end(video.buffered.length - 1);
                            bufferedBar.style.width = ((end / video.duration) * 100) + '%';
                        } catch (e) {
                            bufferedBar.style.width = '0%';
                        }
                    }

                    function seekFromEvent(e) {
                        if (!video.duration) return 0;
                        const rect = progress.getBoundingClientRect();
                        const x = (e.clientX != null ? e.clientX : (e.touches && e.touches[0].clientX)) - rect.left;
                        const pct = Math.max(0, Math.min(1, x / rect.width));
                        video.currentTime = pct * video.duration;
                        updateProgressFill(pct * 100);
                        return pct * 100;
                    }

                    function showControlsBriefly() {
                        shell.classList.add('show-controls');
                        clearTimeout(hideTimer);
                        hideTimer = setTimeout(function () {
                            if (!video.paused && !shell.classList.contains('menu-open')) {
                                shell.classList.remove('show-controls');
                            }
                        }, 2500);
                    }

                    playBtn.addEventListener('click', function () {
                        if (video.paused) video.play();
                        else video.pause();
                    });

                    video.addEventListener('click', function () {
                        if (video.paused) video.play();
                        else video.pause();
                    });

                    video.addEventListener('play', syncPlayIcon);
                    video.addEventListener('pause', function () {
                        syncPlayIcon();
                        shell.classList.add('show-controls');
                    });

                    video.addEventListener('timeupdate', function () {
                        if (!isSeeking) {
                            const pct = video.duration ? (video.currentTime / video.duration) * 100 : 0;
                            updateProgressFill(pct);
                        }
                        updateBuffered();
                        timeEl.textContent = fmt(video.currentTime) + ' / ' + fmt(video.duration);
                    });

                    video.addEventListener('progress', updateBuffered);

                    video.addEventListener('loadedmetadata', function () {
                        timeEl.textContent = fmt(video.currentTime) + ' / ' + fmt(video.duration);
                        updateBuffered();
                    });

                    progressWrap.addEventListener('pointerdown', function (e) {
                        e.preventDefault();
                        isSeeking = true;
                        progress.classList.add('is-dragging');
                        seekFromEvent(e);
                        showControlsBriefly();
                        progress.setPointerCapture?.(e.pointerId);
                    });

                    progressWrap.addEventListener('pointermove', function (e) {
                        if (!isSeeking) return;
                        seekFromEvent(e);
                    });

                    function endSeek(e) {
                        if (!isSeeking) return;
                        seekFromEvent(e);
                        isSeeking = false;
                        progress.classList.remove('is-dragging');
                    }

                    progressWrap.addEventListener('pointerup', endSeek);
                    progressWrap.addEventListener('pointercancel', function () {
                        isSeeking = false;
                        progress.classList.remove('is-dragging');
                    });

                    progress.addEventListener('keydown', function (e) {
                        if (!video.duration) return;
                        const step = video.duration * 0.05;
                        if (e.key === 'ArrowRight') {
                            video.currentTime = Math.min(video.duration, video.currentTime + step);
                        } else if (e.key === 'ArrowLeft') {
                            video.currentTime = Math.max(0, video.currentTime - step);
                        } else {
                            return;
                        }
                        e.preventDefault();
                        updateProgressFill((video.currentTime / video.duration) * 100);
                    });

                    muteBtn.addEventListener('click', function () {
                        video.muted = !video.muted;
                        if (!video.muted && video.volume === 0) video.volume = 0.5;
                        volume.value = video.muted ? 0 : video.volume;
                        syncVolumeIcon();
                    });

                    volume.addEventListener('input', function () {
                        video.volume = parseFloat(volume.value);
                        video.muted = video.volume === 0;
                        syncVolumeIcon();
                    });

                    fsBtn.addEventListener('click', function () {
                        if (!document.fullscreenElement) {
                            (shell.requestFullscreen || shell.webkitRequestFullscreen).call(shell);
                        } else {
                            (document.exitFullscreen || document.webkitExitFullscreen).call(document);
                        }
                    });

                    loopBtn.addEventListener('click', function () {
                        video.loop = !video.loop;
                        loopBtn.classList.toggle('is-on', video.loop);
                        showToast(video.loop ? 'Loop on' : 'Loop off');
                    });

                    pipBtn.addEventListener('click', function () {
                        if (document.pictureInPictureElement) {
                            document.exitPictureInPicture();
                        } else if (document.pictureInPictureEnabled) {
                            video.requestPictureInPicture().catch(function () {
                                showToast('Picture in picture not available');
                            });
                        } else {
                            showToast('Picture in picture not available');
                        }
                    });

                    // Custom more menu + Quality submenu
                    const moreBtn = document.getElementById('ytMore');
                    const moreWrap = document.getElementById('ytMoreWrap');
                    const moreMenu = document.getElementById('ytMoreMenu');
                    const menuMain = document.getElementById('ytMenuMain');
                    const menuQuality = document.getElementById('ytMenuQuality');
                    const qualityLabel = document.getElementById('ytQualityLabel');
                    let currentQuality = 'auto';
                    let ignoreOutsideClick = false;

                    function positionMoreMenu() {
                        const rect = moreBtn.getBoundingClientRect();
                        const menuWidth = 260;
                        const gap = 8;
                        let left = rect.right - menuWidth;
                        if (left < 8) left = 8;
                        if (left + menuWidth > window.innerWidth - 8) {
                            left = window.innerWidth - menuWidth - 8;
                        }
                        // Prefer opening above the button
                        moreMenu.style.position = 'fixed';
                        moreMenu.style.zIndex = '5000';
                        moreMenu.style.width = menuWidth + 'px';
                        moreMenu.style.left = left + 'px';
                        moreMenu.style.right = 'auto';
                        moreMenu.style.bottom = 'auto';

                        // Temporarily show to measure height
                        moreMenu.hidden = false;
                        const menuHeight = moreMenu.offsetHeight || 280;
                        let top = rect.top - menuHeight - gap;
                        if (top < 8) {
                            top = rect.bottom + gap;
                        }
                        moreMenu.style.top = top + 'px';
                    }

                    function openMoreMenu() {
                        ignoreOutsideClick = true;
                        shell.classList.add('show-controls', 'menu-open');
                        showMenuPanel('main');
                        if (moreMenu.parentElement !== document.body) {
                            document.body.appendChild(moreMenu);
                        }
                        positionMoreMenu();
                        moreMenu.hidden = false;
                        moreMenu.classList.add('is-open');
                        moreBtn.setAttribute('aria-expanded', 'true');
                        moreBtn.classList.add('is-open');
                        setTimeout(function () { ignoreOutsideClick = false; }, 50);
                    }

                    function closeMoreMenu() {
                        moreMenu.hidden = true;
                        moreMenu.classList.remove('is-open');
                        moreBtn.setAttribute('aria-expanded', 'false');
                        moreBtn.classList.remove('is-open');
                        shell.classList.remove('menu-open');
                        showMenuPanel('main');
                    }

                    function showMenuPanel(panel) {
                        if (panel === 'quality') {
                            menuMain.hidden = true;
                            menuQuality.hidden = false;
                        } else {
                            menuMain.hidden = false;
                            menuQuality.hidden = true;
                        }
                        if (!moreMenu.hidden) {
                            requestAnimationFrame(positionMoreMenu);
                        }
                    }

                    moreBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        if (moreMenu.hidden) openMoreMenu();
                        else closeMoreMenu();
                    });

                    document.getElementById('ytOpenQuality').addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        showMenuPanel('quality');
                    });

                    document.getElementById('ytQualityBack').addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        showMenuPanel('main');
                    });

                    document.querySelectorAll('.yt-quality-option').forEach(function (btn) {
                        btn.addEventListener('click', function (e) {
                            e.preventDefault();
                            e.stopPropagation();
                            currentQuality = btn.dataset.quality;
                            const label = btn.dataset.label;
                            qualityLabel.textContent = label;
                            document.querySelectorAll('.yt-quality-option').forEach(function (el) {
                                el.classList.toggle('is-selected', el === btn);
                            });

                            const scales = { auto: 1, '1080': 1, '720': 0.98, '480': 0.94, '360': 0.9, '144': 0.84 };
                            video.style.transform = 'scale(' + (scales[currentQuality] || 1) + ')';
                            video.style.filter = currentQuality === '144' ? 'contrast(0.92) saturate(0.9)' :
                                currentQuality === '360' ? 'contrast(0.96)' : 'none';

                            showToast('Quality set to ' + label);
                            closeMoreMenu();
                        });
                    });

                    moreMenu.addEventListener('click', function (e) {
                        e.stopPropagation();
                        if (e.target.closest('[data-bs-toggle="modal"]')) {
                            closeMoreMenu();
                        }
                    });

                    document.addEventListener('click', function (e) {
                        if (ignoreOutsideClick) return;
                        if (moreMenu.hidden) return;
                        if (moreWrap.contains(e.target) || moreMenu.contains(e.target)) return;
                        closeMoreMenu();
                    });

                    window.addEventListener('resize', function () {
                        if (!moreMenu.hidden) positionMoreMenu();
                    });

                    shell.addEventListener('mousemove', showControlsBriefly);
                    shell.classList.add('show-controls');
                    syncPlayIcon();
                    syncVolumeIcon();
                    updateProgressFill(0);
                    updateBuffered();
                })();

                // Like / Dislike
                const btnLike = document.getElementById('btnLike');
                const btnDislike = document.getElementById('btnDislike');
                const iconLike = document.getElementById('iconLike');
                const iconDislike = document.getElementById('iconDislike');
                const likeLabel = document.getElementById('likeCountLabel');

                btnLike.addEventListener('click', function() {
                    if (liked) {
                        liked = false;
                        likeCount -= 1;
                        btnLike.classList.remove('is-active');
                        btnLike.setAttribute('aria-pressed', 'false');
                        iconLike.className = 'bi bi-hand-thumbs-up';
                        showToast('Like removed');
                    } else {
                        liked = true;
                        likeCount += 1;
                        if (disliked) {
                            disliked = false;
                            btnDislike.classList.remove('is-active');
                            btnDislike.setAttribute('aria-pressed', 'false');
                            iconDislike.className = 'bi bi-hand-thumbs-down';
                        }
                        btnLike.classList.add('is-active');
                        btnLike.setAttribute('aria-pressed', 'true');
                        iconLike.className = 'bi bi-hand-thumbs-up-fill';
                        showToast('Liked');
                    }
                    likeLabel.textContent = formatLikes(likeCount);
                });

                btnDislike.addEventListener('click', function() {
                    if (disliked) {
                        disliked = false;
                        btnDislike.classList.remove('is-active');
                        btnDislike.setAttribute('aria-pressed', 'false');
                        iconDislike.className = 'bi bi-hand-thumbs-down';
                        showToast('Dislike removed');
                    } else {
                        disliked = true;
                        if (liked) {
                            liked = false;
                            likeCount -= 1;
                            likeLabel.textContent = formatLikes(likeCount);
                            btnLike.classList.remove('is-active');
                            btnLike.setAttribute('aria-pressed', 'false');
                            iconLike.className = 'bi bi-hand-thumbs-up';
                        }
                        btnDislike.classList.add('is-active');
                        btnDislike.setAttribute('aria-pressed', 'true');
                        iconDislike.className = 'bi bi-hand-thumbs-down-fill';
                        showToast('Disliked');
                    }
                });

                // Share
                const shareInput = document.getElementById('shareLinkInput');
                shareInput.value = pageUrl;
                const encoded = encodeURIComponent(pageUrl);
                const encodedTitle = encodeURIComponent(pageTitle);
                document.getElementById('shareWhatsApp').href = 'https://wa.me/?text=' + encodedTitle + '%20' + encoded;
                document.getElementById('shareTwitter').href = 'https://twitter.com/intent/tweet?url=' + encoded +
                    '&text=' + encodedTitle;
                document.getElementById('shareFacebook').href = 'https://www.facebook.com/sharer/sharer.php?u=' + encoded;
                document.getElementById('shareTelegram').href = 'https://t.me/share/url?url=' + encoded + '&text=' +
                    encodedTitle;

                function copyShareLink() {
                    navigator.clipboard.writeText(pageUrl).then(function() {
                        showToast('Link copied');
                    }).catch(function() {
                        shareInput.select();
                        document.execCommand('copy');
                        showToast('Link copied');
                    });
                }

                document.getElementById('btnCopyShareLink').addEventListener('click', copyShareLink);
                document.querySelector('[data-share="copy"]').addEventListener('click', function() {
                    copyShareLink();
                    bootstrap.Modal.getInstance(document.getElementById('shareModal'))?.hide();
                });
                document.querySelector('[data-share="embed"]').addEventListener('click', function() {
                    const embed = '<iframe width="560" height="315" src="' + pageUrl +
                        '" frameborder="0" allowfullscreen></iframe>';
                    navigator.clipboard.writeText(embed).then(function() {
                        showToast('Embed code copied');
                    });
                    bootstrap.Modal.getInstance(document.getElementById('shareModal'))?.hide();
                });

                // Download quality modal (UI only)
                const downloadModalEl = document.getElementById('downloadModal');
                const rememberQuality = document.getElementById('rememberDownloadQuality');
                const QUALITY_KEY = 'ax_download_quality';
                const REMEMBER_KEY = 'ax_download_remember';

                (function restoreDownloadPrefs() {
                    try {
                        if (localStorage.getItem(REMEMBER_KEY) === '1') {
                            rememberQuality.checked = true;
                            const saved = localStorage.getItem(QUALITY_KEY);
                            if (saved) {
                                const radio = document.querySelector('input[name="downloadQuality"][value="' + saved +
                                    '"]');
                                if (radio) radio.checked = true;
                            }
                        }
                    } catch (e) {}
                })();

                document.getElementById('btnConfirmDownload').addEventListener('click', function() {
                    const selected = document.querySelector('input[name="downloadQuality"]:checked');
                    const label = selected ? selected.dataset.label : 'Standard (480p)';
                    const value = selected ? selected.value : '480';

                    try {
                        if (rememberQuality.checked) {
                            localStorage.setItem(REMEMBER_KEY, '1');
                            localStorage.setItem(QUALITY_KEY, value);
                        } else {
                            localStorage.removeItem(REMEMBER_KEY);
                            localStorage.removeItem(QUALITY_KEY);
                        }
                    } catch (e) {}

                    bootstrap.Modal.getInstance(downloadModalEl)?.hide();

                    const a = document.createElement('a');
                    a.href = videoUrl;
                    a.download = 'ax-india-' + value + 'p.mp4';
                    a.target = '_blank';
                    a.rel = 'noopener';
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    showToast('Downloading ' + label);
                });

                // Save / playlists
                const btnSave = document.getElementById('btnSave');
                const iconSave = document.getElementById('iconSave');
                const saveLabel = document.getElementById('saveLabel');

                function syncSaveState() {
                    const anyChecked = document.querySelectorAll('.playlist-check:checked').length > 0;
                    btnSave.classList.toggle('is-active', anyChecked);
                    btnSave.setAttribute('aria-pressed', anyChecked ? 'true' : 'false');
                    iconSave.className = anyChecked ? 'bi bi-bookmark-fill' : 'bi bi-bookmark';
                    saveLabel.textContent = anyChecked ? 'Saved' : 'Save';
                }

                document.querySelectorAll('.playlist-check').forEach(function(el) {
                    el.addEventListener('change', syncSaveState);
                });

                document.getElementById('btnSaveDone').addEventListener('click', function() {
                    syncSaveState();
                    const names = Array.from(document.querySelectorAll('.playlist-check:checked')).map(function(
                    el) {
                        return el.dataset.name;
                    });
                    if (names.length) {
                        showToast('Saved to ' + names.join(', '));
                    } else {
                        showToast('Removed from playlists');
                    }
                });

                document.getElementById('btnCreatePlaylist').addEventListener('click', function() {
                    document.getElementById('newPlaylistRow').classList.remove('d-none');
                    document.getElementById('newPlaylistName').focus();
                });

                document.getElementById('btnAddPlaylist').addEventListener('click', function() {
                        const name = document.getElementById('newPlaylistName').value.trim();
                        if (!name) {
                            showToast('Enter a playlist name');
                            return;
                        }
                        const label = document.createElement('label');
                        label.className = 'watch-playlist-item';
                        label.innerHTML = '<input type="checkbox" class="form-check-input playlist-check" data-name="' +
                            name.replace(/"/g, '&quot;') + '" checked>' +
                            '<span><i class="bi bi-collection-play me-2"></i>' + name.replace(/</g, '&lt;') + '</span>';
                        document.getElementById('btnCreatePlaylist').before(label);
                        label.querySelector('input').addEventListener('change', syncSaveState);
                        document.getElementById('newPlaylistName').value = '';
                        document.getElementById('newPlaylistRow').classList.add('d-none');
                        syncSaveState();
                        showToast('Playlist "' + name + '" created');
                        });

                    syncSaveState();

                    // Report
                    const btnSubmitReport = document.getElementById('btnSubmitReport');
                    const reportDetails = document.getElementById('reportDetails'); document.querySelectorAll(
                        'input[name="reportReason"]').forEach(function(radio) {
                        radio.addEventListener('change', function() {
                            btnSubmitReport.disabled = false;
                            reportDetails.classList.toggle('d-none', radio.value !== 'Other');
                        });
                    });

                    btnSubmitReport.addEventListener('click', function() {
                        const reason = document.querySelector('input[name="reportReason"]:checked');
                        if (!reason) return;
                        bootstrap.Modal.getInstance(document.getElementById('reportModal'))?.hide();
                        showToast('Report submitted - thanks for the feedback');
                        document.querySelectorAll('input[name="reportReason"]').forEach(function(r) {
                            r.checked = false;
                        });
                        reportDetails.value = '';
                        reportDetails.classList.add('d-none');
                        btnSubmitReport.disabled = true;
                    });

                    document.getElementById('btnSubmitCopyright')?.addEventListener('click', function () {
                        const name = document.getElementById('copyrightName')?.value.trim();
                        const email = document.getElementById('copyrightEmail')?.value.trim();
                        const work = document.getElementById('copyrightWork')?.value.trim();
                        const ok = document.getElementById('copyrightConfirm')?.checked;
                        if (!name || !email || !work || !ok) {
                            showToast('Fill all fields and confirm ownership');
                            return;
                        }
                        bootstrap.Modal.getInstance(document.getElementById('copyrightModal'))?.hide();
                        showToast('Copyright claim submitted (UI demo)');
                        document.getElementById('copyrightName').value = '';
                        document.getElementById('copyrightEmail').value = '';
                        document.getElementById('copyrightWork').value = '';
                        document.getElementById('copyrightConfirm').checked = false;
                    });

                    // Subscribe
                    const btnSubscribe = document.getElementById('btnSubscribe');
                    const subsCount = document.getElementById('subsCount');
                    let subs = 128; btnSubscribe.addEventListener('click', function() {
                        subscribed = !subscribed;
                        btnSubscribe.classList.toggle('is-subscribed', subscribed);
                        btnSubscribe.setAttribute('aria-pressed', subscribed ? 'true' : 'false');
                        btnSubscribe.textContent = subscribed ? 'Subscribed' : 'Subscribe';
                        subs += subscribed ? 1 : -1;
                        subsCount.textContent = String(subs);
                        showToast(subscribed ? 'Subscribed to channel' : 'Unsubscribed');
                    });

                    // Comments (UI)
                    const commentInput = document.getElementById('commentInput');
                    const btnComment = document.getElementById('btnComment'); commentInput.removeAttribute(
                    'readonly'); commentInput.addEventListener('input', function() {
                        btnComment.disabled = !commentInput.value.trim();
                    });

                    document.getElementById('commentForm').addEventListener('submit', function(e) {
                        e.preventDefault();
                        const text = commentInput.value.trim();
                        if (!text) return;
                        const html = '<div class="watch-comment">' +
                            '<div class="channel-avatar">YOU</div>' +
                            '<div>' +
                            '<div class="watch-comment-head"><span class="watch-comment-name">You</span><span class="watch-comment-ago">Just now</span></div>' +
                            '<p class="watch-comment-body">' + text.replace(/</g, '&lt;') + '</p>' +
                            '<div class="watch-comment-actions">' +
                            '<button type="button" class="cmt-like"><i class="bi bi-hand-thumbs-up"></i> <span>0</span></button>' +
                            '<button type="button" class="cmt-dislike"><i class="bi bi-hand-thumbs-down"></i></button>' +
                            '<button type="button" class="cmt-reply">Reply</button>' +
                            '</div>' +
                            '<div class="cmt-reply-box d-none"><input type="text" class="watch-comment-input" placeholder="Add a reply...">' +
                            '<button type="button" class="btn-custom btn-primary-custom cmt-reply-send" style="padding:0.35rem 0.9rem;font-size:0.8rem;">Reply</button></div>' +
                            '</div></div>';
                        document.getElementById('commentsList').insertAdjacentHTML('afterbegin', html);
                        commentInput.value = '';
                        btnComment.disabled = true;
                        commentTotal += 1;
                        document.getElementById('commentCount').textContent = String(commentTotal);
                        showToast('Comment posted');
                    });

                    document.getElementById('commentsList').addEventListener('click', function(e) {
                        const likeBtn = e.target.closest('.cmt-like');
                        const dislikeBtn = e.target.closest('.cmt-dislike');
                        const replyBtn = e.target.closest('.cmt-reply');
                        const replySend = e.target.closest('.cmt-reply-send');

                        if (likeBtn) {
                            const span = likeBtn.querySelector('span');
                            const active = likeBtn.classList.toggle('is-active');
                            let n = parseInt(span.textContent, 10) || 0;
                            span.textContent = String(active ? n + 1 : Math.max(0, n - 1));
                            likeBtn.querySelector('i').className = active ? 'bi bi-hand-thumbs-up-fill' :
                                'bi bi-hand-thumbs-up';
                        }
                        if (dislikeBtn) {
                            dislikeBtn.classList.toggle('is-active');
                            dislikeBtn.querySelector('i').className = dislikeBtn.classList.contains('is-active') ?
                                'bi bi-hand-thumbs-down-fill' : 'bi bi-hand-thumbs-down';
                        }
                        if (replyBtn) {
                            const box = replyBtn.closest('.watch-comment').querySelector('.cmt-reply-box');
                            box.classList.toggle('d-none');
                            if (!box.classList.contains('d-none')) box.querySelector('input').focus();
                        }
                        if (replySend) {
                            const box = replySend.closest('.cmt-reply-box');
                            const input = box.querySelector('input');
                            if (!input.value.trim()) return;
                            showToast('Reply posted');
                            input.value = '';
                            box.classList.add('d-none');
                        }
                    });
                })();
    </script>
@endsection
