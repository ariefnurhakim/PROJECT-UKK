@extends('layouts.app')

@section('title', 'Laporan Produk')

@section('content')
<h3 class="fw-bold mb-3">Laporan Produk</h3>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Stok Final</th>
            <th>Kategori</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $p)
        <tr>
            <td>{{ $p->nama_produk }}</td>
            <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
            
            <td>{{ $p->stok }}</td>

            <td>{{ $p->kategori->nama_kategori ?? '-' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
