<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Resource routes for kategori
Route::post('kategori/preview-defaults', [App\Http\Controllers\KategoriController::class, 'previewDefaults'])->name('kategori.previewDefaults');
Route::post('kategori/clear', [App\Http\Controllers\KategoriController::class, 'clear'])->name('kategori.clear');
Route::resource('kategori', App\Http\Controllers\KategoriController::class);

// Resource routes for transaksi
Route::resource('transaksi', App\Http\Controllers\TransaksiController::class);

// Users listing and edit
Route::middleware('auth')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});
