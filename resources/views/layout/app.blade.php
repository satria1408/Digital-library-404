<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body{
            margin:0;
            padding:0;
            min-height:100%;
            background:#0f172a;
        }

        .navbar{
            margin:0 !important;
            border-radius:0 !important;
        }
    </style>
</head>

<body>

    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">

            <a class="navbar-brand fw-bold" href="#">
                Perpustakaan
            </a>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav me-auto">

                    @if(Auth::user()->role == 'admin')

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
                               href="{{ route('books.index') }}">
                                Kelola Buku
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                               href="{{ route('users.index') }}">
                                Kelola Anggota
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                               href="{{ route('transactions.index') }}">
                                Transaksi
                            </a>
                        </li>

                    @endif

                    @if(Auth::user()->role == 'siswa')

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"
                               href="{{ route('siswa.dashboard') }}">
                                Dashboard & Peminjaman
                            </a>
                        </li>

                    @endif

                </ul>

                <div class="d-flex align-items-center">

                    <span class="navbar-text text-white me-3">
                        Halo,
                        <strong>{{ Auth::user()->nama_lengkap }}</strong>

                        <span class="badge bg-light text-primary ms-1">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-danger btn-sm">
                            Logout
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </nav>
    @endauth

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('scripts')

</body>
</html>