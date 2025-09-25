<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Roti O') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Additional CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="{{ Request::is('register') ? 'register-page' : '' }}">
    <div id="app">

        <!-- Brown bar at the top -->
        <div class="top-bar"></div>
        
        <!-- Main Content -->
        <main class="py-4">
            @if (Request::is('login') || Request::is('register'))
                {{-- Tampilkan halaman login/register tanpa navbar atau container --}}
                <div class="auth-page">
                    @yield('content')
                </div>
            @else
                {{-- Default dengan container + navbar --}}
                <div class="container">
                     @yield('content')
                </div>
            @endif
        </main>
    </div>
</body>
</html>
