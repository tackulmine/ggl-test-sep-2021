<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Auth::routes([
        'login'    => true,
        'logout'   => true,
        'register' => false,
        'reset'    => false,   // for resetting passwords
        'confirm'  => false,  // for additional password confirmations
        'verify'   => false,  // for email verification
    ]);

    Route::middleware(['auth'])->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        // CRUD Barang
        Route::resource('/barang', App\Http\Controllers\BarangController::class)->except('show');
        // CRUD Stok
        Route::get('/barang/{barang}/edit-stok', [App\Http\Controllers\BarangController::class, 'editStok'])->name('barang.edit-stok');
        Route::put('/barang/{barang}/update-stok', [App\Http\Controllers\BarangController::class, 'updateStok'])->name('barang.update-stok');

        // CRUD Penjualan
        Route::resource('/penjualan', App\Http\Controllers\PenjualanController::class)->except('show');
    });
});
