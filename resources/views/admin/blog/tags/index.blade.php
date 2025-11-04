@extends('layouts.app')
@section('content')
<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Tag Blog</h2>
    <a href="{{ route('admin.blog.tags.create') }}" class="btn btn-primary">+ Tambah Tag</a>
  </div>

  <form class="row g-2 mb-3" method="GET">
    <div class="col-auto">
      <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari tag">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary">Cari</button>
    </div>
  </form>

  @if(session('ok')) <div class="alert alert-success">{{ session('ok') }}</div> @endif

  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead><tr><th>#</th><th>Nama</th><th>Slug</th><th style="width:140px;"></th></tr></thead>
      <tbody>
        @forelse($items as $it)
        <tr>
          <td>{{ $it->id }}</td>
          <td>{{ $it->name }}</td>
          <td class="text-muted">{{ $it->slug }}</td>
          <td class="text-end">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.blog.tags.edit',$it) }}">Edit</a>
            <form action="{{ route('admin.blog.tags.destroy',$it) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tag?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger">Hapus</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted">Belum ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $items->links() }}
</div>
@endsection
