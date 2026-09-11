@extends('layouts.pimpinan')

@section('page_title', 'Stok Barang')
@section('page_subtitle', 'Pantau sisa stok barang secara real-time')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-transparent border-bottom p-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-box-seam text-main me-2"></i> Data Stok Barang</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Kategori</th>
                                <th class="text-end">Harga</th>
                                <th class="text-center">Sisa Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->photo)
                                                <img src="{{ str_starts_with($product->photo, 'http') ? $product->photo : asset('storage/' . $product->photo) }}" 
                                                    alt="{{ $product->name }}" 
                                                    class="rounded me-3 object-fit-cover" 
                                                    style="width: 40px; height: 40px;">
                                            @else
                                                <div class="rounded me-3 d-flex align-items-center justify-content-center bg-light text-muted" style="width: 40px; height: 40px;">
                                                    <i class="bi bi-image"></i>
                                                </div>
                                            @endif
                                            <span class="fw-semibold">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $product->category->name ?? '-' }}</span>
                                    </td>
                                    <td class="text-end text-success fw-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if($product->stock <= 5)
                                            <span class="badge bg-danger rounded-pill px-3">{{ $product->stock }}</span>
                                        @elseif($product->stock <= 20)
                                            <span class="badge bg-warning text-dark rounded-pill px-3">{{ $product->stock }}</span>
                                        @else
                                            <span class="badge bg-success rounded-pill px-3">{{ $product->stock }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Belum ada data produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
