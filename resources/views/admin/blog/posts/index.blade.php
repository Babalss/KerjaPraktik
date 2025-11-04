@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Daftar Post</h2>
    <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary">+ Tambah Post</a>
  </div>

  <form class="row g-2 mb-3" method="GET">
    <div class="col-auto">
      <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari judul/slug">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary">Cari</button>
    </div>
  </form>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif
  @if($errors->any()) <div class="alert alert-danger">{{ $errors->first() }}</div> @endif

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>#</th>
          <th>Judul</th>
          <th>Kategori</th>
          <th>Status</th>
          <th>Publish</th>
          <th>Author</th>
          <th style="width:160px;"></th>
        </tr>
      </thead>
      <tbody>
        @forelse($items as $it)
        <tr>
          <td>{{ $it->id }}</td>
          <td>
            <div class="fw-semibold">{{ $it->title }}</div>
            <div class="text-muted small">{{ $it->slug }}</div>
          </td>
          <td>{{ optional($it->category)->name ?: '—' }}</td>
          <td>
            <span class="badge {{ $it->status==='published'?'bg-success':'bg-secondary' }}">
              {{ $it->status }}
            </span>
          </td>
          <td>{{ $it->published_at ? $it->published_at->format('Y-m-d H:i') : '—' }}</td>
          <td>{{ optional($it->author)->name ?: '—' }}</td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.blog.posts.edit', $it) }}">Edit</a>
            <form action="{{ route('admin.blog.posts.destroy', $it) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus post ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" class="text-center text-muted">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $items->links() }}
</div>
@endsection
