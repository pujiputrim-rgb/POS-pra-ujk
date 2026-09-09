@extends('app')

@section('page_title', 'Tambah Role')
@section('page_subtitle', 'Masukkan data role baru ke dalam sistem.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}" class="text-decoration-none text-muted-green">Roles</a></li>
    <li class="breadcrumb-item active text-main" aria-current="page">Tambah Role</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-5">
                        <label for="name" class="form-label text-muted-green fw-semibold">Nama Role <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Contoh: Administrator, Kasir, Manajer" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-light">
                        <a href="{{ route('roles.index') }}" class="btn btn-light px-4 py-2 rounded-3 text-muted-green fw-semibold">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Simpan Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
