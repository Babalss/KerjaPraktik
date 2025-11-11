@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Tambah Produk Asuransi</h2>

    <form action="{{ route('admin.products.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="category_id" class="form-label">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug (opsional)</label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="otomatis jika dikosongkan">
            @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="short_description" class="form-label">Deskripsi Singkat</label>
            <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('short_description') }}">
            @error('short_description') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="long_description" class="form-label">Deskripsi Lengkap</label>
            <textarea name="long_description" id="long_description" rows="4" class="form-control">{{ old('long_description') }}</textarea>
            @error('long_description') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="active" @selected(old('status','active')==='active')>Aktif</option>
                <option value="inactive" @selected(old('status')==='inactive')>Nonaktif</option>
            </select>
            @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const nameEl = document.getElementById('name');
  const slugEl = document.getElementById('slug');
  if(!nameEl || !slugEl) return;

  // hanya auto-isi jika slug belum diisi user
  let dirty = slugEl.value.trim().length > 0;
  slugEl.addEventListener('input', () => dirty = slugEl.value.trim().length > 0);

  const slugify = s => s.toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
    .replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'').replace(/-+/g,'-');

  nameEl.addEventListener('input', () => { if(!dirty) slugEl.value = slugify(nameEl.value); });
});
</script>
@endpush
