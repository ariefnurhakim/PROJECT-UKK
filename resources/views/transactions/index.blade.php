@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h4 class="mb-2 fw-bold text-black">Transaksi</h4>

    {{-- 🔥 TANGGAL TRANSAKSI --}}
    <p class="text-muted">
        Tanggal Transaksi: 
        <strong>{{ $transaction->created_at->format('Y-m-d H:i:s') }}</strong>
    </p>

    {{-- 🔥 POPUP ERROR --}}
    @if(session('error'))
    <div class="modal fade show" id="errorModal"
         style="display:block; background:rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Peringatan!</h5>
                </div>

                <div class="modal-body">
                    {{ session('error') }}
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" onclick="closeErrorModal()">Tutup</button>
                </div>

            </div>
        </div>
    </div>

    <script>
    function closeErrorModal() {
        document.getElementById('errorModal').style.display = "none";
    }
    </script>
    @endif

    <div class="row">
        <!-- Tabel items -->
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm rounded-3">
                <div class="card-header bg-primary text-white fw-semibold">
                    Daftar Items
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                        @forelse($items as $item)
                        <tr>
                            <td>{{ $item->product->nama_produk ?? 'Produk tidak ditemukan' }}</td>
                            <td>Rp {{ number_format($item->product->harga ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <!-- Tombol hapus yang memicu modal -->
                                <button class="btn btn-danger btn-sm"
                                        onclick="openDeleteModal('{{ $item->id }}', '{{ $item->product->nama_produk }}')">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Belum ada item</td>
                        </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="card-footer text-end bg-light">
                    <p class="text-muted">
                        Tanggal Transaksi: 
                        <strong>{{ $transaction->created_at->timezone('Asia/Jakarta')->format('d-m-y H:i:s') }}</strong>
                    </p>
                </div>

            </div>
        </div>

        <!-- Form Tambah Produk -->
        <div class="col-md-4">
            <div class="card shadow-sm rounded-3">
                <div class="card-header bg-success text-white fw-semibold">
                    Tambah Produk
                </div>

                <div class="card-body">
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

                        <div class="mb-3">
                            <label for="produk_id" class="form-label">Produk</label>
                            <select name="produk_id" id="produk_id" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($products as $produk)
                                    <option value="{{ $produk->id_produk }}">
                                        {{ $produk->nama_produk }} - Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        (Stok: {{ $produk->stok }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" name="jumlah" id="jumlah"
                                   class="form-control" min="1" value="1" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Tambah</button>
                    </form>
                </div>

                <div class="card-footer bg-light text-center">
                    <a href="{{ route('transactions.payment') }}" class="btn btn-success w-100">Bayar</a>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- 🔥 MODAL HAPUS ITEM --}}
<div class="modal fade show" id="deleteModal"
     style="display:none; background:rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
            </div>

            <div class="modal-body">
                Yakin ingin menghapus <b id="namaProdukHapus"></b> ?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeDeleteModal()">Batal</button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
function openDeleteModal(id, nama) {
    document.getElementById("namaProdukHapus").innerHTML = nama;
    document.getElementById("deleteForm").action = "/transactions/" + id;

    document.getElementById("deleteModal").style.display = "block";
}

function closeDeleteModal() {
    document.getElementById("deleteModal").style.display = "none";
}
</script>

@endsection
