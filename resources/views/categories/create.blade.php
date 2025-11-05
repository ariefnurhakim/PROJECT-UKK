@extends('layouts.app')
@section('title','Tambah Kategori')

@section('content')
<div class="content" style="padding:25px;">

  <h2 style="margin-bottom:20px; font-weight:600;">Tambah Kategori</h2>

  <form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div style="margin-bottom:15px;">
      <label>Nama Kategori</label><br>
      <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" style="padding:10px; width:300px; border-radius:8px; border:1px solid #ccc;">
      @error('nama_kategori')
        <div style="color:red;">{{ $message }}</div>
      @enderror
    </div>
    <button type="submit" style="padding:10px 16px; background:#007bff; color:white; border:none; border-radius:8px;">Simpan</button>
    <a href="{{ route('categories.index') }}" style="padding:10px 16px; background:gray; color:white; border-radius:8px; text-decoration:none;">Batal</a>
  </form>

</div>
@endsection
