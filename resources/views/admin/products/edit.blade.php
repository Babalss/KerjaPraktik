@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Edit Produk Asuransi</h2>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ $product->slug }}" required>
        </div>
        <div class="mb-3">
            <label for="short_description" class="form-label">Deskripsi Singkat</label>
            <input type="text" name="short_description" class="form-control" value="{{ $product->short_description }}">
        </div>
        <div class="mb-3">
            <label for="long_description" class="form-label">Deskripsi Lengkap</label>
            <textarea name="long_description" rows="4" class="form-control">{{ $product->long_description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection