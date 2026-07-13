<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin - Sarana Pengaduan Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --sidebar-width: 260px;
            --bg-main: #f8fafc;
            --text-main: #1e293b;
            --sidebar-bg: #0f172a;
            --sidebar-card: #1e293b;
            --sidebar-text: #94a3b8;
            
            /* Konten teks adaptif light mode */
            --content-title: #1e293b;
            --content-muted: #64748b;
            --card-bg: #ffffff;
            --card-text: #1e293b;
            --logout-btn-text: #64748b;
        }

        body.dark-mode {
            --bg-main: #0f172a;
            --text-main: #f8fafc;
            --sidebar-bg: #020617;
            --sidebar-card: #0f172a;
            
            /* Konten teks adaptif dark mode (Putih) */
            --content-title: #ffffff;
            --content-muted: #94a3b8;
            --card-bg: #1e293b;
            --card-text: #ffffff;
            --logout-btn-text: #94a3b8;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: var(--bg-main) !important;
            color: var(--text-main) !important;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: var(--sidebar-width);
            background-color: var(--sidebar-bg);
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.2s ease;
        }

        .admin-content-viewport {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .admin-top-bar {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            height: 65px;
            display: flex;
            align-items: center;
            padding: 0 1.5rem;
        }

        body.dark-mode .admin-top-bar {
            background-color: rgba(15, 23, 42, 0.8);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .admin-profile-box {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 8px;
        }

        .sidebar-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.3);
            padding: 0 0.75rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .admin-sidebar .nav-link {
            color: var(--sidebar-text) !important;
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 6px;
            padding: 9px 12px !important;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.15s ease;
        }

        .admin-sidebar .nav-link:hover {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.04);
        }

        .admin-sidebar .nav-link.active {
            color: #ffffff !important;
            background: #0ea5e9 !important;
            font-weight: 600;
        }

        /* Sinkronisasi Tombol Logout */
        .btn-logout-custom {
            color: var(--logout-btn-text) !important;
            background: transparent;
            transition: all 0.2s ease;
        }

        .btn-logout-custom:hover {
            color: #ffffff !important;
            background: rgba(239, 68, 68, 0.1);
        }

        /* Penerapan Teks Adaptif Global */
        .adaptive-title {
            color: var(--content-title) !important;
        }

        .adaptive-muted {
            color: var(--content-muted) !important;
        }

        .adaptive-card {
            background-color: var(--card-bg) !important;
            color: var(--card-text) !important;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            .admin-sidebar.show-mobile {
                margin-left: 0;
                position: fixed;
                z-index: 1040;
                height: 100vh;
            }
        }
    </style>
</head>
<body>

<div class="admin-wrapper">
    <aside class="admin-sidebar p-3" id="adminSidebarViewport">
        <div class="d-flex align-items-center gap-2 px-2 py-3 mb-3 border-bottom border-secondary border-opacity-10">
            <i class="bi bi-shield-fill-check text-info fs-4"></i>
            <span class="fw-bold text-white fs-5 tracking-tight">SI-Pengaduan</span>
        </div>

        <div class="admin-profile-box p-3 d-flex align-items-center gap-3 mb-4">
            <div class="bg-info text-dark rounded d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; min-width: 40px;">
                {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'A', 0, 1)) }}
            </div>
            <div class="overflow-hidden">
                <span class="fw-semibold d-block text-truncate text-white small">
                    {{ auth()->user()->nama_lengkap ?? 'Administrator' }}
                </span>
                <span class="text-info text-uppercase fw-bold" style="font-size: 0.65rem;">
                    {{ auth()->user()->username }}
                </span>
            </div>
        </div>

        <div class="menu-navigation-wrapper flex-grow-1">
            <span class="sidebar-section-title">Ringkasan Sistem</span>
            <ul class="nav nav-pills flex-column gap-1 mb-4">
                <li class="nav-item">
                    <a href="{{ route('admin.complaints.dashboard') }}" class="nav-link {{ request()->routeIs('admin.complaints.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 fs-5"></i> Dashboard Overview
                    </a>
                </li>
            </ul>

            <span class="sidebar-section-title">Manajemen Laporan</span>
            <ul class="nav nav-pills flex-column gap-1">
                <li class="nav-item">
                    <a href="{{ route('admin.complaints.index') }}" class="nav-link {{ request()->routeIs('admin.complaints.index') || request()->routeIs('admin.complaints.show') ? 'active' : '' }}">
                        <i class="bi bi-inboxes-fill fs-5"></i> Antrean Pengaduan
                    </a>
                </li>
            </ul>
        </div>

        <!-- Tombol Aksi Keluar Diubah Menjadi Logout Adaptif -->
        <div class="pt-3 border-top border-secondary border-opacity-10">
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-logout-custom w-100 text-start d-flex align-items-center gap-2 border-0">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="admin-content-viewport">
        <header class="admin-top-bar justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link text-dark p-0 d-lg-none shadow-none text-opacity-75" type="button" onclick="toggleMobileSidebar()">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <span id="adminLiveClock" class="small fw-semibold adaptive-muted d-none d-sm-inline"></span>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link p-0 border-0 adaptive-muted shadow-none" onclick="toggleVisualMode()" title="Ubah Visual Mode">
                    <i id="visualModeIcon" class="bi bi-moon-fill fs-5"></i>
                </button>
                <span class="small adaptive-muted fw-medium d-none d-md-inline">
                    Hak Akses: <span class="badge bg-secondary-subtle text-secondary px-2 py-1 text-uppercase">{{ auth()->user()->role }}</span>
                </span>
            </div>
        </header>

        <main class="dynamic-view-viewport p-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function updateAdminTime() {
        const timeContainer = document.getElementById('adminLiveClock');
        if(timeContainer) {
            const now = new Date();
            timeContainer.innerHTML = now.toLocaleDateString('id-ID', {day:'2-digit', month:'long', year:'numeric'}) + ' | ' + now.toLocaleTimeString('id-ID');
        }
    }
    setInterval(updateAdminTime, 1000);
    updateAdminTime();

    function toggleVisualMode() {
        document.body.classList.toggle('dark-mode');
        const icon = document.getElementById('visualModeIcon');
        if (document.body.classList.contains('dark-mode')) {
            if(icon) icon.className = 'bi bi-sun-fill fs-5 text-warning';
        } else {
            if(icon) icon.className = 'bi bi-moon-fill fs-5 text-muted';
        }
    }

    function toggleMobileSidebar() {
        const sidebar = document.getElementById('adminSidebarViewport');
        if(sidebar) {
            sidebar.classList.toggle('show-mobile');
        }
    }
</script>
</body>
</html>