<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CashierController;

Route::get('/', function () {
    return redirect()->route('cashier.pending');
});

// Grouping route untuk kasir
Route::prefix('cashier')->name('cashier.')->group(function () {
    Route::get('/pending', [CashierController::class, 'pending'])->name('pending');
    Route::get('/finished', [CashierController::class, 'finished'])->name('finished');

    // detail pesanan -> {id} wajib dikirim
    Route::get('/orders/{id}', [CashierController::class, 'detail'])->name('orders.detail');
    Route::put('/payment/{id}', [CashierController::class, 'updatePayment'])->name('payment.update');
});
