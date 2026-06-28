@extends('layouts.app')

@section('content')

<div class="relative min-h-screen bg-[#F4EBE0]">
    {{-- Bagian Atas dengan Gambar Landing (Sudah Dimodifikasi) --}}
    @auth
        @if(auth()->user()->role_id != 2)
            {{-- Tampilan untuk pengguna yang sudah login (bukan kasir) --}}
            <div class="container mx-auto px-6 py-10">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    {{-- Kolom Kiri: Teks Sambutan --}}
                    <div class="md:w-2/5 text-center md:text-left">
                        <h2 class="text-5xl lg:text-6xl font-extrabold text-[#a05a2c] mb-4 drop-shadow">
                            Halo, {{ $customerName ?? Auth::user()->username }}!
                        </h2>
                        <p class="text-xl lg:text-2xl text-gray-700 font-semibold mb-4">Selamat datang kembali di Roti'O!</p>
                    </div>
                    {{-- Kolom Kanan: Gambar --}}
                    <div class="md:w-3/5">
                        {{-- 1. Buat div pembungkus untuk gradasi --}}
                        <div class="bg-gradient-to-br from-[#a05a2c] to-[#F4EBE0] p-2 rounded-xl shadow-lg">
                            <img src="{{ asset('images/roti_landing.jpg') }}" alt="Roti'O Landing Page" class="w-full h-auto object-cover rounded-lg">
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        {{-- Tampilan untuk pengguna yang belum login --}}
        <div class="w-full">
            <img src="{{ asset('images/gkb.jpg') }}" alt="Roti'O Landing Page" class="w-full h-auto object-cover">
        </div>
    @endauth

    {{-- Bagian Kategori Menu --}}
    <section class="py-16 text-white bg-[#8B4513]">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold mb-12">Yuk pilih menu pilihanmu</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <a href="{{ route('menu.category', 'roti') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/bread.jpg') }}" alt="Roti" class="rounded-t-xl object-cover w-full h-64">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-red-500 transition-colors duration-300">Roti</h3>
                    </div>
                </a>
                <a href="{{ route('menu.category', 'pastry') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/pastry.jpg') }}" alt="Pastry" class="rounded-t-xl object-cover w-full h-64">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-red-500 transition-colors duration-300">Pastry</h3>
                    </div>
                </a>
                <a href="{{ route('menu.category', 'drinks') }}" class="group bg-white rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <img src="{{ asset('images/drinks.jpg') }}" alt="Drinks" class="rounded-t-xl object-cover w-full h-64">
                    <div class="p-6">
                        <h3 class="text-2xl font-semibold text-gray-800 group-hover:text-red-500 transition-colors duration-300">Drinks</h3>
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
