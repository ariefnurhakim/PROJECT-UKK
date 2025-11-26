@extends('layouts.app')

@section('title', 'Cari Produk')

@section('content')
<div class="container mt-3">

    <h4 class="fw-bold mb-3">Cari Produk</h4>

    <form action="{{ route('transaksi.search') }}" method="GET" class="d-flex gap-2 mb-3">
        <input type="text" name="keyword" class="form-control w-50" placeholder="Cari nama produk...">
        <button class="btn btn-primary">Cari</button>
    </form>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th width="120">Jumlah</th>
                <th width="150">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr>
                <td>{{ $p->nama_produk }}</td>
                <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                <td>
                    <form action="{{ route('transaksi.store') }}" method="POST" class="d-flex">
                        @csrf
                        <input type="hidden" name="id_produk" value="{{ $p->id_produk }}">
                        <input type="number" name="qty" class="form-control" min="1" value="1">
                </td>
                <td>
                        <button class="btn btn-success btn-sm w-100">Tambahkan</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
