@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-800">Pilihan Kategori</h2>
        <p class="text-gray-600 mt-2">Pilih kategori favorit Anda.</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <a href="{{ route('menu.category', 'roti') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
            <img src="{{ asset('images/bread.png') }}" alt="Roti" class="rounded-t-xl object-cover w-full h-64">
            <div class="p-6">
                <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-yellow-500 transition-colors duration-300">Roti</h3>
            </div>
        </a>
        <a href="{{ route('menu.category', 'pastry') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
            <img src="{{ asset('images/pastry.png') }}" alt="Pastry" class="rounded-t-xl object-cover w-full h-64">
            <div class="p-6">
                <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-yellow-500 transition-colors duration-300">Pastry</h3>
            </div>
        </a>
        <a href="{{ route('menu.category', 'coffee') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
            <img src="{{ asset('images/coffee.png') }}" alt="Coffee" class="rounded-t-xl object-cover w-full h-64">
            <div class="p-6">
                <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-yellow-500 transition-colors duration-300">Coffee</h3>
            </div>
        </a>
    </div>
</div>
@endsection