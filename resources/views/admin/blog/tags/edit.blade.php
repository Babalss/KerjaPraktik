@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2>Edit Tag Blog</h2>

  <form action="{{ route('admin.blog.tags.update', $item) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Nama Tag --}}
    <div class="mb-3">
      <label class="form-label">Nama Tag</label>
      <input type="text" name="name" class="form-control" value="{{ old('name', $item->name) }}" required autofocus>
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Slug --}}
    <div class="mb-3">
      <label class="form-label">Slug (opsional)</label>
      <input type="text" name="slug" class="form-control" value="{{ old('slug', $item->slug) }}" placeholder="otomatis jika dikosongkan">
      @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Tombol --}}
    <div class="mt-3">
      <button type="submit" class="btn btn-success">Perbarui</button>
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
    if (!slugInput.value || slugInput.value === '' || slugInput === document.activeElement) {
      const slug = nameInput.value
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)/g, '');
      slugInput.value = slug;
    }
  });
});
</script>
@endpush
