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
        <nav class="space-x-4">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <a href="{{ route('menu.index') }}" class="hover:underline">Menu</a>
            <a href="{{ route('cart.show') }}" class="relative hover:underline">
                Keranjang
                @if(session('cart'))
                <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">{{ count(session('cart')) }}</span>
                @endif
            </a>
        </nav>
    </header>

    <main class="container mx-auto p-4 mt-8">
        @yield('content')
    </main>
</body>
</html>