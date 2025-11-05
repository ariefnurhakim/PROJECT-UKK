@extends('layouts.app')
@section('title','Kelola Produk')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-semibold">Data Produk</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Search -->
    <form method="GET" action="{{ route('products.index') }}" class="mb-3 d-flex gap-2">

        <input type="text" name="search" value="{{ request('search') }}" class="form-control w-auto"
               placeholder="Cari nama produk...">

        <select name="kategori" class="form-control w-auto">
            <option value="">Semua Kategori</option>
            @foreach(\App\Models\Category::all() as $kat)
                <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Refresh</a>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>ID Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th width="160px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produks as $index => $produk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>PRD-{{ str_pad($produk->id_produk, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $produk->nama_produk }}</td>
                    <td>{{ $produk->kategori->nama_kategori ?? '-' }}</td>
                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->stok }}</td>
                    <td>
                        <a href="{{ route('products.edit', $produk->id_produk) }}" 
                           class="btn btn-sm btn-warning text-dark fw-semibold">Edit</a>

                        <!-- Tombol Hapus pakai Modal -->
                        <button 
                            class="btn btn-sm btn-danger btn-delete" 
                            data-id="{{ $produk->id_produk }}"
                            data-nama="{{ $produk->nama_produk }}">
                            Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada produk</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>


<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="modalDelete" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

    <div class="modal-header bg-white text-black">

        <h5 class="modal-title">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        Yakin ingin menghapus produk <b id="nama-produk"></b> ?
      </div>

      <div class="modal-footer">
        <form id="formDelete" method="POST">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalDelete = new bootstrap.Modal(document.getElementById('modalDelete'));

    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function () {

            let id = this.dataset.id;
            let nama = this.dataset.nama;

            document.getElementById('nama-produk').textContent = nama;
            document.getElementById('formDelete').action = "/products/" + id;

            modalDelete.show();
        });
    });
});
</script>

@endsection
