@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold text-primary mb-0">Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang di sistem manajemen <strong>PLN Asuransi</strong></p>
        </div>
    </div>

    <div class="row g-3">
        {{-- Kartu Kategori --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Total Kategori</h6>
                        <h3 class="fw-bold text-primary mb-0">{{ $categoryCount }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-tags text-primary fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu Produk --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">Total Produk</h6>
                        <h3 class="fw-bold text-success mb-0">{{ $productCount }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-box-seam text-success fs-2"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kartu User Aktif --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">User Aktif</h6>
                        <h3 class="fw-bold text-warning mb-0">{{ $user ? 1 : 0 }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                        <i class="bi bi-person-check text-warning fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
