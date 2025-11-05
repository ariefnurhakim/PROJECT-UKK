@extends('layouts.app')

@section('title', 'Transaksi')

@section('content')
<div class="container-fluid mt-3">

    <!-- Search Produk -->
    <div class="mb-3">
        <form action="{{ route('transactions.search') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="keyword" value="{{ request('keyword') }}" class="form-control w-50" placeholder="Cari Produk">
            <button class="btn btn-primary">Cari</button>
        </form>
    </div>

    <!-- Tombol Tambah Data -->
    <div class="mb-3">
        <a href="{{ route('transactions.create') }}" class="btn btn-info">
            + Tambah Data
        </a>
    </div>

    <!-- Kasir -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Kasir</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-bordered table-striped text-center mb-0">
                <thead class="table-primary">
                    <tr>
                        <th>Tanggal</th>
                        <th>ID Transaksi</th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Kasir</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $t)
                    <tr>
                        <td>{{ $t->created_at->format('d M Y') }}</td>
                        <td>{{ $t->invoice }}</td>
                        <td>
                            @foreach($t->items as $item)
                                {{ $item->product->nama_produk }} <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($t->items as $item)
                                {{ $item->quantity }} <br>
                            @endforeach
                        </td>
                        <td>Rp {{ number_format($t->total,0,',','.') }}</td>
                        <td>{{ $t->user->name ?? '-' }}</td>
                        <td>

                            <!-- Tombol Bayar -->
                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#payModal{{ $t->id }}">
                                💳 Bayar
                            </button>

                            <a href="{{ route('transactions.edit', $t->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <form action="{{ route('transactions.destroy', $t->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus transaksi ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal Pembayaran -->
                    <div class="modal fade" id="payModal{{ $t->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('transactions.pay', $t->id) }}" method="POST">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Pembayaran Transaksi</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Total: <b>Rp {{ number_format($t->total) }}</b></p>
                                        <label>Nominal Bayar</label>
                                        <input type="number" name="paid" class="form-control" required min="{{ $t->total }}">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Bayar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Total dan tombol -->
    <div class="row mt-3">
        <div class="col-md-4 mb-2">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h6>Total Semua</h6>
                    <h4>Rp {{ number_format($total_semua,0,',','.') }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">Kembali</a>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $transactions->links() }}
    </div>

</div>
@endsection
