@extends('layouts.admin')

@section('content')
<div class="content-card">
    <h2 class="content-title">Edit Menu dan Stok</h2>

    <form action="{{ route('admin.menu.update', $menu->menu_id) }}" method="POST" enctype="multipart/form-data" class="form-grid">
        @csrf
        @method('PUT')
        <div class="form-left">
             <label class="form-label">Gambar Saat Ini</label>
            <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="edit-image">
            <p class="menu-name-edit">{{ $menu->name }}</p>
        </div>
        <div class="form-right">
             <div class="form-group">
                <label for="price" class="form-label">Harga</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', $menu->price) }}" required>
            </div>
            <div class="form-group">
                <label for="stock" class="form-label">Jumlah Stok</label>
                <input type="number" id="stock" name="stock" class="form-control" value="{{ old('stock', $menu->stock) }}" required>
            </div>
            <div class="form-group">
                <label for="image" class="form-label">Perbarui Gambar (Opsional)</label>
                <div class="upload-box-edit">
                     <input type="file" name="image" id="image" class="form-control-file">
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-submit">Simpan</button>
            </div>
        </div>
    </form>
</div>
@endsection