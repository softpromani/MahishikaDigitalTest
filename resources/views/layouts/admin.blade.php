<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') | Mahishika Digital CMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --brand-primary: #0f172a;
            --brand-accent: #3b82f6;
        }
        body {
            min-height: 100vh;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        [data-bs-theme="dark"] body {
            background-color: #0b0f19;
            color: #e2e8f0;
        }
        .admin-sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: #0f172a;
            color: #94a3b8;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1000;
            transition: transform 0.3s ease;
        }
        .admin-sidebar .nav-link {
            color: #94a3b8;
            padding: 0.75rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            border-radius: 0.5rem;
            margin: 0.2rem 0.75rem;
            transition: all 0.2s ease;
        }
        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: #ffffff;
            background: rgba(59, 130, 246, 0.15);
        }
        .admin-sidebar .nav-link.active {
            color: #60a5fa;
            background: rgba(59, 130, 246, 0.2);
            font-weight: 600;
        }
        .admin-main {
            margin-left: var(--sidebar-width);
            padding: 1.5rem 2rem;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0;
                padding: 1rem;
            }
        }
        .stat-card {
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.06);
        }
        [data-bs-theme="dark"] .stat-card {
            border-color: #1e293b;
            background-color: #111827;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile Sidebar Backdrop -->
    <div class="offcanvas-backdrop fade d-none" id="sidebarBackdrop"></div>

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar d-flex flex-column" id="adminSidebar">
        <div class="p-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none text-white">
                <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 p-2">
                    <i class="bi bi-diagram-3-fill fs-5"></i>
                </span>
                <div>
                    <div class="fw-bold fs-6 lh-1">Mahishika CMS</div>
                    <small class="text-secondary" style="font-size: 0.72rem;">Menu & Content Admin</small>
                </div>
            </a>
            <button class="btn btn-sm btn-link text-white d-lg-none p-0" id="closeSidebarBtn" aria-label="Close menu">
                <i class="bi bi-x-lg fs-5"></i>
            </button>
        </div>

        <nav class="flex-grow-1 py-3" aria-label="Admin Navigation">
            <div class="px-3 pb-2 text-uppercase text-secondary fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <div class="px-3 pt-3 pb-2 text-uppercase text-secondary fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Menu Management</div>
            <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}">
                <i class="bi bi-grid-fill"></i> Categories (Top-Level)
            </a>
            <a href="{{ route('admin.subcategories') }}" class="nav-link {{ request()->routeIs('admin.subcategories*') ? 'active' : '' }}">
                <i class="bi bi-list-nested"></i> Sub-Categories
            </a>

            <div class="px-3 pt-3 pb-2 text-uppercase text-secondary fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Content & Leads</div>
            <a href="{{ route('admin.portfolio') }}" class="nav-link {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}">
                <i class="bi bi-briefcase-fill"></i> Portfolio & Articles
            </a>
            <a href="{{ route('admin.consultations') }}" class="nav-link {{ request()->routeIs('admin.consultations*') ? 'active' : '' }}">
                <i class="bi bi-chat-left-dots-fill"></i> Consultations
                @php
                    $newCount = \App\Models\Consultation::where('status', 'new')->count();
                @endphp
                @if($newCount > 0)
                    <span class="badge bg-danger ms-auto">{{ $newCount }}</span>
                @endif
            </a>

            <div class="px-3 pt-3 pb-2 text-uppercase text-secondary fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.05em;">Live Site</div>
            <a href="{{ route('home') }}" target="_blank" class="nav-link text-info">
                <i class="bi bi-box-arrow-up-right"></i> View Website
            </a>
        </nav>

        <div class="p-3 border-top border-secondary border-opacity-25 small text-secondary">
            <div class="d-flex align-items-center justify-content-between">
                <span>Theme</span>
                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" id="themeToggleBtn" aria-label="Toggle theme">
                    <i class="bi bi-moon-stars" id="themeIcon"></i>
                </button>
            </div>
            <div class="mt-2 text-muted" style="font-size: 0.75rem;">Mahishika Digital v1.0.0</div>
        </div>
    </aside>

    <!-- Admin Content Area -->
    <main class="admin-main">
        <!-- Top Navigation Bar -->
        <header class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary d-lg-none" id="toggleSidebarBtn" aria-label="Toggle sidebar">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <h1 class="h4 mb-0 fw-bold">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary" target="_blank">
                    <i class="bi bi-globe me-1"></i> Public Site
                </a>
                <a href="/api/menu" class="btn btn-sm btn-outline-secondary" target="_blank">
                    <i class="bi bi-code-square me-1"></i> API JSON
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i>Please fix the following errors:</div>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main View Content -->
        @yield('content')
    </main>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Theme toggle logic
        const html = document.documentElement;
        const themeBtn = document.getElementById('themeToggleBtn');
        const themeIcon = document.getElementById('themeIcon');
        const savedTheme = localStorage.getItem('mahishika_admin_theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(savedTheme);

        themeBtn?.addEventListener('click', () => {
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            localStorage.setItem('mahishika_admin_theme', next);
        });

        function applyTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            if (themeIcon) {
                themeIcon.className = theme === 'dark' ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars';
            }
        }

        // Mobile sidebar toggle
        const sidebar = document.getElementById('adminSidebar');
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');
        const backdrop = document.getElementById('sidebarBackdrop');

        toggleBtn?.addEventListener('click', () => {
            sidebar?.classList.add('show');
            backdrop?.classList.remove('d-none');
            backdrop?.classList.add('show');
        });

        const closeSidebar = () => {
            sidebar?.classList.remove('show');
            backdrop?.classList.remove('show');
            backdrop?.classList.add('d-none');
        };

        closeBtn?.addEventListener('click', closeSidebar);
        backdrop?.addEventListener('click', closeSidebar);
    </script>
    @stack('scripts')
</body>
</html>

