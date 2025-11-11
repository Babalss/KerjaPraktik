@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2>Edit Kategori Produk</h2>

  <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
      <label class="form-label">Nama Kategori</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Slug (opsional)</label>
      <input type="text" name="slug" class="form-control" value="{{ old('slug', $category->slug) }}" placeholder="otomatis jika dikosongkan">
      @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
      @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Perbarui</button>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
