@extends('app')

@section('page_title', 'Edit Produk')
@section('page_subtitle', 'Perbarui detail informasi produk di inventaris.')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none text-muted-green">Products</a></li>
    <li class="breadcrumb-item active text-main" aria-current="page">Edit Produk</li>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-5">
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label for="photo" class="form-label text-muted-green fw-semibold">Foto Produk <span class="text-muted fw-normal">(Opsional)</span></label>
                        @if($product->photo)
                            @php
                                $editPhotoUrl = str_starts_with($product->photo, 'http') ? $product->photo : asset('storage/' . ltrim(str_replace('storage/', '', $product->photo), '/'));
                            @endphp
                            <div class="mb-2">
                                <img src="{{ $editPhotoUrl }}" alt="Foto Produk" class="img-thumbnail rounded-3 shadow-sm" style="height: 120px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" class="form-control form-control-lg bg-light border-0 @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                        <div class="form-text text-muted-green mt-2"><i class="bi bi-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF (Maks. 2MB)</div>
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label text-muted-green fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" placeholder="Contoh: Kemeja Flanel, Sabun Cuci" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="form-label text-muted-green fw-semibold">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select form-select-lg bg-light border-0 @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                            <option value="">Pilih Kategori...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="price" class="form-label text-muted-green fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg bg-light border-0 @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-5">
                            <label for="stock" class="form-label text-muted-green fw-semibold">Stok Tersedia <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-lg bg-light border-0 @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top border-light">
                        <a href="{{ route('products.index') }}" class="btn btn-light px-4 py-2 rounded-3 text-muted-green fw-semibold">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Update Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
