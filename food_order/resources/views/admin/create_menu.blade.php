<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Dashboard Admin</title>
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
        <a href="{{ route('admin.menu.index') }}" class="hover:underline">Kelola Menu dan Stok</a>
        <a href="{{ route('admin.menu.create') }}" class="hover:underline bg-[#f9b233] px-4 py-2 rounded">Tambah Menu</a>
        <a href="{{ route('admin.report') }}" class="hover:underline">Laporan Penjualan</a>
    </nav>

    <main class="max-w-3xl mx-auto mt-8">
        <div class="content-card p-8">
            <h2 class="content-title text-2xl mb-6 text-center">Tambah Menu</h2>
            <form method="POST" action="{{ route('admin.menu.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                @csrf
                <!-- Upload Gambar -->
                <div>
                    <label class="block font-semibold mb-2">Tambah Gambar Produk</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg h-40 flex flex-col justify-center items-center mb-2 bg-white">
                        <span class="text-gray-400 text-2xl mb-2">&#8682;</span>
                        <span class="text-gray-400">Upload Gambar</span>
                        <input type="file" name="image" accept="image/*" class="mt-2" id="imageInput">
                        <div id="previewBox" class="hidden w-full mt-2 p-2 rounded-lg border border-gray-300 bg-white flex flex-col items-center">
                            <span id="fileName" class="block text-xs text-gray-700 mb-2"></span>
                            <img id="previewImage" src="#" alt="Preview" class="h-32 w-auto object-contain rounded-lg mx-auto">
                        </div>
                    </div>
                </div>
                <!-- Form Data Menu -->
                <div>
                    <label class="block font-semibold mb-2">Kategori</label>
                    <div class="flex gap-2 mb-4">
                        <label class="cursor-pointer">
                           <input type="radio" name="category" value="Roti" class="peer sr-only" checked>
                            <span class="inline-block px-4 py-2 rounded bg-[#8B4513] text-white font-bold peer-checked:bg-yellow-500 transition">Roti</span>
                        </label>
                        <label class="cursor-pointer">
                           <input type="radio" name="category" value="Pastry" class="peer sr-only">
                            <span class="inline-block px-4 py-2 rounded bg-[#8B4513] text-white font-bold peer-checked:bg-yellow-500 transition">Pastry</span>
                        </label>
                        <label class="cursor-pointer">
                           <input type="radio" name="category" value="Drinks" class="peer sr-only">
                            <span class="inline-block px-4 py-2 rounded bg-[#8B4513] text-white font-bold peer-checked:bg-yellow-500 transition">Drinks</span>
                        </label>
                    </div>
                    <label class="block font-semibold mb-1" for="name">Nama Menu</label>
                    <input type="text" name="name" id="name" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 font-sans" required>
                    <label class="block font-semibold mb-1" for="description">Deskripsi Menu (Optional)</label>
                    <textarea name="description" id="description" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 font-sans" placeholder="Tulis deskripsi menu di sini..."></textarea>
                    <label class="block font-semibold mb-1" for="price">Harga</label>
                    <input type="number" name="price" id="price" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 font-sans" required>
                    <label class="block font-semibold mb-1" for="stock">Jumlah Stok</label>
                    <input type="number" name="stock" id="stock" class="w-full px-4 py-2 border border-gray-300 rounded mb-4 font-sans" required>
                    <button type="submit" class="btn btn-submit-small w-full py-3 rounded font-bold text-lg bg-[#8B4513] text-white hover:bg-[#a05a2c] transition">Simpan</button>
                </div>
            </form>
        </div>
    </main>
<script>
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const [file] = e.target.files;
        const preview = document.getElementById('previewImage');
        const previewBox = document.getElementById('previewBox');
        const fileName = document.getElementById('fileName');
        if (file) {
            preview.src = URL.createObjectURL(file);
            fileName.textContent = file.name;
            previewBox.classList.remove('hidden');
        } else {
            preview.src = '#';
            fileName.textContent = '';
            previewBox.classList.add('hidden');
        }
    });
</script>
</body>
</html>
