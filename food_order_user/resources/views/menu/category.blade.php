@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-extrabold text-gray-800">Menu {{ ucfirst($category) }}</h1>
        <p class="mt-2 text-lg text-gray-600">Pilih menu favorit Anda dan tambahkan ke keranjang.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($menus as $menu)
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2">
            <img src="{{ asset('images/' . $menu->image) }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover rounded-t-xl">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800">{{ $menu->name }}</h3>
                <p class="mt-1 text-gray-600">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ $menu->description }}</p>
                <div class="mt-4 flex items-center justify-between">
                    <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                        @csrf
                        {{-- Menggunakan $menu->menu_id karena itu adalah primary key di database Anda --}}
                        <input type="hidden" name="menu_id" value="{{ $menu->menu_id }}">
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full transition-colors duration-300">
                            + Tambahkan ke Keranjang
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection