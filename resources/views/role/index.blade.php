@extends('app')

@section('page_title', 'Data Role')
@section('page_subtitle', 'Manajemen daftar hak akses (role) pengguna sistem.')

@section('breadcrumb')
    <li class="breadcrumb-item active text-main" aria-current="page">Roles</li>
@endsection

@section('content')
<div class="table-card-custom">
    <!-- Header Controls -->
    <div class="table-header-control">
        <div class="table-search-box border-0 bg-transparent">
            <h5 class="mb-0 text-dark"><i class="bi bi-shield-lock-fill me-2 text-primary"></i>Daftar Role</h5>
        </div>
        <div class="table-filter-group">
            <a href="{{ route('roles.create') }}" class="btn-table-action bg-primary text-white text-decoration-none border-0 shadow-sm">
                <i class="bi bi-plus-lg"></i> Tambah Role
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
                    <th style="width: 15%">ID Role</th>
                    <th>Nama Role</th>
                    <th style="width: 25%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td><span class="text-muted fw-bold">#{{ $role->id }}</span></td>
                    <td class="fw-semibold text-dark">{{ $role->name }}</td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning btn-sm text-white rounded-3 me-1 px-3 shadow-sm" title="Edit">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm rounded-3 px-3 shadow-sm" onclick="return confirm('Yakin hapus role ini?')" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-2 text-light"></i>
                        Belum ada data role yang terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
