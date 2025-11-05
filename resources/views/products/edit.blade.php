@extends('layouts.app')
@section('title','Edit Produk')

@section('content')
<div class="container py-4" style="max-width:700px;">

    <h2 class="fw-semibold mb-4">Edit Produk</h2>

    <form action="{{ route('products.update', $produk->id_produk) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Produk</label>
            <input type="text" name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select name="id_kategori" class="form-select" required>
                <option disabled>Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id_kategori }}"
                        {{ $produk->id_kategori == $kategori->id_kategori ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required>
        </div>

        <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-warning text-dark fw-semibold px-4">Simpan</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary px-4">Kembali</a>
        </div>

    </form>

</div>
@endsection
