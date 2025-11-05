@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Dashboard</h2>
    <p>Selamat datang, {{ auth()->user()->nama }}!</p>

    @php
        use App\Models\Product;
        use App\Models\Category;
        use App\Models\Transaction;

        $totalProduk = Product::count();
        $totalKategori = Category::count();
        $totalTransaksi = Transaction::count();
    @endphp

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Produk</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalProduk }}</h5>
                    <p class="card-text">Total produk tersedia.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-sm">Lihat Produk</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Kategori</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalKategori }}</h5>
                    <p class="card-text">Jumlah kategori tersedia.</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-light btn-sm">Lihat Kategori</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Transaksi</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalTransaksi }}</h5>
                    <p class="card-text">Total transaksi.</p>
                    <a href="{{ route('transactions.index') }}" class="btn btn-light btn-sm">Lihat Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
