<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLN Asuransi - Admin Panel</title>


    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        :root {
            --sidebar-bg: #0b5394;
            --sidebar-accent: #08457e;
            --text-muted: #6c757d;
            --active-sub-bg: rgba(255, 255, 255, 0.15);
        }


        body {
            background: #f5f7fb;
            font-family: "Segoe UI", Roboto, Arial, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }


        /* ===== Sidebar ===== */
        .sidebar {
            width: 240px;
            background: var(--sidebar-bg);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            transition: left .3s ease;
            z-index: 1035;
        }


        .sidebar-inner {
            padding-bottom: 80px;
        }


        /* Logo + nama */
        .sidebar .brand {
            display: flex;
            align-items: center;
            gap: .6rem;
            padding: .9rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(255, 255, 255, 0.04);
        }
        .sidebar .brand h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1rem;
        }


        /* Menu */
        .nav-section {
            padding: .75rem 0;
        }
        .nav-section a, .nav-section .nav-link {
            color: #e7f0ff;
            padding: .65rem 1rem;
            margin: .2rem .7rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .6rem;
            transition: background .15s ease, color .15s ease;
        }
        .nav-section a:hover {
            background: var(--sidebar-accent);
            color: #fff;
        }
        .nav-section a.active {
            background: var(--sidebar-accent);
            color: #fff;
        }


        /* Spacing antar menu */
        .nav-section > a,
        .nav-section > div {
            margin-bottom: .35rem;
        }


        /* Submenu */
        .submenu .nav-link {
            padding-left: 2.3rem;
            font-weight: 500;
            color: #dbe8ff;
            border-radius: 6px;
            margin-bottom: .2rem;
        }
        .submenu .nav-link.active {
            background: var(--active-sub-bg);
            color: #fff;
        }
        .submenu .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
        }


        /* ===== Navbar ===== */
        .navbar {
            position: fixed;
            top: 0;
            left: 240px;
            right: 0;
            height: 60px;
            background: #fff;
            display: flex;
            align-items: center;
            padding: 0 .75rem;
            box-shadow: 0 2px 6px rgba(16, 24, 40, 0.06);
            z-index: 1025;
            transition: left .3s ease;
        }
        .navbar .toggler-btn {
            border: 0;
            background: transparent;
            font-size: 1.5rem;
            color: var(--sidebar-bg);
        }
        .navbar .brand-sm {
            display: none;
            align-items: center;
            font-weight: 700;
            color: var(--sidebar-bg);
        }


        /* ===== Content ===== */
        main.content {
            margin-left: 240px;
            padding: 90px 1rem 100px;
            transition: margin-left .3s ease;
            flex: 1;
        }


        /* ===== Footer ===== */
        footer.app-footer {
            position: fixed;
            bottom: 0;
            left: 240px;
            right: 0;
            background: #fff;
            padding: .8rem;
            border-top: 1px solid #edf0f3;
            text-align: center;
            font-size: .9rem;
            color: var(--text-muted);
            transition: left .3s ease;
            z-index: 1025;
        }


        /* ===== Responsive ===== */
        @media (max-width: 992px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.open {
                left: 0;
            }
            .navbar {
                left: 0;
            }
            main.content {
                margin-left: 0;
                padding-top: 80px;
            }
            footer.app-footer {
                left: 0;
            }
            .navbar .brand-sm {
                display: flex;
                margin-left: .5rem;
            }
            .overlay {
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.45);
                z-index: 1030;
                display: none;
            }
            .overlay.show {
                display: block;
            }
        }
    </style>
</head>


<body>
    {{-- Sidebar --}}
    <aside id="sidebar" class="sidebar">
        <div class="sidebar-inner">
            <div class="brand">
                <svg width="30" height="30" viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                    <rect width="24" height="24" rx="4" fill="#fff" opacity="0.06"/>
                    <path d="M12 2L2 7h20L12 2z" fill="#fff"/>
                    <path d="M2 9v11h20V9H2z" fill="#fff" opacity="0.9"/>
                </svg>
                <div>
                    <h5>PLN <span class="text-light">Asuransi</span></h5>
                    <small class="text-white-50">Admin Panel</small>
                </div>
            </div>


            <nav class="nav-section">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>


                @php
                    $productMenuActive = request()->is('admin/products*') || request()->is('admin/categories*');
                @endphp
                <div>
                    <a class="nav-link d-flex justify-content-between align-items-center {{ $productMenuActive ? 'active' : '' }}"
                       data-bs-toggle="collapse" href="#productsMenu"
                       aria-expanded="{{ $productMenuActive ? 'true' : 'false' }}">
                        <span><i class="bi bi-box-seam me-1"></i> Produk</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>


                    <div class="collapse submenu {{ $productMenuActive ? 'show' : '' }}" id="productsMenu">
                        <a href="{{ route('admin.products.index') }}" class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}">
                            <i class="bi bi-box me-1"></i> Semua Produk
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}">
                            <i class="bi bi-tags me-1"></i> Kategori
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </aside>


    {{-- Overlay for mobile --}}
    <div id="overlay" class="overlay"></div>


    {{-- Navbar --}}
    <header class="navbar">
        <button id="menu-toggle" class="toggler-btn d-lg-none"><i class="bi bi-list"></i></button>
        <div class="brand-sm"><svg width="20" height="20" viewBox="0 0 24 24" fill="#0b5394" xmlns="http://www.w3.org/2000/svg"><path d="M12 2L2 7h20L12 2z"/><path d="M2 9v11h20V9H2z" opacity="0.9"/></svg> PLN Asuransi</div>
        <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                <i class="bi bi-person-circle fs-4 text-primary"></i>
                <span class="ms-2 d-none d-lg-inline text-dark">{{ Auth::user()->name ?? 'Admin' }}</span>
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


    {{-- Main content --}}
    <main class="content">
        @yield('content')
    </main>


    {{-- Footer --}}
    <footer class="app-footer">
        &copy; {{ date('Y') }} PLN Asuransi. All rights reserved.
    </footer>


    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const toggle = document.getElementById('menu-toggle');


        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('show');
        });
    </script>
</body>
</html>
