@extends('app')

@section('page_title', 'Tambah User Baru')
@section('page_subtitle', 'Masukkan data pengguna baru ke dalam sistem.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-decoration-none text-muted-green">Users</a></li>
    <li class="breadcrumb-item active text-main" aria-current="page">Tambah User</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <form action="{{ route('user.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="form-label text-muted-green fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted-green fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="admin@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="form-label text-muted-green fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 8 karakter" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-light">
                        <a href="{{ route('user.index') }}" class="btn btn-light px-4 py-2 rounded-3 text-muted-green fw-semibold">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
