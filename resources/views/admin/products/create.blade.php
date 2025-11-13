@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <h2>Tambah Produk Asuransi</h2>

  <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Kategori --}}
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

    {{-- Nama & Slug --}}
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

    {{-- Thumbnail --}}
    <div class="mb-3">
      <label class="form-label">Thumbnail (jpg/png/webp, maks 2MB)</label>
      <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*">
      @error('thumbnail') <div class="text-danger small">{{ $message }}</div> @enderror

      <div class="mt-2" id="thumbPreviewWrap" style="display:none">
        <img id="thumbPreview" class="img-fluid rounded border" style="max-height:160px" alt="Preview">
      </div>
    </div>

    {{-- Deskripsi Singkat --}}
    <div class="mb-3">
      <label for="short_description" class="form-label">Deskripsi Singkat</label>
      <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('short_description') }}">
      @error('short_description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Deskripsi Lengkap (WYSIWYG) --}}
    <div class="mb-3">
      <label for="long_description" class="form-label">Deskripsi Lengkap</label>
      <textarea name="long_description" id="long_description" rows="8" class="form-control">{{ old('long_description') }}</textarea>
      @error('long_description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    {{-- Status --}}
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
  // Auto-slug
  const nameEl = document.getElementById('name');
  const slugEl = document.getElementById('slug');
  const slugify = s => s.toLowerCase()
    .normalize('NFD').replace(/[\u0300-\u036f]/g,'')
    .replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'').replace(/-+/g,'-');
  let dirty = (slugEl.value.trim().length > 0);
  slugEl.addEventListener('input', () => dirty = slugEl.value.trim().length > 0);
  nameEl.addEventListener('input', () => { if(!dirty) slugEl.value = slugify(nameEl.value); });

  // Preview thumbnail
  const input = document.getElementById('thumbnail');
  const wrap  = document.getElementById('thumbPreviewWrap');
  const img   = document.getElementById('thumbPreview');
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

{{-- TinyMCE WYSIWYG --}}
<script src="https://cdn.tiny.cloud/1/g8sj7rpnrw3pkspmrzeykdovf6255aetyfor0zlake1bsex2/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Pastikan elemen ada
  if (!document.querySelector('#long_description')) return;

  tinymce.init({
    selector: '#long_description',
    menubar: true,
    plugins: 'advlist autolink lists link image charmap preview anchor ' +
             'searchreplace visualblocks code fullscreen insertdatetime media table help wordcount autoresize',
    toolbar: 'undo redo | styles | bold italic underline forecolor backcolor | ' +
             'alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | ' +
             'link image media table | removeformat | help',
    toolbar_mode: 'sliding',          // lebih enak di layar kecil
    branding: false,

    // --- bikin aman di mobile ---
    height: 450,                      // initial height
    min_height: 280,                  // jaga jangan collapse
    autoresize_bottom_margin: 20,     // ruang bawah saat ngetik
    resize: true,                     // user bisa tarik ukuran

    mobile: {
      menubar: false,                 // sederhanakan toolbar di mobile
      toolbar_mode: 'sliding',
      plugins: 'advlist autolink lists link image table autoresize',
      toolbar: 'undo redo | styles | bold italic underline | bullist numlist | link image table'
    },

    // tampilan (Poppins)
    content_style: `
      @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
      body { font-family: 'Poppins', sans-serif; font-size: 1rem; line-height: 1.7; color: #212529; }
      h1, h2, h3 { font-weight: 600; margin-top: 1.2em; border-bottom: 2px solid #4b4ded33; padding-bottom: .25rem; }
      ul, ol { margin-left: 1.2rem; }
    `,
  });
});
</script>

<style>
/* jaga-jaga biar nggak kepotong di container responsif */
.tox.tox-tinymce { max-width: 100% !important; }
.tox .tox-editor-container { min-height: 260px; }
</style>
@endpush
