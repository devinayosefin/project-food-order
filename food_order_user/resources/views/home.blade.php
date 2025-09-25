@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-[#F4EBE0]">
    {{-- Bagian Atas dengan Gambar Landing --}}
    <div class="w-full">
        <img src="{{ asset('images/landing.png') }}" alt="Roti'O Landing Page" class="w-full h-auto object-cover">
    </div>

    {{-- Bagian Kategori Menu --}}
    <section class="py-16 text-white bg-[#8B4513]">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-12">Yuk pilih menu pilihanmu</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="{{ route('menu.category', 'roti') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/bread.png') }}" alt="Roti" class="rounded-t-xl object-cover w-full h-64">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-red-500 transition-colors duration-300">Roti</h3>
                    </div>
                </a>
                <a href="{{ route('menu.category', 'pastry') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/pastry.png') }}" alt="Pastry" class="rounded-t-xl object-cover w-full h-64">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-red-500 transition-colors duration-300">Pastry</h3>
                    </div>
                </a>
                <a href="{{ route('menu.category', 'coffee') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/coffee.png') }}" alt="Coffee" class="rounded-t-xl object-cover w-full h-64">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-red-500 transition-colors duration-300">Coffee</h3>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- Bagian Maskot yang sudah diperbarui --}}
    <section class="py-16 text-gray-800">
        <div class="container mx-auto px-6 flex flex-col items-center">
            <div class="w-full text-center mb-8">
                <img src="{{ asset('images/maskot.png') }}" alt="Roti'O Maskot" class="w-full h-auto max-w-5xl md:max-w-6xl lg:max-w-7xl mx-auto">
            </div>
            <div class="w-full text-center md:text-left">
                <h2 class="text-5xl font-bold leading-tight mb-4">Tasty until The Last Bite</h2>
                <p class="text-xl text-gray-700 mb-8">By Group H</p>
            </div>
        </div>
    </section>
</div>
@endsection
