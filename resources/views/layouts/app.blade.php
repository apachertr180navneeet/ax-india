<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AX India')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-play text-danger me-1"></i>AX India
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#searchCollapse">
                <i class="fas fa-search"></i>
            </button>
            <button class="navbar-toggler ms-1" type="button" data-bs-toggle="collapse" data-bs-target="#navCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="searchCollapse">
                <form class="d-flex mx-auto my-2 my-lg-0 w-100" action="{{ route('search') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="q" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="collapse navbar-collapse" id="navCollapse">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                                <img src="{{ asset(Auth::user()->profile?->avatar ?? 'images/default-avatar.png') }}" class="rounded-circle me-1" width="32" height="32" alt="">
                                <span class="d-none d-lg-inline">{{ Auth::user()->first_name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('channel', Auth::id()) }}"><i class="fas fa-user me-2"></i>My Channel</a></li>
                                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><i class="fas fa-sign-in-alt me-1"></i>Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><i class="fas fa-user-plus me-1"></i>Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-3">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
            @endif
            @yield('content')
        </div>
    </main>

    <footer class="bg-dark text-muted py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0 small">&copy; {{ date('Y') }} AX India. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
