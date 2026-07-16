<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'OneSchool - Dashboard Siswa' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .navbar-custom {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
        }

        .brand-text {
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(45deg, #0d6efd, #0a58ca);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .nav-link-custom {
            color: #64748b;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            border-radius: 99px;
            transition: all 0.2s ease;
        }

        .nav-link-custom:hover {
            color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

        .nav-link-custom.active {
            color: #0d6efd;
            font-weight: 600;
            background-color: rgba(13, 110, 253, 0.08);
        }

        .profile-avatar {
            width: 36px;
            height: 36px;
            object-fit: cover;
            border: 2px solid rgba(13, 110, 253, 0.2);
            transition: all 0.2s ease;
        }

        .dropdown-toggle-custom:hover .profile-avatar {
            border-color: #0d6efd;
        }

        .notif-badge {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #dc3545;
        }

        .main-wrapper {
            min-height: calc(100vh - 70px - 60px);
            padding-top: 2.5rem;
            padding-bottom: 3rem;
        }

        .footer-custom {
            background-color: #ffffff;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            font-size: 0.85rem;
            color: #64748b;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top navbar-custom py-2">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <span class="brand-text fs-4">OneSchool</span>
            </a>

            <button class="navbar-toggler border-0 p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavNav" aria-controls="navbarNavNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-3 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavNav">
                <ul class="navbar-nav mx-auto my-3 my-lg-0 gap-1">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom active" href="{{ route('siswa.complaints.index') }}">Pengaduan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="#">Perpustakaan</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-3 pt-2 pt-lg-0 border-top border-light border-lg-0">
                    <div class="dropdown">
                        <button class="btn btn-link position-relative p-2 text-secondary rounded-circle bg-light d-flex align-items-center justify-content-center" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 38px; height: 38px;">
                            <i class="bi bi-bell fs-5"></i>
                            <span class="notif-badge"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2 p-2" aria-labelledby="notifDropdown" style="width: 280px;">
                            <li class="px-2 py-1"><span class="fw-bold small text-dark d-block mb-1">Notifikasi Terbaru</span></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li>
                                <a class="dropdown-item rounded-2 p-2 text-wrap small" href="#">
                                    <span class="d-block fw-semibold text-dark">Laporan Diproses</span>
                                    <span class="text-muted text-truncate d-block" style="font-size: 11px;">Aduan AC kelas XI-RPL sedang ditangani.</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle-custom d-flex align-items-center gap-2 text-decoration-none p-0 border-0" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80" class="rounded-circle profile-avatar" alt="Avatar">
                            <span class="d-none d-lg-inline text-dark fw-semibold small">Budi Santoso</span>
                            <i class="bi bi-chevron-down text-muted small d-none d-lg-inline" style="font-size: 0.75rem;"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item small py-2 px-3" href="#"><i class="bi bi-person me-2 text-muted"></i> Profil Saya</a></li>
                            <li><a class="dropdown-item small py-2 px-3" href="#"><i class="bi bi-gear me-2 text-muted"></i> Pengaturan</a></li>
                            <li><hr class="dropdown-divider my-1"></li>
                            <li><a class="dropdown-item small py-2 px-3 text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i> Keluar</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-wrapper">
        @yield('content')
    </main>

    <footer class="footer-custom py-3 mt-auto">
        <div class="container text-center">
            <span>&copy; 2026 OneSchool Digital Platform. Hak Cipta Dilindungi.</span>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Resmi (Sudah Diperbaiki) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const navbar = document.querySelector('.navbar-custom');
            window.addEventListener('scroll', function () {
                if (window.scrollY > 20) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });
        });
    </script>
</body>
</html>