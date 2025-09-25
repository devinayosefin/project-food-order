@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">

    <!-- Logo di tengah -->
    <div class="mb-6">
        <img src="{{ asset('images/logo.png') }}" alt="Roti O Logo" class="logo"> 
    </div>

    <!-- Register Card -->
    <div class="w-full max-w-md p-8 bg-yellow-400 rounded-2xl shadow-lg">
        <h2 class="text-2xl font-bold text-center text-brown-800 mb-6">Create an account</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <!-- Full Name -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Full Name</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-600" required>
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Email address</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-600" required>
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-600" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-600" required>
            </div>

            <button type="submit" class="w-full py-2 bg-yellow-700 text-white rounded-lg hover:bg-yellow-800 transition">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <p class="mt-4 text-center text-sm">
            Already have an account?
            <a href="{{ route('login') }}" class="font-semibold text-yellow-900 hover:underline">Log in!</a>
        </p>
    </div>
</div>
@endsection
