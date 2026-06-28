<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Roti'O</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(40px); }
            to { opacity: 1; transform: translateX(0); }
        }
        .animate-slideInLeft {
            animation: slideInLeft 1.2s ease-out;
        }

        /* Scrollbar halus */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-thumb {
            background-color: rgba(160, 90, 44, 0.4);
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background-color: rgba(160, 90, 44, 0.7);
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row font-sans bg-[#e7d6c6]">

    <!-- KIRI: Form Register -->
    <div class="w-full md:w-1/2 flex justify-center bg-gradient-to-br from-[#fff5ea] to-[#e7d6c6] relative animate-slideInLeft overflow-y-auto py-10 md:py-12">
        <div class="backdrop-blur-3xl bg-white/25 border border-white/40 
                    shadow-[0_8px_32px_0_rgba(31,38,135,0.37)] rounded-3xl 
                    p-8 max-w-sm w-[85%] my-auto transition-all duration-700 md:mt-6">
            
            <!-- Header -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Roti'O Logo" class="h-14 mx-auto mb-2 drop-shadow-lg">
                <h2 class="font-extrabold text-2xl text-[#4b2e05]">Create an Account</h2>
                <p class="text-gray-700 mt-1 text-sm">Join us and enjoy every bite 🍞</p>
            </div>

            <!-- Error Message -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-3">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap"
                       class="w-full px-4 py-2.5 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]" required>

                <input type="text" name="username" placeholder="Username"
                       class="w-full px-4 py-2.5 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]" required>

                <input type="email" name="email" placeholder="Email"
                       class="w-full px-4 py-2.5 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]" required>

                <input type="text" name="address" placeholder="Alamat"
                       class="w-full px-4 py-2.5 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]" required>

                <input type="text" name="phone_number" placeholder="Nomor HP"
                       class="w-full px-4 py-2.5 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]" required>

                <input type="password" name="password" placeholder="Password"
                       class="w-full px-4 py-2.5 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]" required>

                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                       class="w-full px-4 py-2.5 bg-white/60 border border-white/40 rounded-xl 
                              focus:outline-none focus:ring-4 focus:ring-[#a05a2c]/40 placeholder-gray-600 text-[#4b2e05]" required>

                <button type="submit"
                        class="w-full bg-[#a05a2c]/90 hover:bg-[#8B4513] hover:shadow-lg 
                               text-white py-2.5 rounded-xl font-semibold text-base transition-all duration-300">
                    Register
                </button>
            </form>

            <!-- Link ke Login -->
            <div class="text-center mt-5 text-gray-700 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" 
                   class="font-bold text-[#f9b233] hover:underline transition-all duration-300">
                    Log in here
                </a>
            </div>
        </div>
    </div>

    <!-- KANAN: Background Image -->
    <div class="hidden md:flex md:w-1/2 bg-cover bg-center relative sticky top-0 h-screen"
         style="background-image: url('{{ asset('images/bg-login.jpg') }}');">
        <div class="absolute inset-0 bg-black/20"></div>
    </div>

</body>
</html>
