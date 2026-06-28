<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu - Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#e7d6c6] font-sans">
    <!-- Header -->
    <header class="bg-yellow-500 text-gray-800 p-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Roti'O Logo" class="h-8 w-auto">
            <span class="font-bold text-lg">Roti'O</span>
        </div>
        <span class="font-bold text-lg">Dashboard Admin</span>
    </header>

    <!-- Navbar -->
    <nav class="bg-[#8B4513] text-white flex gap-4 px-8 py-3 font-semibold">
    <a href="{{ route('admin.menu.index') }}" class="hover:underline">Kelola Menu dan Stok</a>
    <a href="{{ route('admin.menu.create') }}" class="hover:underline bg-[#f9b233] px-4 py-2 rounded">Tambah Menu</a>
    <a href="{{ route('admin.report') }}" class="hover:underline">Laporan Penjualan</a>
    </nav>

    <main class="max-w-2xl mx-auto mt-8">
        <div class="content-card p-8">
            <h2 class="content-title text-2xl mb-6 text-center">Edit Menu dan Stok</h2>
            <form method="POST" action="{{ route('admin.menu.update', $menu->menu_id ?? 1) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                <!-- Gambar Saat Ini -->
                <div class="mb-4 text-center">
                    <span class="block font-semibold mb-2">Gambar Saat Ini</span>
                    <img src="{{ asset('images/' . ($menu->image ?? 'kopi-hazelnut.png')) }}" alt="Menu Image" class="h-32 mx-auto rounded mb-2">
                    <span class="block text-lg">{{ $menu->name ?? 'Kopi Hazelnut' }}</span>
                </div>
                <!-- Kategori -->
                <div>
                    <label class="block font-semibold mb-1" for="category">Kategori</label>
                    <select name="category" id="category" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 font-sans" required>
                        <option value="Roti" {{ $menu->category == 'Roti' ? 'selected' : '' }}>Roti</option>
                        <option value="Pastry" {{ $menu->category == 'Pastry' ? 'selected' : '' }}>Pastry</option>
                        <option value="Drinks" {{ $menu->category == 'Drinks' ? 'selected' : '' }}>Drinks</option>
                    </select>
                </div>
                <!-- Nama Menu -->
                <div>
                    <label class="block font-semibold mb-1" for="name">Nama Menu</label>
                    <input type="text" name="name" id="name" value="{{ $menu->name }}" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 font-sans" required>
                </div>
                <!-- Deskripsi Menu (Optional) -->
                <div>
                    <label class="block font-semibold mb-1" for="description">Deskripsi Menu (Optional)</label>
                    <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 font-sans">{{ $menu->description }}</textarea>
                </div>
                <!-- Harga -->
                <div>
                    <label class="block font-semibold mb-1" for="price">Harga</label>
                    <input type="number" name="price" id="price" value="{{ $menu->price ?? 18000 }}" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#a05a2c] font-sans" required>
                </div>
                <!-- Jumlah Stok -->
                <div>
                    <label class="block font-semibold mb-1" for="stock">Jumlah Stok</label>
                    <input type="number" name="stock" id="stock" value="{{ $menu->stock ?? 15 }}" class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-[#a05a2c] font-sans" required>
                </div>
                <!-- Perbarui Gambar (Optional) -->
                <div>
                    <label class="block font-semibold mb-1" for="image">Perbarui Gambar (Optional)</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded font-sans">
                </div>
                <button type="submit" class="btn btn-submit-small w-full py-3 rounded font-bold text-lg bg-[#a05a2c] text-white hover:bg-[#8B4513] transition">Simpan</button>
            </form>
        </div>
    </main>
</body>
</html>
