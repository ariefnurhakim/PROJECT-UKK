@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-3 fw-bold text-black">Dashboard</h4>
    <p>Selamat datang, {{ auth()->user()->nama }}!</p>

    <!-- Info Box Ringkas -->
    <div class="row mb-4">
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

    <!-- Tabel Transaksi Terbaru -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header fw-bold">Transaksi Terbaru</div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Invoice</th>
                                <th>Tanggal</th>
                                <th>Metode</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestTransactions as $trx)
                                <tr>
                                    <td>{{ $trx->invoice }}</td>
                                    <td>{{ $trx->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $trx->metode_pembayaran }}</td>
                                    <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada transaksi.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
