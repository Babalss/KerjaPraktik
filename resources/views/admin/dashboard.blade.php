@extends('layouts.app')

@section('content')
<div class="container-fluid">
  {{-- Header --}}
  <div class="row mb-4 align-items-center">
    <div class="col">
      <h2 class="fw-bold text-primary mb-0">Dashboard</h2>
      <p class="text-muted mb-0">Selamat datang di sistem manajemen <strong>PLN Insurance</strong></p>
    </div>
  </div>

  {{-- Statistik Cards --}}
  <div class="row g-3">

    {{-- ===== Kategori Produk ===== --}}
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted mb-1">Total Kategori Produk</h6>
            <h3 class="fw-bold text-primary mb-0">{{ $categoryCount }}</h3>
          </div>
          <div class="icon-circle bg-primary bg-opacity-10">
            <i class="bi bi-tags text-primary"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Produk ===== --}}
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted mb-1">Total Produk</h6>
            <h3 class="fw-bold text-success mb-0">{{ $productCount }}</h3>
          </div>
          <div class="icon-circle bg-success bg-opacity-10">
            <i class="bi bi-box-seam text-success"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== User Aktif ===== --}}
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted mb-1">User Aktif</h6>
            <h3 class="fw-bold text-warning mb-0">{{ $user ? 1 : 0 }}</h3>
          </div>
          <div class="icon-circle bg-warning bg-opacity-10">
            <i class="bi bi-person-check text-warning"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Kategori Blog ===== --}}
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted mb-1">Total Kategori Blog</h6>
            <h3 class="fw-bold text-info mb-0">{{ $blogCategoryCount }}</h3>
          </div>
          <div class="icon-circle bg-info bg-opacity-10">
            <i class="bi bi-journal-bookmark text-info"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Tag Blog ===== --}}
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted mb-1">Total Tag Blog</h6>
            <h3 class="fw-bold text-secondary mb-0">{{ $blogTagCount }}</h3>
          </div>
          <div class="icon-circle bg-secondary bg-opacity-10">
            <i class="bi bi-tags-fill text-secondary"></i>
          </div>
        </div>
      </div>
    </div>

    {{-- ===== Postingan Blog ===== --}}
    <div class="col-12 col-md-6 col-lg-4">
      <div class="card border-0 shadow-sm h-100">
        <div class="card-body d-flex align-items-center justify-content-between">
          <div>
            <h6 class="text-muted mb-1">Total Postingan Blog</h6>
            <h3 class="fw-bold text-danger mb-0">{{ $blogPostCount }}</h3>
          </div>
          <div class="icon-circle bg-danger bg-opacity-10">
            <i class="bi bi-file-earmark-text text-danger"></i>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
