@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Tambah Kategori Produk</h2>

    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf

        {{-- Nama Kategori --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama Kategori</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                class="form-control" 
                value="{{ old('name') }}" 
                required
                autofocus>
            @error('name') 
                <div class="text-danger small">{{ $message }}</div> 
            @enderror
        </div>

        {{-- Slug (opsional, akan otomatis jika dikosongkan) --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug (opsional)</label>
            <input 
                type="text" 
                name="slug" 
                id="slug" 
                class="form-control" 
                value="{{ old('slug') }}" 
                placeholder="otomatis jika dikosongkan">
            @error('slug') 
                <div class="text-danger small">{{ $message }}</div> 
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea 
                name="description" 
                id="description" 
                class="form-control" 
                rows="3">{{ old('description') }}</textarea>
            @error('description') 
                <div class="text-danger small">{{ $message }}</div> 
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const nameInput = document.querySelector('input[name="name"]');
    const slugInput = document.querySelector('input[name="slug"]');

    // Auto-generate slug dari nama
    nameInput.addEventListener('input', function () {
        if (!slugInput.value) {
            slugInput.value = nameInput.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
        }
    });
});
</script>
@endpush
