@extends('layouts.admin')

@section('content')
<div class="content-card">
    <h2 class="content-title">Kelola Menu dan Stok</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-header">
        <div class="header-item" style="flex: 3;">Nama menu</div>
        <div class="header-item" style="flex: 1;">Jumlah Stok</div>
        <div class="header-item" style="flex: 2;">Aksi</div>
    </div>

    @forelse ($menus as $menu)
        <div class="table-row">
            <div class="row-item" style="flex: 3;">
                <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}" class="menu-image-thumb">
                <span>{{ $menu->name }}</span>
            </div>
            <div class="row-item" style="flex: 1;">
                {{ $menu->stock }}
            </div>
            <div class="row-item" style="flex: 2;">
                <a href="{{ route('admin.menu.edit', $menu->menu_id) }}" class="btn btn-edit">Edit</a>
                <form action="{{ route('admin.menu.destroy', $menu->menu_id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-delete">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="table-row">
            <p>Belum ada data menu.</p>
        </div>
    @endforelse
</div>
@endsection