<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Roti'O</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header class="header">
        <div class="container header-content">
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Roti'O Logo">
            </div>
            <div class="title">
                <h1>Dashboard Admin</h1>
            </div>
        </div>
    </header>

    <nav class="navigation">
        <div class="container">
            <a href="{{ route('admin.menu.index') }}" class="nav-button {{ request()->routeIs('admin.menu.index', 'admin.menu.edit') ? 'active' : '' }}">Kelola Menu dan Stok</a>
            <a href="{{ route('admin.menu.create') }}" class="nav-button {{ request()->routeIs('admin.menu.create') ? 'active' : '' }}">Tambah Menu</a>
            <a href="{{ route('admin.reports.index') }}" class="nav-button {{ request()->routeIs('admin.reports.index') ? 'active' : '' }}">Laporan Penjualan</a>
        </div>
    </nav>

    <main class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>