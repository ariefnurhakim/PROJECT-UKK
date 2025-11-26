@extends('layouts.app')

@section('title', 'Tambah Produk ke Transaksi')

@section('content')
<div class="container mt-4" style="max-width: 600px;">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Produk ke Keranjang</h5>
        </div>

        <div class="card-body">
            
            <form action="{{ route('transaksi.store') }}" method="POST"> {{-- ✅ Ubah ke transaksi.store --}}
                @csrf

                <input type="hidden" name="id_produk" value="{{ $product->id_produk }}"> {{-- ✅ id_produk --}}

                <div class="mb-3">
                    <label class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" value="{{ $product->nama_produk }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga Satuan</label>
                    <input type="text" class="form-control" value="Rp {{ number_format($product->harga) }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah</label>
                    <input type="number" name="qty" class="form-control" placeholder="Masukkan jumlah" min="1" required> {{-- ✅ qty --}}
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a> {{-- ✅ transaksi.index --}}
                    <button type="submit" class="btn btn-success px-4">Tambah</button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
