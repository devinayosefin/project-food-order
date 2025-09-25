@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">

    <!-- Logo di tengah -->
    <div class="mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Roti O Logo" class="logo">
    </div>

    <!-- Login Card -->
    <div class="w-full max-w-md p-8 bg-yellow-400 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-brown-800 mb-6">Hi, Welcome back</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email address</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-600" required autofocus>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-600" required>
            </div>

            <button type="submit" class="w-full py-2 bg-yellow-700 text-white rounded-lg hover:bg-yellow-800 transition">
                Login
            </button>
        </form>

        <!-- Register Link -->
        <p class="mt-4 text-center text-sm">
            Don’t have an account?
            <a href="{{ route('register') }}" class="font-semibold text-yellow-900 hover:underline">Register now!</a>
        </p>
    </div>
</div>
@endsection
