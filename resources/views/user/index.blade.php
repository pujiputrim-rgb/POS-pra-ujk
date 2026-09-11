@extends('app')

@section('page_title', 'Data User')
@section('page_subtitle', 'Manajemen informasi dan akun pengguna sistem.')

@section('breadcrumb')
    <li class="breadcrumb-item active text-main" aria-current="page">Users</li>
@endsection

@section('content')
<div class="table-card-custom">
    <!-- Header Controls -->
    <div class="table-header-control">
        <div class="table-search-box border-0 bg-transparent">
            <h5 class="mb-0 text-dark"><i class="bi bi-people-fill me-2 text-primary"></i>Daftar User</h5>
        </div>
        <div class="table-filter-group">
            <a href="{{ route('user.create') }}" class="btn-table-action bg-primary text-white text-decoration-none border-0 shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah User
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
                    <th>ID User</th>
                    <th>Nama Lengkap / Identitas</th>
                    <th>Role</th>
                    <th>Alamat Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                @php
                    $roleName = $user->role ? $user->role->name : ($user->isKasir() ? 'Kasir' : 'User');
                    $lowerRole = strtolower($roleName);
                @endphp
                <tr>
                    <td><span class="text-muted fw-bold">#{{ $user->id }}</span></td>
                    <td class="fw-semibold text-dark">{{ $user->name }}</td>
                    <td>
                        @if(str_contains($lowerRole, 'admin'))
                            <span class="badge bg-primary text-white rounded-pill px-3 py-1 fw-semibold"><i class="bi bi-shield-lock-fill me-1"></i> Admin</span>
                        @elseif(str_contains($lowerRole, 'kasir') || str_contains($lowerRole, 'cashier'))
                            <span class="badge bg-success text-white rounded-pill px-3 py-1 fw-semibold"><i class="bi bi-cart3 me-1"></i> Kasir</span>
                        @elseif(str_contains($lowerRole, 'pimpinan') || str_contains($lowerRole, 'leader'))
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-semibold"><i class="bi bi-award-fill me-1"></i> Pimpinan</span>
                        @else
                            <span class="badge bg-secondary text-white rounded-pill px-3 py-1 fw-semibold">{{ $roleName }}</span>
                        @endif
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm text-white rounded-3 me-1 px-3 shadow-sm" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-3 px-3 shadow-sm" onclick="return confirm('Yakin hapus user ini?')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-light"></i>
                        Belum ada data user yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
