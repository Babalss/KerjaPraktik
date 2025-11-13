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
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  {{-- Search --}}
  <form method="GET" class="row g-2 mb-3">
    <div class="col-12 col-md-4">
      <input type="text" name="q" value="{{ $q }}" class="form-control"
             placeholder="Cari judul atau slug...">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary">
        <i class="bi bi-search me-1"></i> Cari
      </button>
    </div>
  </form>

  {{-- Card Table --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">

      <div class="table-responsive">
        <table class="table table-hover mb-0 align-middle">
          <thead class="table-light">
            <tr class="text-nowrap">
              <th style="width:70px">ID</th>
              <th>Judul</th>
              <th class="d-none d-md-table-cell">Kategori</th>
              <th class="d-none d-sm-table-cell">Status</th>
              <th class="d-none d-md-table-cell">Publish</th>
              <th class="d-none d-lg-table-cell">Author</th>
              <th class="text-end" style="width:130px">Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse($items as $it)
              <tr>
                {{-- ID --}}
                <td>{{ $it->id }}</td>

                {{-- Judul + Slug --}}
                <td>
                  <div class="fw-semibold text-truncate" style="max-width:320px">
                    {{ $it->title }}
                  </div>

                  <div class="text-muted small text-truncate" style="max-width:320px">
                    {{ $it->slug }}
                  </div>

                  {{-- Mobile: kategori & publish info --}}
                  <div class="d-md-none small text-muted mt-1">
                    {{ optional($it->category)->name ?: '—' }}
                    &nbsp;·&nbsp;
                    {{ $it->published_at ? $it->published_at->format('Y-m-d H:i') : '—' }}
                  </div>
                </td>

                {{-- Kategori --}}
                <td class="d-none d-md-table-cell">
                  {{ optional($it->category)->name ?: '—' }}
                </td>

                {{-- Status --}}
                <td class="d-none d-sm-table-cell">
                  <span class="badge {{ $it->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($it->status) }}
                  </span>
                </td>

                {{-- Publish --}}
                <td class="d-none d-md-table-cell">
                  {{ $it->published_at ? $it->published_at->format('Y-m-d H:i') : '—' }}
                </td>

                {{-- Author --}}
                <td class="d-none d-lg-table-cell">
                  {{ optional($it->author)->name ?: '—' }}
                </td>

                {{-- Aksi --}}
                <td class="text-end">

                  {{-- Desktop --}}
                  <div class="d-none d-md-inline-flex gap-1">
                    <a href="{{ route('admin.blog.posts.edit', $it) }}"
                       class="btn btn-sm btn-outline-primary">
                      <i class="bi bi-pencil-square me-1"></i>Edit
                    </a>

                    <form action="{{ route('admin.blog.posts.destroy', $it) }}"
                          method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger"
                              onclick="return confirm('Hapus post ini?')">
                        <i class="bi bi-trash me-1"></i>Hapus
                      </button>
                    </form>
                  </div>

                  {{-- Mobile (dropdown) --}}
                  <div class="dropdown d-inline-block d-md-none">
                    <button class="btn btn-sm btn-light border"
                            data-bs-toggle="dropdown">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item"
                           href="{{ route('admin.blog.posts.edit', $it) }}">
                          <i class="bi bi-pencil-square me-2"></i>Edit
                        </a>
                      </li>

                      <li>
                        <form action="{{ route('admin.blog.posts.destroy', $it) }}"
                              method="POST">
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
                <td colspan="7" class="text-center text-muted py-5">
                  Belum ada data post.
                </td>
              </tr>
            @endforelse
          </tbody>

        </table>
      </div>

    </div>
  </div>

  {{-- Pagination --}}
  <div class="mt-3">
    {{ $items->links() }}
  </div>
</div>
@endsection
