@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2>Tambah Post</h2>

  <form action="{{ route('admin.blog.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Kategori --}}
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="category_id" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
        @endforeach
      </select>
      @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Judul --}}
    <div class="mb-3">
      <label class="form-label">Judul</label>
      <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
      @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Slug (opsional, otomatis jika dikosongkan) --}}
    <div class="mb-3">
      <label class="form-label">Slug <small class="text-muted">(otomatis jika kosong)</small></label>
      <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="(otomatis)">
      @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Deskripsi Singkat --}}
    <div class="mb-3">
      <label class="form-label">Deskripsi Singkat</label>
      <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt') }}">
    </div>

    {{-- Upload Gambar --}}
    <div class="mb-3">
      <label class="form-label">Gambar Hero</label>
      <input type="file" name="hero_image" class="form-control" accept="image/*">
      @error('hero_image') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Konten --}}
    <div class="mb-3">
      <label class="form-label">Konten</label>
      <textarea name="content" rows="6" class="form-control">{{ old('content') }}</textarea>
      @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Status, Tanggal, Tag --}}
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
          <option value="draft" @selected(old('status') === 'draft')>Draft</option>
          <option value="published" @selected(old('status') === 'published')>Published</option>
        </select>
        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">Tanggal Publish (opsional)</label>
        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="form-control">
      </div>

      <div class="col-md-4">
        <label class="form-label">Tag</label>
        <select name="tag_ids[]" class="form-control" multiple>
          @foreach($tags as $t)
            <option value="{{ $t->id }}" @if(collect(old('tag_ids'))->contains($t->id)) selected @endif>{{ $t->name }}</option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Tombol --}}
    <div class="mt-3">
      <button class="btn btn-success">Simpan</button>
      <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
  // Preview slug otomatis saat mengetik judul (tidak memaksa; user bisa override)
  const toSlug = s => s.toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
    .replace(/[^a-z0-9\s-]/g,'').trim().replace(/\s+/g,'-').replace(/-+/g,'-');
  const $title = document.querySelector('#title');
  const $slug  = document.querySelector('#slug');
  if ($title && $slug) {
    let touched = false;
    $slug.addEventListener('input', ()=> touched = true);
    $title.addEventListener('input', ()=>{
      if (!touched && !$slug.value) $slug.value = toSlug($title.value);
    });
  }
</script>
@endpush
