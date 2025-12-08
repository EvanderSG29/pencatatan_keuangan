<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Resource routes for kategori
Route::resource('kategori', App\Http\Controllers\KategoriController::class);

// Resource routes for transaksi
Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);
