@extends('app')

@section('page_title', 'Data Produk')
@section('page_subtitle', 'Manajemen daftar inventaris produk yang dijual.')

@section('breadcrumb')
    <li class="breadcrumb-item active text-main" aria-current="page">Products</li>
@endsection

@section('content')
<div class="table-card-custom">
    <!-- Header Controls -->
    <div class="table-header-control">
        <div class="table-search-box border-0 bg-transparent">
            <h5 class="mb-0 text-dark"><i class="bi bi-box-seam-fill me-2 text-primary"></i>Daftar Produk</h5>
        </div>
        <div class="table-filter-group">
            <a href="{{ route('products.create') }}" class="btn-table-action bg-primary text-white text-decoration-none border-0 shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah Produk
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
                    <th>ID</th>
                    <th style="width: 80px;">Foto</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td><span class="text-muted fw-bold">#{{ $product->id }}</span></td>
                    <td>
                        @if($product->photo)
                            @php
                                $photoUrl = str_starts_with($product->photo, 'http') ? $product->photo : asset('storage/' . ltrim(str_replace('storage/', '', $product->photo), '/'));
                            @endphp
                            <img src="{{ $photoUrl }}" alt="{{ $product->name }}" class="img-thumbnail rounded-3" style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </td>
                    <td class="fw-semibold text-dark">{{ $product->name }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $product->category->name ?? 'Tanpa Kategori' }}</span>
                    </td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if($product->stock > 10)
                            <span class="badge bg-success">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                            <span class="badge bg-warning text-dark">{{ $product->stock }}</span>
                        @else
                            <span class="badge bg-danger">Habis</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm text-white rounded-3 me-1 px-3 shadow-sm" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-3 px-3 shadow-sm" onclick="return confirm('Yakin hapus produk ini?')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-light"></i>
                        Belum ada data produk yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
