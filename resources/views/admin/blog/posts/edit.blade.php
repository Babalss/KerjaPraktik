@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <h2 class="h4 fw-bold text-primary mb-3">Edit Post</h2>

  @if ($errors->any())
    <div class="alert alert-danger">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('admin.blog.posts.update', $item) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- Kategori --}}
    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="category_id" class="form-select" required>
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
      <input type="text" name="title" id="title" class="form-control"
             value="{{ old('title', $item->title) }}" required>
      @error('title') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Slug (otomatis) --}}
    <div class="mb-3">
      <label class="form-label">
        Slug <small class="text-muted">(otomatis dari judul)</small>
      </label>
      <input type="text" id="slug" class="form-control bg-light"
             value="{{ $item->slug }}" readonly>
    </div>

    {{-- Deskripsi Singkat --}}
    <div class="mb-3">
      <label class="form-label">Deskripsi Singkat</label>
      <input type="text" name="excerpt" class="form-control"
             value="{{ old('excerpt', $item->excerpt) }}">
      @error('excerpt') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Gambar Hero --}}
    <div class="mb-3">
      <label class="form-label">Gambar Hero</label>

      @if($item->hero_image)
        <div class="mb-2">
          <p class="mb-1">Gambar saat ini:</p>
          <img src="{{ asset('storage/' . $item->hero_image) }}"
               alt="Hero Image"
               class="img-fluid rounded"
               style="max-height: 250px;">
        </div>
      @endif

      <input type="file" name="hero_image" class="form-control" accept="image/*">
      <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar (maks 2MB).</small>
      @error('hero_image') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Konten --}}
    <div class="mb-3">
      <label class="form-label">Konten</label>
      <textarea name="content" id="content" rows="10" class="form-control">{{ old('content', $item->content) }}</textarea>
      @error('content') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Status & Tanggal Publish --}}
    <div class="row g-3 mb-3">
      <div class="col-md-4">
        <label class="form-label">Status</label>
        <select name="status" class="form-select">
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
    </div>

    {{-- Tag --}}
    <div class="mb-3">
      <label class="form-label mb-1">Tag</label>
      @include('admin.blog.posts.partials.tag-checkboxes', [
          'tags' => $tags,
          'selected' => old('tag_ids', $selectedTags ?? []),
      ])
    </div>

    {{-- Tombol --}}
    <div class="mt-4 d-flex gap-2">
      <button class="btn btn-success">Perbarui</button>
      <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary">Batal</a>
    </div>
  </form>
</div>
@endsection

@push('scripts')
{{-- TinyMCE --}}
<script src="https://cdn.tiny.cloud/1/g8sj7rpnrw3pkspmrzeykdovf6255aetyfor0zlake1bsex2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  // TinyMCE
  tinymce.init({
    selector: '#content',
    menubar: true,
    plugins: 'advlist autolink lists link image charmap preview anchor ' +
             'searchreplace visualblocks code fullscreen insertdatetime media table help wordcount',
    toolbar: 'undo redo | styles | bold italic underline forecolor backcolor | ' +
             'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ' +
             'link image media table | removeformat | help',
    toolbar_mode: 'floating',
    branding: false,
    height: 450,
    style_formats: [
      { title: 'Heading 1', block: 'h1' },
      { title: 'Heading 2', block: 'h2' },
      { title: 'Heading 3', block: 'h3' },
      { title: 'Paragraph', block: 'p' }
    ],
    content_style: `
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
      body { font-family: 'Poppins', sans-serif; font-size: 1rem; line-height: 1.7; color: #212529; }
      h1, h2, h3 { font-weight: 600; margin-top: 1.2em; border-bottom: 2px solid #4b4ded33; padding-bottom: .25rem; }
      ul, ol { margin-left: 1.2rem; }
    `,
  });

  // Fungsi slug: "PLN Asuransi" => "pln-asuransi"
  function toSlug(str) {
    return str
      .toString()
      .toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9\s-]/g, '')
      .trim()
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
  }

  const titleInput = document.querySelector('#title');
  const slugInput  = document.querySelector('#slug');

  if (titleInput && slugInput) {
    titleInput.addEventListener('input', () => {
      slugInput.value = toSlug(titleInput.value);
    });
  }
});
</script>
@endpush
