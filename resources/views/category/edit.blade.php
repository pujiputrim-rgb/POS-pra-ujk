@extends('app')

@section('page_title', 'Edit Kategori')
@section('page_subtitle', 'Perbarui data kategori produk.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}" class="text-decoration-none text-muted-green">Categories</a></li>
    <li class="breadcrumb-item active text-main" aria-current="page">Edit Kategori</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <form action="{{ route('categories.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="name" class="form-label text-muted-green fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" placeholder="Contoh: Pakaian Pria" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-5">
                        <label for="description" class="form-label text-muted-green fw-semibold">Deskripsi <span class="text-muted fw-normal">(Opsional)</span></label>
                        <textarea class="form-control form-control-lg bg-light border-0 @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Tuliskan deskripsi singkat kategori ini">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-light">
                        <a href="{{ route('categories.index') }}" class="btn btn-light px-4 py-2 rounded-3 text-muted-green fw-semibold">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Update Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
