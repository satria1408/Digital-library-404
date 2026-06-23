<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Perpustakaan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @auth
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">

            <a class="navbar-brand" href="#">
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

                    {{-- ADMIN --}}
                    @if(Auth::user()->role == 'admin')

                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}"
                                href="{{ route('books.index') }}">
                                Kelola Buku
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                href="{{ route('users.index') }}">
                                Kelola Anggota
                            </a>
                        </li>

                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('transactions.*') ? 'active' : '' }}"
                                href="{{ route('transactions.index') }}">
                                Transaksi
                            </a>
                        </li>

                    @endif

                    {{-- SISWA --}}
                    @if(Auth::user()->role == 'siswa')

                        <li class="nav-item">
                            <a
                                class="nav-link {{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}"
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

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        class="d-inline">

                        @csrf

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm">
                            Logout
                        </button>

                    </form>

                </div>

            </div>

        </div>
    </nav>
    @endauth

    <div class="container">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">

                {{ session('error') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
                </button>

            </div>
        @endif

        @yield('content')

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Stack Script dari halaman lain --}}
    @stack('scripts')

</body>
</html>