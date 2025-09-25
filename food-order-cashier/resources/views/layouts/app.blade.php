<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#6B3E2E] text-white min-h-screen flex flex-col">

    {{-- Header --}}
    <header class="bg-[#F9B233] text-brown-900 p-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo (1).png') }}" alt="RotiO" class="h-12">
        </div>
        <nav class="flex justify-between items-center bg-[#FBBF24] px-6 py-3">
            <a href="/cashier/pending" class="text-lg font-semibold text-right">Dashoard Kasir</a>
        </nav>
    </header>

    {{-- Konten --}}
    <main class="flex-1 p-6">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#F9B233] text-brown-900 text-center py-3">
        <p>&copy; {{ date('Y') }} Aplikasi Kasir</p>
    </footer>

</body>
</html>
