@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2>Edit Kategori Produk</h2>

  <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Nama --}}
    <div class="mb-3">
      <label for="name" class="form-label">Nama Kategori</label>
      <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
      @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Slug (readonly, auto) --}}
    <div class="mb-3">
      <label for="slug" class="form-label">Slug</label>
      <input type="text" id="slug" class="form-control" value="{{ \Illuminate\Support\Str::slug(old('name', $category->name)) }}" readonly>
      <small class="text-muted">Slug akan mengikuti nama kategori saat disimpan.</small>
    </div>

    {{-- Thumbnail --}}
    <div class="mb-3">
      <label class="form-label">Thumbnail (jpg/png/webp, maks 2MB)</label>
      @if($category->thumbnail)
        <div class="mb-2">
          <img src="{{ Storage::url($category->thumbnail) }}" class="img-fluid rounded border" style="max-height:160px" alt="Thumbnail">
        </div>
      @endif
      <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
      <small class="text-muted">Kosongkan jika tidak ingin mengubah.</small>
      @error('thumbnail') <div class="text-danger small">{{ $message }}</div> @enderror

      <div class="mt-2" id="thumbPreviewWrap" style="display:none">
        <img id="thumbPreview" class="img-fluid rounded border" style="max-height:160px" alt="Preview">
      </div>
    </div>

    {{-- Deskripsi --}}
    <div class="mb-3">
      <label for="description" class="form-label">Deskripsi</label>
      <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
      @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mt-3">
      <button type="submit" class="btn btn-primary">Perbarui</button>
      <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const nameEl = document.getElementById('name');
  const slugEl = document.getElementById('slug');
  const input  = document.getElementById('thumbnail');
  const wrap   = document.getElementById('thumbPreviewWrap');
  const img    = document.getElementById('thumbPreview');

  const slugify = s => s
    .toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
    .replace(/[^a-z0-9]+/g,'-')
    .replace(/(^-|-$)/g,'')
    .replace(/-+/g,'-');

  const update = () => slugEl.value = slugify(nameEl.value || '');
  nameEl.addEventListener('input', update);
  update();

  if (input) {
    input.addEventListener('change', e => {
      const f = e.target.files?.[0];
      if (!f) return;
      const url = URL.createObjectURL(f);
      img.src = url; wrap.style.display = 'block';
    });
  }
});
</script>
@endpush
