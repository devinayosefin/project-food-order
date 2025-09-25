<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReportController;

Route::get('/', function () {
    return redirect()->route('admin.menu.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('menu', MenuController::class);
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});