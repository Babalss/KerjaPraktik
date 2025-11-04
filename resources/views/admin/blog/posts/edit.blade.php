@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2>Edit Post</h2>

  <form action="{{ route('admin.blog.posts.update', $item) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Kategori --}}
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="category_id" class="form-control" required>
        <option value="">-- Pilih Kategori --</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" @selected(old('category_id', $item->category_id) == $cat->id)>
            {{ $cat->name }}
          </option>
        @endforeach
      </select>
      @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Judul --}}
    <div class="mb-3">
      <label class="form-label">Judul</label>
      <input type="text" name="title" class="form-control" value="{{ old('title', $item->title) }}" required>
      @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Slug --}}
    <div class="mb-3">
      <label class="form-label">Slug</label>
      <input type="text" name="slug" class="form-control" value="{{ old('slug', $item->slug) }}" required>
      @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Deskripsi Singkat --}}
    <div class="mb-3">
      <label class="form-label">Deskripsi Singkat</label>
      <input type="text" name="excerpt" class="form-control" value="{{ old('excerpt', $item->excerpt) }}">
    </div>

 {{-- Upload Gambar & Preview --}}
<div class="mb-3">
  <label class="form-label">Gambar Hero</label>

  {{-- Preview gambar lama jika ada --}}
  @if($item->hero_image)
    <div class="mb-2">
      <p class="mb-1">Gambar saat ini:</p>
      <img src="{{ asset('storage/' . $item->hero_image) }}" 
           alt="Hero Image" 
           class="img-fluid rounded shadow-sm" 
           style="max-height: 250px;">
    </div>
  @endif

  {{-- Input upload baru --}}
  <input type="file" name="hero_image" class="form-control" accept="image/*">
  <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
  @error('hero_image') <div class="text-danger small">{{ $message }}</div> @enderror
</div>



    {{-- Konten --}}
    <div class="mb-3">
      <label class="form-label">Konten</label>
      <textarea name="content" rows="6" class="form-control">{{ old('content', $item->content) }}</textarea>
      @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Status, Tanggal, Tag --}}
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-control">
          <option value="draft" @selected(old('status', $item->status) === 'draft')>Draft</option>
          <option value="published" @selected(old('status', $item->status) === 'published')>Published</option>
        </select>
        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
      </div>

      <div class="col-md-4">
        <label class="form-label">Tanggal Publish (opsional)</label>
        <input type="datetime-local" name="published_at"
               value="{{ old('published_at', $item->published_at ? $item->published_at->format('Y-m-d\TH:i') : '') }}"
               class="form-control">
      </div>

      <div class="col-md-4">
        <label class="form-label">Tag</label>
        <select name="tag_ids[]" class="form-control" multiple>
          @foreach($tags as $t)
            <option value="{{ $t->id }}" @if(isset($selectedTags) && in_array($t->id, $selectedTags)) selected @endif>
              {{ $t->name }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    {{-- Tombol --}}
    <div class="mt-3">
      <button class="btn btn-success">Perbarui</button>
      <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection
