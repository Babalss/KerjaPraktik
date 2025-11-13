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

  <div class="card border-0 shadow-sm">
    <div class="card-body p-0">
      <div class="table-responsive table-responsive-md">
        <table class="table table-sm align-middle mb-0 table-hover">
          <thead class="table-light">
            <tr class="text-nowrap">
              {{-- Sembunyikan di < sm --}}
              <th class="d-none d-sm-table-cell" style="width:56px">Thumb</th>
              <th class="d-none d-sm-table-cell" style="width:72px">ID</th>

              {{-- Kolom utama yang selalu tampil --}}
              <th>Produk</th>

              {{-- Muncul mulai ≥ sm --}}
              <th class="d-none d-sm-table-cell">Kategori</th>
              <th class="d-none d-sm-table-cell">Status</th>

              <th class="text-end" style="width:160px">Aksi</th>
            </tr>
          </thead>

          <tbody>
          @forelse ($products as $product)
            @php
              $isActive = in_array(strtolower($product->status), ['active','aktif','1',1,true], true);
            @endphp
            <tr>
              {{-- Desktop thumb --}}
              <td class="d-none d-sm-table-cell">
                @if($product->thumbnail)
                  <img src="{{ Storage::url($product->thumbnail) }}" class="rounded" style="height:40px;width:40px;object-fit:cover" alt="Thumb">
                @else
                  <div class="bg-light border rounded" style="height:40px;width:40px;"></div>
                @endif
              </td>

              {{-- Desktop ID --}}
              <td class="d-none d-sm-table-cell">{{ $product->id }}</td>

              {{-- Kolom produk (mobile-first) --}}
              <td>
                <div class="d-flex align-items-center">
                  {{-- Thumb khusus mobile --}}
                  <div class="me-2 d-sm-none">
                    @if($product->thumbnail)
                      <img src="{{ Storage::url($product->thumbnail) }}" class="rounded" style="height:40px;width:40px;object-fit:cover" alt="Thumb">
                    @else
                      <div class="bg-light border rounded" style="height:40px;width:40px;"></div>
                    @endif
                  </div>
                  <div class="min-w-0">
                    <div class="fw-semibold text-truncate" style="max-width:260px">
                      {{ $product->name }}
                    </div>
                    {{-- Info kecil khusus mobile --}}
                    <div class="d-sm-none small text-muted text-truncate" style="max-width:260px">
                      {{ $product->category->name ?? '-' }}
                    </div>
                    <span class="d-inline-block d-sm-none badge mt-1 {{ $isActive ? 'bg-success' : 'bg-secondary' }}">
                      {{ ucfirst($product->status) }}
                    </span>
                  </div>
                </div>
              </td>

              {{-- Desktop kategori --}}
              <td class="d-none d-sm-table-cell text-truncate" style="max-width:220px">
                {{ $product->category->name ?? '-' }}
              </td>

              {{-- Desktop status --}}
              <td class="d-none d-sm-table-cell">
                <span class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }}">
                  {{ ucfirst($product->status) }}
                </span>
              </td>

              {{-- Aksi --}}
              <td class="text-end">
                {{-- Desktop: tombol langsung --}}
                <div class="d-none d-md-inline-flex gap-1">
                  @if (Route::has('products.show'))
                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Kunjungi</a>
                  @endif
                  <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                  <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                  </form>
                </div>

                {{-- Mobile: dropdown ⋮ --}}
                <div class="dropdown position-static d-inline-block d-md-none">
                  <button class="btn btn-sm btn-light border" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    @if (Route::has('products.show'))
                      <li><a class="dropdown-item" target="_blank" href="{{ route('products.show', $product->slug) }}">Kunjungi</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('admin.products.edit', $product->id) }}">Edit</a></li>
                    <li>
                      <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="m-0">
                        @csrf @method('DELETE')
                        <button class="dropdown-item text-danger" onclick="return confirm('Yakin hapus produk ini?')">Hapus</button>
                      </form>
                    </li>
                  </ul>
                </div>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-center text-muted py-5">Belum ada produk.</td></tr>
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
