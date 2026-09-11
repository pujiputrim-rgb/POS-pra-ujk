@extends('app')

@section('page_title', 'Edit Data User')
@section('page_subtitle', 'Perbarui informasi dan akun pengguna sistem.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}" class="text-decoration-none text-muted-green">Users</a></li>
    <li class="breadcrumb-item active text-main" aria-current="page">Edit User</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label text-muted-green fw-semibold">Nama Lengkap / Label Akun <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Contoh: Admin Utama, Kasir 1, Kasir 2" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="role_id" class="form-label text-muted-green fw-semibold">Role / Hak Akses <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg bg-light border-0 @error('role_id') is-invalid @enderror" id="role_id" name="role_id" required>
                            <option value="">Pilih Role...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="form-label text-muted-green fw-semibold">Alamat Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-lg bg-light border-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="admin@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="password" class="form-label text-muted-green fw-semibold">Password <span class="text-muted fw-normal">(Opsional)</span></label>
                        <input type="password" class="form-control form-control-lg bg-light border-0 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        <div class="form-text text-muted-green mt-2"><i class="bi bi-info-circle me-1"></i> Biarkan kosong jika password tidak ingin diubah.</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-light">
                        <a href="{{ route('user.index') }}" class="btn btn-light px-4 py-2 rounded-3 text-muted-green fw-semibold">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
