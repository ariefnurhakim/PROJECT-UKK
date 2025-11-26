@extends('layouts.app')
@section('title','Tambah Produk')

@section('content')
<div class="content" style="padding:25px; max-width:600px;">

  <h2 style="margin-bottom:20px; font-weight:600;">Tambah Produk</h2>

  <form action="{{ route('products.store') }}" method="POST">
    @csrf

    <label>Nama Produk</label>
    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" 
      style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; margin-bottom:12px;" required>

    <label>Kategori</label>
    <select name="id_kategori" required 
      style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; margin-bottom:12px;">
      <option value="">-- Pilih Kategori --</option>
      @foreach($kategoris as $kategori)
        <option value="{{ $kategori->id_kategori }}" {{ old('id_kategori') == $kategori->id_kategori ? 'selected' : '' }}>
          {{ $kategori->nama_kategori }}
        </option>
      @endforeach
    </select>

    <label>Stok</label>
    <input type="number" name="stok" value="{{ old('stok') }}" 
      style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; margin-bottom:12px;" required>

    <label>Harga</label>
    <input type="number" name="harga" value="{{ old('harga') }}" 
      style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; margin-bottom:12px;" required>

      <button type="submit" class="btn btn-primary btn-sm">
    Simpan
</button>

    <a href="{{ route('products.index') }}" class="btn btn-secondary btn-sm" style="margin-left:10px;">
    Kembali
</a>


  </form>

</div>
@endsection
