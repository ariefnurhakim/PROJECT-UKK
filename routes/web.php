<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Master Produk & Kategori
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // TRANSAKSI
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('index');
        Route::post('/', [TransactionController::class, 'store'])->name('store');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('destroy');
        Route::get('/payment', [TransactionController::class, 'payment'])->name('payment');
        Route::post('/process', [TransactionController::class, 'processPayment'])->name('process');
        Route::get('/print/{id}', [TransactionController::class, 'print'])->name('print');
        Route::get('/reset', [TransactionController::class, 'reset'])->name('reset');
    });

    // ROUTE LAPORAN UTAMA
    Route::get('/laporan', [ReportController::class, 'transactions'])->name('laporan');
    Route::get('/laporan-produk', [ProductController::class, 'laporanProduk'])->name('laporan.produk');

    // ROUTE LAPORAN TERPISAH (ReportController)
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', function () {
            return view('laporan.index');
        })->name('index');
    
        Route::get('/transactions', [ReportController::class, 'transactions'])->name('transactions');
        Route::get('/products', [ReportController::class, 'products'])->name('products');
        Route::get('/transactions/print', [ReportController::class, 'print'])->name('transactions.print');
        Route::get('/transactions/print-filtered', [ReportController::class, 'printFiltered'])
            ->name('transactions.printFiltered');
    });

    // PROFIL USER
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.password');
});

// Cetak laporan (tanpa filter)
Route::get('/laporan/print', [ReportController::class, 'print'])->name('laporan.print');
Route::get('/laporan/cetak', [ReportController::class, 'printFiltered'])->name('laporan.printFiltered');
