@extends('layouts.app')

@section('content')
    <div class="p-8 bg-white rounded-lg shadow-md">
        <h2 class="text-3xl font-semibold mb-6 text-center">Keranjang Anda</h2>
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(empty($cart))
            <p class="text-center text-gray-500">Keranjang Anda kosong.</p>
        @else
            <table class="w-full table-auto mb-6">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Menu</th>
                        <th class="py-3 px-6 text-left">Harga Item</th>
                        <th class="py-3 px-6 text-left">Jumlah</th>
                        <th class="py-3 px-6 text-right">Harga Total</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                    @foreach($cart as $id => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-100">
                            <td class="py-3 px-6 text-left whitespace-nowrap">{{ $item['name'] }}</td>
                            <td class="py-3 px-6 text-left">Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                            <td class="py-3 px-6 text-left">{{ $item['quantity'] }}</td>
                            <td class="py-3 px-6 text-right">Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                            <td class="py-3 px-6 text-center">
                                <form action="{{ route('cart.remove') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $id }}">
                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-right font-bold text-xl mb-4">
                Harga Total: Rp{{ number_format($totalPrice, 0, ',', '.') }}
            </div>
            <form action="{{ route('checkout.process') }}" method="POST" class="text-center">
                @csrf
                <button type="submit" class="bg-green-500 text-white px-6 py-3 rounded-lg text-lg font-semibold hover:bg-green-600 transition-colors">
                    Checkout
                </button>
            </form>
        @endif
    </div>
@endsection
