@extends('layouts.pimpinan')

@section('page_title', 'Dashboard Pimpinan')
@section('page_subtitle', 'Selamat datang di panel Pimpinan')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-badge fs-1 text-primary"></i>
                    </div>
                </div>
                <h3 class="fw-bold text-dark mb-3">Selamat Datang, {{ auth()->user()->name ?? 'Pimpinan' }}</h3>
                <p class="text-muted fs-5 mb-4">Gunakan menu di panel sebelah kiri untuk memantau performa penjualan dan ketersediaan stok barang Anda hari ini.</p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="{{ route('pimpinan.laporan') }}" class="btn btn-primary px-4 py-2 rounded-pill">
                        <i class="bi bi-receipt me-2"></i>Lihat Laporan Penjualan
                    </a>
                    <a href="{{ route('pimpinan.stok') }}" class="btn btn-outline-dark px-4 py-2 rounded-pill">
                        <i class="bi bi-box-seam me-2"></i>Cek Stok Barang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
