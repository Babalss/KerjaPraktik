@extends('layouts.app')

@section('content')
<div class="container mt-4">

  {{-- Header + CTA --}}
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h2 class="h4 fw-bold text-primary mb-0">Daftar Post</h2>
    <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> Tambah Post
    </a>
  </div>

  {{-- Alert --}}
  @if (session('ok'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('ok') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      {{ $errors->first() }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Pencarian --}}
  <form class="row g-2 mb-3" method="GET">
    <div class="col-12 col-sm-6 col-md-4">
      <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari judul/slug">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary"><i class="bi bi-search me-1"></i> Cari</button>
    </div>
  </form>

  {{-- Tabel responsif --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive table-responsive-md">
        <table class="table table-sm align-middle mb-0">
          <thead class="table-light">
            <tr class="text-nowrap">
              <th style="width:72px">ID</th>
              <th>Judul</th>
              <th class="d-none d-lg-table-cell">Kategori</th>
              <th class="d-none d-sm-table-cell">Status</th>
              <th class="d-none d-md-table-cell">Publish</th>
              <th class="d-none d-lg-table-cell">Author</th>
              <th class="text-end" style="width:140px">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse($items as $it)
              <tr>
                <td>{{ $it->id }}</td>

                <td>
                  <div class="fw-semibold text-truncate" style="max-width:320px">{{ $it->title }}</div>
                  <div class="text-muted small text-truncate" style="max-width:320px">{{ $it->slug }}</div>

                  {{-- Info ringkas untuk layar kecil --}}
                  <div class="d-sm-none mt-1 small text-muted">
                    {{ $it->published_at ? $it->published_at->format('Y-m-d H:i') : '—' }}
                    · {{ optional($it->category)->name ?: '—' }}
                  </div>
                </td>

                <td class="d-none d-lg-table-cell">
                  {{ optional($it->category)->name ?: '—' }}
                </td>

                <td class="d-none d-sm-table-cell">
                  <span class="badge {{ $it->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($it->status) }}
                  </span>
                </td>

                <td class="d-none d-md-table-cell">
                  {{ $it->published_at ? $it->published_at->format('Y-m-d H:i') : '—' }}
                </td>

                <td class="d-none d-lg-table-cell">
                  {{ optional($it->author)->name ?: '—' }}
                </td>

                <td class="text-end">
                  {{-- Desktop: tombol langsung --}}
                  <div class="d-none d-md-inline-flex gap-1">
                    <a href="{{ route('admin.blog.posts.edit', $it) }}" class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil-square me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.blog.posts.destroy', $it) }}" method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger"
                              onclick="return confirm('Hapus post ini?')">
                        <i class="bi bi-trash me-1"></i> Hapus
                      </button>
                    </form>
                  </div>

                  {{-- Mobile: dropdown ⋮ --}}
                  <div class="dropdown position-static d-inline-block d-md-none">
                    <button class="btn btn-sm btn-light border"
                            data-bs-toggle="dropdown"
                            data-bs-display="static"
                            aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="{{ route('admin.blog.posts.edit', $it) }}">
                          <i class="bi bi-pencil-square me-2"></i>Edit
                        </a>
                      </li>
                      <li>
                        <form action="{{ route('admin.blog.posts.destroy', $it) }}" method="POST" class="m-0">
                          @csrf @method('DELETE')
                          <button class="dropdown-item text-danger"
                                  onclick="return confirm('Hapus post ini?')">
                            <i class="bi bi-trash me-2"></i>Hapus
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-5">Belum ada data.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="mt-3">
    {{ $items->links() }}
  </div>
</div>
@endsection
