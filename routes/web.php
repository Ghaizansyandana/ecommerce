<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tentang', function () {
    return view('tentang');
});


Route::get('/sapa/{nama}', function ($nama) {
    return "Halo, $nama! Selamat datang di Toko Gojin.";
});


Route::get('/kategori/{nama?}', function ($nama = 'Semua') {
    return "Menampilkan kategori: $nama";
});


Route::get('/produk/{id}', function ($id) {
    return "Detail produk #$id";
})->name('produk.detail');


// Authentication routes (simple)
Route::get('login', [AuthController::class, 'showLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Register
Route::get('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


