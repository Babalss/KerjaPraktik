<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'PLN Insurance - Admin Panel')</title>

  {{-- Bootstrap & Icons --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  {{-- CSS kustom (lokasi di public/css) --}}
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  {{-- (opsional) tempat push style tambahan --}}
  @stack('styles')

  {{-- font --}}
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>
  {{-- Sidebar --}}
  <aside id="sidebar" class="sidebar">
    <div class="sidebar-inner">
      <div class="brand d-flex align-items-center gap-2">
        <svg width="30" height="30" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M12 2L2 7h20L12 2z" fill="white"/>
          <path d="M2 9v11h20V9H2z" fill="white" opacity="0.95"/>
        </svg>
        <div class="d-flex flex-column lh-sm">
          <h5 class="mb-0 fw-bold text-white">
            PLN <span class="fw-bold text-white">Insurance</span>
          </h5>
          <small class="text-white-50">Admin Panel</small>
        </div>
      </div>

      <nav class="nav-section">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
          <i class="bi bi-speedometer2"></i> <span class="ms-2">Dashboard</span>
        </a>

        {{-- Produk --}}
        @php $productMenuActive = request()->is('admin/products*') || request()->is('admin/categories*'); @endphp
        <div class="group">
          <a class="nav-link d-flex justify-content-between align-items-center {{ $productMenuActive ? 'active' : '' }}"
             data-bs-toggle="collapse" href="#productsMenu"
             aria-expanded="{{ $productMenuActive ? 'true' : 'false' }}">
            <span><i class="bi bi-box-seam me-2"></i> Produk</span>
            <i class="bi bi-chevron-down small"></i>
          </a>
          <div id="productsMenu" class="collapse submenu {{ $productMenuActive ? 'show' : '' }}">
            <a href="{{ route('admin.products.index') }}"
               class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
              <i class="bi bi-box me-2"></i> Semua Produk
            </a>
            <a href="{{ route('admin.categories.index') }}"
               class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
              <i class="bi bi-tags me-2"></i> Kategori
            </a>
          </div>
        </div>

        {{-- Blog --}}
        @php $blogMenuActive = request()->is('admin/blog*'); @endphp
        <div class="group">
          <a class="nav-link d-flex justify-content-between align-items-center {{ $blogMenuActive ? 'active' : '' }}"
             data-bs-toggle="collapse" href="#blogMenu"
             aria-expanded="{{ $blogMenuActive ? 'true' : 'false' }}">
            <span><i class="bi bi-journal-text me-2"></i> Blog</span>
            <i class="bi bi-chevron-down small"></i>
          </a>
          <div id="blogMenu" class="collapse submenu {{ $blogMenuActive ? 'show' : '' }}">
            <a href="{{ route('admin.blog.posts.index') }}"
               class="nav-link {{ request()->is('admin/blog/posts*') ? 'active' : '' }}">
              <i class="bi bi-file-earmark-text me-2"></i> Postingan
            </a>
            <a href="{{ route('admin.blog.categories.index') }}"
               class="nav-link {{ request()->is('admin/blog/categories*') ? 'active' : '' }}">
              <i class="bi bi-journal-bookmark me-2"></i> Kategori
            </a>
            <a href="{{ route('admin.blog.tags.index') }}"
               class="nav-link {{ request()->is('admin/blog/tags*') ? 'active' : '' }}">
              <i class="bi bi-tags me-2"></i> Tag
            </a>
          </div>
        </div>
      </nav>
    </div>
  </aside>

  {{-- Overlay (mobile) --}}
  <div id="overlay" class="overlay" aria-hidden="true"></div>

  {{-- Navbar --}}
  <header class="app-navbar">
    <button id="menu-toggle" class="toggler-btn d-lg-none" aria-label="Buka menu">
      <i class="bi bi-list"></i>
    </button>

    <div class="brand-sm d-lg-none text-white fw-semibold">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M12 2L2 7h20L12 2z"/>
        <path d="M2 9v11h20V9z" opacity="0.9"/>
      </svg>
      PLN Insurance
    </div>

    <div class="ms-auto dropdown">
      <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
        <i class="bi bi-person-circle fs-4 text-primary"></i>
        <span class="ms-2 d-none d-md-inline text-dark">{{ Auth::user()->name ?? 'Administrator' }}</span>
      </a>
      <ul class="dropdown-menu dropdown-menu-end shadow-sm">
        <li><a class="dropdown-item" href="#">Profil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="{{ route('logout') }}" method="POST" class="m-0">@csrf
            <button class="dropdown-item text-danger" type="submit">
              <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </div>
  </header>

  {{-- Konten --}}
  <main class="content">
    @yield('content')
  </main>

  <footer class="app-footer">
    © {{ date('Y') }} PLN Insurance. All rights reserved.
  </footer>

  {{-- Bootstrap Bundle --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  {{-- JS kustom --}}
  <script src="{{ asset('js/app.js') }}"></script>

  {{-- INI PENTING: tempat semua @push('scripts') dari halaman --}}
  @stack('scripts')
</body>
</html>
