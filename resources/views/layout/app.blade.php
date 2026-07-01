<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
    /* Konfigurasi Dasar Aplikasi */
    :root {
        --app-surface-bg: #f8fafc;
        --app-text-main: #212529;
        --navigation-bar-bg: #0d6efd;
        --navigation-text: #ffffff;
        --navigation-dimmed: rgba(255, 255, 255, 0.70);
        --navigation-divider: rgba(255, 255, 255, 0.12);
        --drawer-bg: #1e293b;
        --drawer-text: #f8fafc;
    }

    body.dark-mode {
        --app-surface-bg: #121212;
        --app-text-main: #f3f4f6;
        --drawer-bg: #0f172a;
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
    }

    /* Variasi warna tema bar atas per halaman admin */
    .bg-theme-dashboard     { background-color: #0d6efd !important; }
    .bg-theme-books         { background-color: #6f42c1 !important; }
    .bg-theme-users         { background-color: #0d9488 !important; }
    .bg-theme-transactions  { background-color: #198754 !important; }
    .bg-theme-dendas        { background-color: #f59e0b !important; }
    .bg-theme-security      { background-color: #dc3545 !important; }

    body.dark-mode .custom-app-nav {
        background-color: #1f2937 !important;
    }

    .brand-ident, .nav-info-text, #liveClockDisplay {
        color: var(--navigation-text) !important;
    }

    /* FIX DARK MODE UNTUK TULISAN */
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

    body.dark-mode .text-muted {
        color: #9ca3af !important;
    }

    body.dark-mode .card {
        background-color: #1f2937 !important;
        border-color: #374151 !important;
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.25) !important;
    }

    body.dark-mode .bg-white {
        background-color: #1f2937 !important;
    }

    /* ==========================================================================
       DRAWER SIDEBAR PREMIUM
       ========================================================================== */
    .custom-drawer {
        background-color: var(--drawer-bg) !important;
        color: var(--drawer-text) !important;
        backdrop-filter: blur(10px);
    }

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

    .custom-drawer .nav-link:hover {
        color: #ffffff !important;
        background: rgba(255, 255, 255, 0.05) !important;
        transform: translateX(4px);
    }

    .custom-drawer .nav-link.active {
        color: #ffffff !important;
        background: linear-gradient(135deg, #0d6efd, #0a58ca) !important;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
    }

    .custom-drawer .nav-link.active-books {
        background: linear-gradient(135deg, #6f42c1, #59339d) !important;
        box-shadow: 0 4px 12px rgba(111, 66, 193, 0.25);
    }
    .custom-drawer .nav-link.active-users {
        background: linear-gradient(135deg, #0d9488, #0b7a70) !important;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
    }
    .custom-drawer .nav-link.active-transactions {
        background: linear-gradient(135deg, #198754, #146c43) !important;
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.25);
    }
    .custom-drawer .nav-link.active-dendas {
        background: linear-gradient(135deg, #f59e0b, #d97706) !important;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
        color: #212529 !important;
    }
    .custom-drawer .nav-link.active-security {
        background: linear-gradient(135deg, #dc3545, #b02a37) !important;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.25);
    }
</style>

</head>
<body>
    <div class="base-layout-container">
    @auth

    <nav class="navbar navbar-expand-lg custom-app-nav navbar-dark shadow-sm
        {{ Request::routeIs('admin.dashboard') ? 'bg-theme-dashboard' : '' }}
        {{ Request::routeIs('books.*') ? 'bg-theme-books' : '' }}
        {{ Request::routeIs('users.*') ? 'bg-theme-users' : '' }}
        {{ Request::routeIs('transactions.*') ? 'bg-theme-transactions' : '' }}
        {{ Request::routeIs('dendas.*') ? 'bg-theme-dendas' : '' }}
        {{ Request::routeIs('security.logs.*') ? 'bg-theme-security' : '' }}
    ">
        <div class="container-fluid px-3">
            <button class="btn btn-link text-white p-0 border-0 me-3 d-lg-none shadow-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#appMobileDrawer">
                <i class="bi bi-text-left fs-2"></i>
            </button>

            <a class="brand-ident navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-book-half fs-5"></i> DigiLib <span class="badge bg-light text-primary ms-1" style="font-size:.6rem;">Admin</span>
            </a>

            <div class="collapse navbar-collapse" id="desktopNavRegistry">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">
                            <i class="bi bi-book-half me-1"></i> Kelola Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">
                            <i class="bi bi-people-fill me-1"></i> Anggota
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('transactions.*') ? 'active' : '' }}" href="{{ route('transactions.index') }}">
                            <i class="bi bi-arrow-left-right me-1"></i> Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('dendas.*') ? 'active' : '' }}" href="{{ route('dendas.index') }}">
                            <i class="bi bi-cash-stack me-1"></i> Denda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::routeIs('security.logs.*') ? 'active' : '' }}" href="{{ route('security.logs.index') }}">
                            <i class="bi bi-shield-lock-fill me-1"></i> Security Log
                        </a>
                    </li>
                </ul>
            </div>

            <div class="d-flex align-items-center gap-3 ms-auto">
                <button id="themeSwitcherToggle" class="btn btn-link p-0 border-0 text-white shadow-none" onclick="switchAppTheme()" title="Ganti Mode Visual">
                    <i id="themeToggleStateIcon" class="bi bi-moon-stars-fill fs-5"></i>
                </button>

                <span id="liveClockDisplay" class="d-none d-sm-inline small fw-medium text-opacity-75">00/00/0000 | 00:00:00</span>

                <div class="dropdown">
                    <button class="btn btn-outline-light btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->nama_lengkap }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li>
                            <span class="dropdown-item-text">
                                <strong>{{ ucfirst(Auth::user()->role) }}</strong>
                            </span>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start custom-drawer border-0 shadow-lg" tabindex="-1" id="appMobileDrawer" style="width: 280px;">
        <div class="offcanvas-header border-bottom border-secondary border-opacity-10 py-3 px-4">
            <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center gap-2" style="font-size: 1.1rem; letter-spacing: -0.02em;">
                <i class="bi bi-shield-lock-fill text-primary"></i> Portal Admin
            </h5>
            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" style="font-size: 0.8rem;"></button>
        </div>

        <div class="offcanvas-body px-3 py-4">

            <div class="drawer-profile-card p-3 d-flex align-items-center gap-3 mb-4">
                <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 46px; height: 46px; min-width: 46px; font-size: 1.2rem; background: linear-gradient(135deg, #0d6efd, #0b5ed7) !important;">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? 'A', 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <span class="fw-bold d-block text-truncate text-white" style="font-size: 0.9rem;" title="{{ Auth::user()->nama_lengkap }}">
                        {{ Auth::user()->nama_lengkap }}
                    </span>
                    <div class="d-flex align-items-center gap-1 mt-1">
                        <span class="badge bg-success-subtle text-success rounded-pill px-2 py-0" style="font-size: 0.6rem; font-weight: 700;">ONLINE</span>
                        <span class="text-white-50 small text-uppercase" style="font-size: 0.65rem; font-weight: 600;">• {{ ucfirst(Auth::user()->role ?? 'Admin') }}</span>
                    </div>
                </div>
            </div>

            <div class="menu-navigation-wrapper">
                <span class="menu-section-label">Menu Utama</span>
                <ul class="nav nav-pills flex-column gap-1 mb-4">
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2 fs-5"></i> Dashboard
                        </a>
                    </li>
                </ul>

                <span class="menu-section-label">Manajemen Data</span>
                <ul class="nav nav-pills flex-column gap-1 mb-4">
                    <li class="nav-item">
                        <a href="{{ route('books.index') }}" class="nav-link {{ Request::routeIs('books.*') ? 'active active-books' : '' }}">
                            <i class="bi bi-book-half fs-5"></i> Kelola Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.index') }}" class="nav-link {{ Request::routeIs('users.*') ? 'active active-users' : '' }}">
                            <i class="bi bi-people-fill fs-5"></i> Anggota
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('transactions.index') }}" class="nav-link {{ Request::routeIs('transactions.*') ? 'active active-transactions' : '' }}">
                            <i class="bi bi-arrow-left-right fs-5"></i> Transaksi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dendas.index') }}" class="nav-link {{ Request::routeIs('dendas.*') ? 'active active-dendas' : '' }}">
                            <i class="bi bi-cash-stack fs-5"></i> Denda
                        </a>
                    </li>
                </ul>

                <span class="menu-section-label">Keamanan</span>
                <ul class="nav nav-pills flex-column gap-1">
                    <li class="nav-item">
                        <a href="{{ route('security.logs.index') }}" class="nav-link {{ Request::routeIs('security.logs.*') ? 'active active-security' : '' }}">
                            <i class="bi bi-shield-lock-fill fs-5"></i> Security Log
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function renderLiveDateTime() {
        const currentDateInstance = new Date();
        const containerElement = document.getElementById('liveClockDisplay');
        if (containerElement) {
            containerElement.innerHTML = currentDateInstance.toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'}) + ' | ' + currentDateInstance.toLocaleTimeString('id-ID');
        }
    }
    setInterval(renderLiveDateTime, 1000);
    renderLiveDateTime();

    function switchAppTheme() {
        document.body.classList.toggle('dark-mode');
        const contextualIcon = document.getElementById('themeToggleStateIcon');
        if (document.body.classList.contains('dark-mode')) {
            if (contextualIcon) contextualIcon.className = 'bi bi-sun-fill fs-5 text-warning';
        } else {
            if (contextualIcon) contextualIcon.className = 'bi bi-moon-stars-fill fs-5 text-white';
        }
    }
</script>

@stack('scripts')
</body>
</html>