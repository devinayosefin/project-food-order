@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-gray-800">Menu</h1>
    <p class="mt-2 text-lg text-gray-600">Hey! What would you like to try today?</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($menus as $menu)
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 transform hover:-translate-y-2">
            <img src="{{ asset('images/' . ($menu->image ?? 'bread.png')) }}" alt="{{ $menu->name }}" class="w-full h-48 object-cover rounded-t-xl">
            <div class="p-6">
                <h3 class="text-xl font-bold text-gray-800">{{ $menu->name ?? 'Roti Original' }}</h3>
                <p class="mt-1 text-gray-600">Rp{{ number_format($menu->price ?? 12000, 0, ',', '.') }}</p>
                <p class="mt-2 text-sm text-gray-500">{{ $menu->description ?? 'Roti lembut dengan aroma kopi khas Roti’O.' }}</p>
                <span class="inline-block bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold mb-2">{{ ucfirst($menu->category) }}</span>
                <div class="mt-4 flex items-center justify-between">
                    @if($menu->stock > 0)
                        <form action="{{ route('cart.add') }}" method="POST" class="w-full">
                            @csrf
                            <input type="hidden" name="menu_id" value="{{ $menu->menu_id }}">
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full transition-colors duration-300">
                                + Tambahkan ke Keranjang
                            </button>
                        </form>
                    @else
                        <span class="w-full block bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded-full text-center cursor-not-allowed">Habis</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
