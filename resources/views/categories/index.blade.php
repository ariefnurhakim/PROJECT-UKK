@extends('layouts.app')
@section('title','Kelola Kategori')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="fw-semibold">Data Kategori</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Search -->
    <form method="GET" action="{{ route('categories.index') }}" class="mb-3 d-flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               class="form-control w-auto" placeholder="Cari kategori...">
        <button type="submit" class="btn btn-primary">Cari</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Refresh</a>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered align-middle table-striped text-center">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th width="160px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($kategoris as $index => $kategori)
                <tr>
                    <td>{{ $kategoris->firstItem() + $index }}</td>
                    <td>KTG-{{ str_pad($kategori->id_kategori, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $kategori->id_kategori) }}" class="btn btn-sm btn-warning text-dark">
                            Edit
                        </a>

                        <form action="{{ route('categories.destroy', $kategori->id_kategori) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus kategori ini?');" 
                                class="btn btn-sm btn-danger">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-muted py-2">Tidak ada kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-2">
        {{ $kategoris->links() }}
    </div>

</div>
@endsection
