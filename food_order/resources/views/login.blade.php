<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Roti'O</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen flex font-sans bg-[#e7d6c6]">

    <!-- KIRI: Background Gambar (tanpa teks) -->
    <div class="hidden md:flex w-1/2 bg-cover bg-center relative"
         style="background-image: url('{{ asset('images/bg-login.jpg') }}');">
        <div class="absolute inset-0 bg-black/30"></div>
    </div>

    <!-- KANAN: Form Login -->
    <div class="w-full md:w-1/2 flex items-center justify-center bg-gradient-to-br from-[#fff5ea] to-[#e7d6c6] relative">

        <!-- Kartu Glassmorphism -->
        <div class="backdrop-blur-3xl bg-white/25 border border-white/40 
                    shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-3xl 
                    p-10 max-w-md w-[90%] animate-fadeIn transition-all duration-700">
            
            <!-- Logo dan Judul -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Roti'O Logo" class="h-16 mx-auto mb-3 drop-shadow-lg">
                <h2 class="font-extrabold text-3xl text-[#4b2e05]">Welcome Back!</h2>
                <p class="text-gray-700 mt-1">Log in to continue your sweet journey 🍞</p>
            </div>

            <!-- Pesan Error -->
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- FORM -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <input type="email" name="email"
                       class="w-full px-4 py-3 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]"
                       placeholder="Email address" required>

                <input type="password" name="password"
                       class="w-full px-4 py-3 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]"
                       placeholder="Password" required>

                <button type="submit"
                        class="w-full bg-[#a05a2c]/90 hover:bg-[#8B4513] hover:shadow-lg text-white py-3 
                               rounded-xl font-bold text-lg transition-all duration-300">
                    Login
                </button>
            </form>

            <!-- Link Register -->
            <div class="text-center mt-6 text-gray-700">
                Don't have an account?
                <a href="{{ route('register') }}" class="font-bold text-[#f9b233] hover:underline">
                    Register here
                </a>
            </div>
        </div>
    </div>

    <!-- ANIMASI FADE-IN -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeIn {
            animation: fadeIn 1.5s ease-out;
        }
    </style>

</body>
</html>
