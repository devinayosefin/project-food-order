<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

// Halaman Utama (Home)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Menu (Menampilkan 3 Kategori)
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Halaman Kategori Spesifik (Menampilkan daftar menu per kategori)
Route::get('/menu/{category}', [MenuController::class, 'showCategory'])->name('menu.category');

// Rute Keranjang & Checkout
Route::post('/cart/add', [CheckoutController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CheckoutController::class, 'showCart'])->name('cart.show');
Route::post('/cart/remove', [CheckoutController::class, 'removeFromCart'])->name('cart.remove');
Route::post('/checkout', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/receipt/{order_id}', [CheckoutController::class, 'showReceipt'])->name('receipt');