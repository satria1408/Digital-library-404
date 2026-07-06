<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Console - Sistem Informasi Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        /* Konfigurasi Dasar Aplikasi - Developer Mode */
        :root {
            --app-surface-bg: #f8fafc;
            --app-text-main: #212529;
            --navigation-bar-bg: #1e293b; /* Slate Dark untuk topbar developer */
            --navigation-text: #ffffff;
            --navigation-dimmed: rgba(255, 255, 255, 0.70);
            --navigation-divider: rgba(255, 255, 255, 0.12);
            --drawer-bg: #0f172a; /* Warna dark premium untuk sidebar */
            --drawer-text: #f8fafc;
        }

        body.dark-mode {
            --app-surface-bg: #0f0f12;
            --app-text-main: #f3f4f6;
            --drawer-bg: #16161a; 
            --drawer-text: #f3f4f6;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--app-surface-bg) !important;
            color: var(--app-text-main) !important;
            transition: background-color 0.25s ease, color 0.25s ease;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        .base-layout-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: var(--app-surface-bg) !important;
        }

        .dynamic-view-viewport {
            flex: 1;
        }

        .custom-app-nav {
            margin: 0 !important;
            border-radius: 0 !important;
            border-bottom: 1px solid var(--navigation-divider);
            transition: background-color 0.3s ease;
            background-color: var(--navigation-bar-bg) !important;
        }

        /* Variasi warna tema bar atas developer */
        .bg-theme-dev-dashboard { background-color: #1e293b !important; }
        .bg-theme-dev-suggestions { background-color: #0d6efd !important; }

        body.dark-mode .custom-app-nav {
            background-color: #16161a !important;
        }

        .brand-ident, .nav-info-text, #liveClockDisplay {
            color: var(--navigation-text) !important;
        }

        /* FIX DARK MODE UNTUK TULISAN DASHBOARD ANAK */
        body.dark-mode .text-dark,
        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode .card h4,
        body.dark-mode .card h5 {
            color: #ffffff !important;
        }

        body.dark-mode .text-muted, body.dark-mode .text-muted-dev {
            color: #9ca3af !important;
        }

        body.dark-mode .card {
            background-color: #16161a !important;
            border-color: #2d2d34 !important;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode .bg-white {
            background-color: #16161a !important;
        }

        /* Navigasi Menu (Sidebar Drawer) */
        .custom-drawer {
            background-color: var(--drawer-bg) !important;
            color: var(--drawer-text) !important;
            backdrop-filter: blur(10px);
        }

        /* Floating glassmorphism box untuk profil */
        .drawer-profile-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .drawer-profile-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.15);
        }

        /* Sub-header navigasi kelompok menu */
        .menu-section-label {
            font-size: 0.68rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.35);
            padding-left: 12px;
            margin-bottom: 8px;
            display: block;
        }

        /* Item menu link */
        .custom-drawer .nav-link {
            color: rgba(255, 255, 255, 0.7) !important;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 10px;
            padding: 10px 14px !important;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Efek hover item menu */
        .custom-drawer .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.05) !important;
            transform: translateX(4px);
        }

        /* State tombol link menu saat aktif */
        .custom-drawer .nav-link.active {
            color: #ffffff !important;
            background: linear-gradient(135deg, #1e293b, #334155) !important;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(30, 41, 59, 0.25);
        }

        /* Penyesuaian warna aktif halaman saran */
        .custom-drawer .nav-link.active-suggestions {
            background: linear-gradient(135deg, #0d6efd, #0a58ca) !important;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
        }
    </style>
</head>
<body>
    <div class="base-layout-container">
        @auth
        <nav class="navbar navbar-expand-lg custom-app-nav navbar-dark shadow-sm
            {{ request()->routeIs('developer.dashboard') ? 'bg-theme-dev-dashboard' : '' }}
            {{ request()->routeIs('developer.suggestions.*') ? 'bg-theme-dev-suggestions' : '' }}
        ">
            <div class="container">
                <!-- Hamburger menu untuk mobile view -->
                <button class="btn btn-link text-white p-0 border-0 me-3 d-lg-none shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#appMobileDrawer">
                    <i class="bi bi-text-left fs-2"></i>
                </button>

                <a class="brand-ident navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('developer.dashboard') }}">
                    <i class="bi bi-terminal-fill fs-5 text-warning"></i> DevConsole
                </a>

                <div class="collapse navbar-collapse" id="desktopNavRegistry">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('developer.dashboard') ? 'active' : '' }}" href="{{ route('developer.dashboard') }}">Dev Panel</a>
                        </li>
                    </ul>
                </div>

                <div class="d-flex align-items-center gap-3 ms-auto">
                    <button id="themeSwitcherToggle" class="btn btn-link p-0 border-0 text-white shadow-none" onclick="switchAppTheme()" title="Ganti Mode Visual">
                        <i id="themeToggleStateIcon" class="bi bi-moon-stars-fill fs-5"></i>
                    </button>

                    <span id="liveClockDisplay" class="d-none d-sm-inline small fw-medium text-opacity-75">00/00/0000 | 00:00:00</span>

                    <span class="nav-info-text d-none d-md-inline small">
                        <i class="bi bi-shield-check text-warning me-1"></i> {{ auth()->user()->nama_lengkap ?? auth()->user()->username }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm px-2 py-1 border-0" title="Keluar Sistem">
                            <i class="bi bi-power fs-6"></i>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Sidebar Drawer (Offcanvas) -->
        <div class="offcanvas offcanvas-start custom-drawer border-0 shadow-lg" tabindex="-1" id="appMobileDrawer" style="width: 280px;">
            <div class="offcanvas-header border-bottom border-secondary border-opacity-10 py-3.5 px-4">
                <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center gap-2.5" style="font-size: 1.1rem; letter-spacing: -0.02em;">
                    <i class="bi bi-cpu-fill text-warning"></i> Root Developer
                </h5>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" style="font-size: 0.8rem;"></button>
            </div>

            <div class="offcanvas-body px-3 py-4">
                <!-- Profile Glassmorphism Card -->
                <div class="drawer-profile-card p-3 d-flex align-items-center gap-3 mb-4">
                    <div class="text-white rounded-3 d-flex align-items-center justify-content-center fw-extrabold shadow-sm" style="width: 46px; height: 46px; min-width: 46px; font-size: 1.2rem; background: linear-gradient(135deg, #eab308, #ca8a04) !important;">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'D', 0, 1)) }}
                    </div>
                    <div class="overflow-hidden">
                        <span class="fw-bold d-block text-truncate text-white" style="font-size: 0.9rem;" title="{{ auth()->user()->nama_lengkap ?? auth()->user()->username }}">
                            {{ auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'Developer Account' }}
                        </span>
                        <div class="d-flex align-items-center gap-1.5 mt-0.5">
                            <span class="badge bg-warning text-dark rounded-pill px-2 py-0.5" style="font-size: 0.6rem; font-weight: 700; letter-spacing: 0.02em;">CORE</span>
                            <span class="text-white-50 small text-uppercase" style="font-size: 0.65rem; font-weight: 600;">&bull; {{ auth()->user()->role ?? 'Developer' }}</span>
                        </div>
                    </div>
                </div>

                <div class="menu-navigation-wrapper">
                    <span class="menu-section-label">Menu Utama</span>
                    <ul class="nav nav-pills flex-column gap-1.5 mb-4">
                        <li class="nav-item">
                            <a href="{{ route('developer.dashboard') }}" class="nav-link {{ request()->routeIs('developer.dashboard') ? 'active' : '' }}">
                                <i class="bi bi-grid-1x2-fill fs-5"></i> Dashboard
                            </a>
                        </li>
                    </ul>

                    <span class="menu-section-label">Manajemen Sistem</span>
                    <ul class="nav nav-pills flex-column gap-1.5">
                        <li class="nav-item">
                            <a href="{{ route('developer.suggestions.index') }}" class="nav-link {{ request()->routeIs('developer.suggestions.*') ? 'active active-suggestions' : '' }}">
                                <i class="bi bi-envelope-exclamation-fill fs-5"></i> Kotak Saran & Keluhan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        @endauth

        <div class="dynamic-view-viewport">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function renderLiveDateTime() {
            const currentDateInstance = new Date();
            const containerElement = document.getElementById('liveClockDisplay');
            if(containerElement){
                containerElement.innerHTML = currentDateInstance.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}) + ' | ' + currentDateInstance.toLocaleTimeString('id-ID');
            }
        }
        setInterval(renderLiveDateTime, 1000);
        renderLiveDateTime();

        function switchAppTheme() {
            document.body.classList.toggle('dark-mode');
            const contextualIcon = document.getElementById('themeToggleStateIcon');
            if (document.body.classList.contains('dark-mode')) {
                if(contextualIcon) contextualIcon.className = 'bi bi-sun-fill fs-5 text-warning';
            } else {
                if(contextualIcon) contextualIcon.className = 'bi bi-moon-stars-fill fs-5 text-white';
            }
        }
    </script>

    @stack('scripts')
</body>
</html>