<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Kelola Menu dan Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e7d6c6] font-sans">


    <!-- Header -->
    <header class="bg-yellow-500 text-gray-800 p-4 flex justify-end items-center shadow-lg">
        <nav class="flex gap-4 items-center">
            <a href="{{ route('admin.menu.index') }}" class="hover:underline font-semibold">Dashboard Admin</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:underline ml-4 font-semibold">Logout</button>
            </form>
        </nav>
    </header>
    <!-- Navbar -->
    <nav class="bg-[#8B4513] text-white flex gap-4 px-8 py-3 font-semibold">
    <a href="{{ route('admin.menu.index') }}" class="hover:underline bg-[#f9b233] px-4 py-2 rounded">Kelola Menu dan Stok</a>
    <a href="{{ route('admin.menu.create') }}" class="hover:underline">Tambah Menu</a>
    <a href="{{ route('admin.report') }}" class="hover:underline">Laporan Penjualan</a>
    </nav>

    <main class="max-w-3xl mx-auto mt-8 p-6 bg-white rounded-lg shadow">
        <!-- Alert Success -->
        @if(session('success'))
        <div class="mb-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                {{ session('success') }}
            </div>
        </div>
        @endif
        <!-- Judul -->
        <h2 class="font-bold text-2xl text-[#a05a2c] mb-6 text-center">Kelola Menu dan Stok</h2>
        <!-- Tabel Menu -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-[#f8f5f2] rounded-lg">
                <thead>
                    <tr class="bg-[#f9b233] text-white">
                        <th class="py-3 px-4 text-left rounded-tl-lg">Nama Menu</th>
                        <th class="py-3 px-4 text-left">Jumlah Stok</th>
                        <th class="py-3 px-4 text-left rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($menus as $menu)
                    <tr class="border-b">
                        <td class="py-3 px-4 flex items-center gap-2">
                            <img src="{{ asset('images/' . $menu->image) }}" alt="{{ $menu->name }}" class="h-8 w-8 rounded">
                            {{ $menu->name }}
                        </td>
                        <td class="py-3 px-4">{{ $menu->stock }}</td>
                        <td class="py-3 px-4 flex gap-2">
                            <a href="{{ route('admin.menu.edit', $menu->menu_id) }}" class="bg-[#f9b233] text-white px-4 py-2 rounded font-bold hover:bg-yellow-600 transition">Edit</a>
                            <form action="{{ route('admin.menu.destroy', $menu->menu_id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-[#a05a2c] text-white px-4 py-2 rounded font-bold hover:bg-[#8B4513] transition">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
