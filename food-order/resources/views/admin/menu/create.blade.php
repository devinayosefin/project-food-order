@extends('layouts.admin')

@section('content')
<div class="content-card">
    <h2 class="content-title">Tambah Menu</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data" class="form-grid">
        @csrf
        <div class="form-left">
            <label class="form-label">Tambah Gambar Produk</label>
            
            {{-- Bagian HTML yang Diperbarui --}}
            <div class="upload-box">
                <input type="file" name="image" id="imageInput" class="file-input" required accept="image/*">
                
                {{-- Label awal untuk upload (akan disembunyikan) --}}
                <label for="imageInput" class="upload-label" id="uploadLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <span>Upload Gambar</span>
                </label>
                
                {{-- Elemen img untuk menampilkan preview (awalnya tersembunyi) --}}
                <img src="#" alt="Image Preview" id="imagePreview" class="image-preview">
            </div>
        </div>
        <div class="form-right">
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <div class="category-buttons">
                    <input type="radio" id="cat1" name="category" value="Signature Coffe Bun" checked><label for="cat1">Signature Coffe Bun</label>
                    <input type="radio" id="cat2" name="category" value="Pastry"><label for="cat2">Pastry</label>
                    <input type="radio" id="cat3" name="category" value="Coffe"><label for="cat3">Coffe</label>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="form-label">Nama Menu</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="price" class="form-label">Harga</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="form-group">
                <label for="stock" class="form-label">Jumlah Stok</label>
                <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock') }}" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-submit">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection

{{-- Tambahkan blok JavaScript di sini --}}
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ambil elemen-elemen yang dibutuhkan
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const uploadLabel = document.getElementById('uploadLabel');

    // Tambahkan event listener saat file dipilih
    imageInput.addEventListener('change', function(event) {
        // Pastikan ada file yang dipilih
        if (event.target.files && event.target.files[0]) {
            const file = event.target.files[0];
            
            // Buat URL sementara untuk file gambar yang dipilih
            const reader = new FileReader();
            reader.onload = function(e) {
                // Tampilkan gambar di elemen preview
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; // Tampilkan elemen img
                
                // Sembunyikan label "Upload Gambar"
                uploadLabel.style.display = 'none';
            };
            
            // Baca file sebagai Data URL
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush