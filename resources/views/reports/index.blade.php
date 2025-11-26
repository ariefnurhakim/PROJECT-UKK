@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">📊 Laporan Transaksi</h3>

    <!-- Filter -->
    <form method="GET" action="{{ route('laporan') }}" class="row g-3 mb-4">

        <div class="col-md-3">
            <label>Cari</label>
            <input type="text" name="search" class="form-control"
                placeholder="Invoice / Nama Produk"
                value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <label>Tanggal Mulai</label>
            <input type="date" name="start" class="form-control"
                value="{{ request('start') }}">
        </div>

        <div class="col-md-3">
            <label>Tanggal Akhir</label>
            <input type="date" name="end" class="form-control"
                value="{{ request('end') }}">
        </div>

        <div class="col-md-2">
            <label>Metode</label>
            <select name="metode" class="form-control">
                <option value="">Semua</option>
                <option value="cash" {{ request('metode')=='cash' ? 'selected':'' }}>Cash</option>
                <option value="transfer" {{ request('metode')=='transfer' ? 'selected':'' }}>Transfer</option>
                <option value="qris" {{ request('metode')=='qris' ? 'selected':'' }}>QRIS</option>
            </select>
        </div>

        <div class="col-md-1 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filter</button>
        </div>

    </form>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body">

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Dibayar</th>
                        <th>Kembalian</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $t)
                        <tr>
                            <td>{{ $t->invoice }}</td>
                            <td>{{ $t->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @foreach ($t->items as $item)
                                    {{ $item->product->nama_produk }} ({{ $item->quantity }}) <br>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($t->total) }}</td>
                            <td>Rp {{ number_format($t->dibayar) }}</td>
                            <td>Rp {{ number_format($t->kembalian) }}</td>
                            <td>{{ ucfirst($t->metode_pembayaran) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
