@extends('layouts.app')

@section('title', 'Transaksi Baru')

@section('content')
<div class="container mt-3">

    <h3 class="fw-bold mb-3">💰 Transaksi Baru</h3>

    <form action="{{ route('transactions.store') }}" method="POST">
        @csrf

        <table class="table table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th style="width: 40%">Nama Produk</th>
                    <th style="width: 15%">Stok</th>
                    <th style="width: 20%">Qty</th>
                    <th style="width: 25%">Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $p)
                <tr>
                    <td>
                        <input type="hidden" name="product_id[]" value="{{ $p->id }}">
                        {{ $p->nama_produk }}
                    </td>
                    <td>{{ $p->stock }}</td>
                    <td>
                        <input type="number" name="qty[]" value="0" min="0" max="{{ $p->stock }}" class="form-control text-center">
                    </td>
                    <td>Rp {{ number_format($p->price,0,',','.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
            <button class="btn btn-primary px-4">Simpan Transaksi</button>
        </div>
    </form>

</div>
@endsection
