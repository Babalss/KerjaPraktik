@extends('layouts.app')

@section('content')
<div class="container mt-4">

  {{-- Header + CTA --}}
  <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h2 class="h4 fw-bold text-primary mb-0">Daftar Produk Asuransi</h2>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> Tambah Produk
    </a>
  </div>

  {{-- Alerts --}}
  @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  {{-- Pencarian --}}
  <form class="row g-2 mb-3" method="GET">
    <div class="col-12 col-sm-6 col-md-4">
      <input type="text" name="q" value="{{ $q }}" class="form-control" placeholder="Cari nama/slug/deskripsi">
    </div>
    <div class="col-auto">
      <button class="btn btn-outline-secondary">
        <i class="bi bi-search me-1"></i> Cari
      </button>
    </div>
  </form>

  {{-- Tabel responsif + aksi dropdown di mobile --}}
  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive table-responsive-md">
        <table class="table table-sm align-middle mb-0">
          <thead class="table-light">
            <tr class="text-nowrap">
              <th style="width:72px">ID</th>
              <th>Nama</th>
              <th class="d-none d-sm-table-cell">Kategori</th>
              <th>Status</th>
              <th class="text-end" style="width:120px">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($products as $product)
              <tr>
                <td>{{ $product->id }}</td>

                <td class="text-truncate" style="max-width:260px">
                  <div class="fw-semibold">{{ $product->name }}</div>
                  <div class="small text-muted d-sm-none text-truncate">
                    {{ $product->category->name ?? '-' }}
                  </div>
                </td>

                <td class="d-none d-sm-table-cell">
                  {{ $product->category->name ?? '-' }}
                </td>

                <td>
                  @php
                    $isActive = in_array(strtolower($product->status), ['active','aktif','1',1,true], true);
                  @endphp
                  <span class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }}">
                    {{ ucfirst($product->status) }}
                  </span>
                </td>

                <td class="text-end">
                  {{-- Desktop --}}
                  <div class="d-none d-md-inline-flex gap-1">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline">
                      @csrf @method('DELETE')
                      <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                    </form>
                  </div>

                  {{-- Mobile: dropdown ⋮ --}}
                  <div class="dropdown position-static d-inline-block d-md-none">
                    <button
                      class="btn btn-sm btn-light border"
                      data-bs-toggle="dropdown"
                      data-bs-display="static"
                      aria-expanded="false">
                      <i class="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                        <a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">Edit</a>
                      </li>
                      <li>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="m-0">
                          @csrf @method('DELETE')
                          <button class="dropdown-item text-danger" onclick="return confirm('Yakin hapus produk ini?')">
                            Hapus
                          </button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted py-5">Belum ada produk.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  {{-- Pagination --}}
  <div class="mt-3">
    {{ $products->links() }}
  </div>

</div>
@endsection
  