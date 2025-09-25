<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Route untuk halaman login
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');

// Route untuk meng-handle login action
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Route untuk halaman register
Route::get('register', [RegisteredUserController::class, 'create'])->name('register');

// Route untuk meng-handle register action
Route::post('register', [RegisteredUserController::class, 'store']);
