@extends('app')

@section('page_title', 'Data Kategori')
@section('page_subtitle', 'Manajemen daftar kategori produk.')

@section('breadcrumb')
    <li class="breadcrumb-item active text-main" aria-current="page">Categories</li>
@endsection

@section('content')
<div class="table-card-custom">
    <!-- Header Controls -->
    <div class="table-header-control">
        <div class="table-search-box border-0 bg-transparent">
            <h5 class="mb-0 text-dark"><i class="bi bi-tags-fill me-2 text-primary"></i>Daftar Kategori</h5>
        </div>
        <div class="table-filter-group">
            <a href="{{ route('categories.create') }}" class="btn-table-action bg-primary text-white text-decoration-none border-0 shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah Kategori
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success m-4 mb-0 alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>ID Kategori</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td><span class="text-muted fw-bold">#{{ $category->id }}</span></td>
                    <td class="fw-semibold text-dark">{{ $category->name }}</td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm text-white rounded-3 me-1 px-3 shadow-sm" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-3 px-3 shadow-sm" onclick="return confirm('Yakin hapus kategori ini?')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-light"></i>
                        Belum ada data kategori yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
