@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2 class="mb-3">Edit Kategori Blog</h2>

  <form action="{{ route('admin.blog.categories.update', $item) }}" method="POST" novalidate>
    @csrf
    @method('PUT')

    {{-- Nama Kategori --}}
    <div class="mb-3">
      <label class="form-label">Nama Kategori</label>
      <input type="text"
             name="name"
             class="form-control @error('name') is-invalid @enderror"
             value="{{ old('name', $item->name) }}"
             required
             autofocus>
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    {{-- Slug (opsional) --}}
    <div class="mb-3">
      <label class="form-label">Slug <small class="text-muted">(otomatis jika dikosongkan)</small></label>
      <input type="text"
             name="slug"
             class="form-control @error('slug') is-invalid @enderror"
             value="{{ old('slug', $item->slug) }}"
             placeholder="otomatis jika dikosongkan">
      @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-success">Perbarui</button>
      <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const nameEl = document.querySelector('input[name="name"]');
  const slugEl = document.querySelector('input[name="slug"]');

  if (!nameEl || !slugEl) return;

  // Flag: ketika user menyentuh field slug, jangan auto-override
  let slugDirty = slugEl.value.trim().length > 0;
  slugEl.addEventListener('input', () => { slugDirty = true; });

  const slugify = (s) => s.toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
      .replace(/[^a-z0-9]+/g,'-')
      .replace(/^-+|-+$/g,'')
      .replace(/-+/g,'-')
      .slice(0,190);

  nameEl.addEventListener('input', () => {
    if (!slugDirty) slugEl.value = slugify(nameEl.value);
  });
});
</script>
@endpush
