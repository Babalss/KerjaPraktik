@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2>Tambah Tag Blog</h2>

  <form action="{{ route('admin.blog.tags.store') }}" method="POST">
    @csrf

    {{-- Nama Tag --}}
    <div class="mb-3">
      <label class="form-label">Nama Tag</label>
      <input type="text" name="name" class="form-control" value="{{ old('name') }}" required autofocus>
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Slug --}}
    <div class="mb-3">
      <label class="form-label">Slug (opsional)</label>
      <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="otomatis jika dikosongkan">
      @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Tombol --}}
    <div class="mt-3">
      <button type="submit" class="btn btn-success">Simpan</button>
      <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
{{-- Auto-slug generator --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const nameInput = document.querySelector('input[name="name"]');
  const slugInput = document.querySelector('input[name="slug"]');

  nameInput.addEventListener('input', function () {
    const slug = nameInput.value
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)/g, '');
    slugInput.value = slug;
  });
});
</script>
@endpush
