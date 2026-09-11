@extends('layouts.pimpinan')

@section('page_title', 'Laporan Penjualan')
@section('page_subtitle', 'Rekap transaksi dan total pendapatan')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-12 col-md-4">
        <div class="card border-0 shadow-sm rounded-4 bg-primary text-white h-100">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-white bg-opacity-25 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px;">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <h6 class="mb-0 fw-semibold text-white-50">Total Pendapatan</h6>
                </div>
                <h3 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                <small class="text-white-50 mt-1">Berdasarkan filter: {{ ucfirst($filter) }}</small>
            </div>
        </div>
    </div>
    
    <div class="col-12 col-md-8">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
            <div class="card-body p-4 d-flex flex-column justify-content-center">
                <h6 class="fw-bold text-dark mb-3">Filter Laporan</h6>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="{{ route('pimpinan.laporan', ['filter' => 'semua']) }}" class="btn {{ $filter == 'semua' ? 'btn-dark' : 'btn-outline-dark' }} px-4 rounded-pill">
                        Semua Waktu
                    </a>
                    <a href="{{ route('pimpinan.laporan', ['filter' => 'harian']) }}" class="btn {{ $filter == 'harian' ? 'btn-primary' : 'btn-outline-primary' }} px-4 rounded-pill">
                        Hari Ini
                    </a>
                    <a href="{{ route('pimpinan.laporan', ['filter' => 'mingguan']) }}" class="btn {{ $filter == 'mingguan' ? 'btn-success' : 'btn-outline-success' }} px-4 rounded-pill">
                        Minggu Ini
                    </a>
                    <a href="{{ route('pimpinan.laporan', ['filter' => 'bulanan']) }}" class="btn {{ $filter == 'bulanan' ? 'btn-info text-white' : 'btn-outline-info' }} px-4 rounded-pill">
                        Bulan Ini
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-header bg-transparent border-bottom p-3">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-receipt text-main me-2"></i> Detail Transaksi</h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th class="text-end">Total Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $index => $order)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <span class="fw-semibold font-monospace">{{ $order->order_number }}</span>
                                    </td>
                                    <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle text-muted fs-5 me-2"></i>
                                            {{ $order->user->name ?? 'Kasir Default' }}
                                        </div>
                                    </td>
                                    <td class="text-end fw-bold text-success">
                                        Rp {{ number_format($order->getAttribute('total-price'), 0, ',', '.') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                                        Tidak ada transaksi untuk filter ini.
                                    </td>
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
