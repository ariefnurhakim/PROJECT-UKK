<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;

/*
|--------------------------------------------------------------------------
| Auth (Tidak Perlu Login)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

/*
|--------------------------------------------------------------------------
| Harus Login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Produk
    Route::resource('products', ProductController::class);

    // Kategori
    Route::resource('categories', CategoryController::class);

    // Transaksi
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/search', [TransactionController::class, 'search'])->name('transactions.search');
    Route::get('/transactions/create', [TransactionController::class, 'search'])->name('transactions.create');
    Route::get('/transactions/pay/{id}', [TransactionController::class, 'pay'])->name('transactions.pay');

    // Laporan
    Route::get('/reports/products', [ProductController::class, 'report'])->name('reports.products');
    Route::get('/reports/transactions', [TransactionController::class, 'report'])->name('reports.transactions');
    
});
