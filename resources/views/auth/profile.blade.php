@extends('layouts.app')
@section('title', 'Profil Saya')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Profil Pengguna</h3>

        <!-- Tombol Buat Akun -->
        <a href="{{ route('register') }}" class="btn btn-success">
            + Buat Akun Baru
        </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">

        {{-- Update Profil --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white fw-semibold">
                    Update Profil
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                   value="{{ Auth::user()->nama }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control"
                                   value="{{ Auth::user()->username }}" required>
                        </div>

                        <button class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Update Password --}}
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-danger text-white fw-semibold">
                    Ubah Password
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <button class="btn btn-danger w-100">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
