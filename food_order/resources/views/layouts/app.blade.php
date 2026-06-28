<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roti'O</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-yellow-500 text-gray-800 p-4 flex justify-between items-center shadow-lg">
        <div class="flex items-center space-x-2">
            <a href="/" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Roti'O Logo" class="h-8 w-auto">
            </a>
        </div>
    <nav class="space-x-4 font-bold">
            @if(!Auth::check() || Auth::user()->role_id != 2)
                <a href="{{ route('home') }}"
                   class="tracking-wide text-lg px-3 py-2 rounded transition-all duration-150 {{ request()->routeIs('home') ? 'text-[#a05a2c] font-extrabold' : 'text-gray-800 font-bold' }}">
                    Home
                </a>
            @endif
            @guest
                <a href="{{ route('login') }}" class="inline-block bg-[#a05a2c] text-white px-5 py-2 rounded-full shadow hover:bg-[#7a3e1a] transition tracking-wide text-lg border-2 border-[#a05a2c] {{ request()->routeIs('login') ? 'font-extrabold ring-4 ring-[#f9b233]/40' : 'font-bold' }}">Login</a>
            @else
                @if(Auth::user()->role_id == 3)
                    <a href="{{ route('menu.index') }}" class="px-3 py-2 rounded transition-all duration-150 {{ request()->routeIs('menu.index') ? 'text-[#a05a2c] font-extrabold' : 'text-gray-800 font-bold' }}">Menu</a>
                    <a href="{{ route('cart.show') }}" class="relative px-3 py-2 rounded transition-all duration-150 {{ request()->routeIs('cart.show') ? 'text-[#a05a2c] font-extrabold' : 'text-gray-800 font-bold' }}">
                        Keranjang
                        @php
                            $cart = session('cart', []);
                            $cartCount = 0;
                            if (is_array($cart) && count($cart ?? []) > 0) {
                                $cartCount = collect($cart)->filter(fn($item) => isset($item['menu_id']))->count();
                            }
                        @endphp
                        @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('history') }}" class="px-3 py-2 rounded transition-all duration-150 {{ request()->routeIs('history') ? 'text-[#a05a2c] font-extrabold' : 'text-gray-800 font-bold' }}">History</a>
                @elseif(Auth::user()->role_id == 1)
                    <a href="{{ route('admin.menu.index') }}" class="px-3 py-2 rounded transition-all duration-150 {{ request()->routeIs('admin.menu.index') ? 'text-[#a05a2c] font-extrabold' : 'text-gray-800 font-bold' }}">Dashboard Admin</a>
                @elseif(Auth::user()->role_id == 2)
                    <a href="{{ route('cashier.dashboard') }}" class="px-3 py-2 rounded transition-all duration-150 {{ request()->routeIs('cashier.dashboard') ? 'text-[#a05a2c] font-extrabold' : 'text-gray-800 font-bold' }}">Dashboard Kasir</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="hover:underline bg-transparent border-none cursor-pointer font-bold">Logout</button>
                </form>
            @endguest
        </nav>
    </header>

    <main class="container mx-auto p-4 mt-8">
        @yield('content')
    </main>
</body>
</html>