<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') | Mahishika Digital CMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed-width: 78px;
            --topbar-height: 64px;
            --brand-primary: #0f172a;
            --brand-accent: #3b82f6;
        }
        body {
            min-height: 100vh;
            background-color: #f8fafc;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            overflow-x: hidden;
        }
        [data-bs-theme="dark"] body {
            background-color: #0b0f19;
            color: #e2e8f0;
        }

        /* Sidebar Styling */
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
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            white-space: nowrap;
        }
        .admin-sidebar .nav-link {
            color: #94a3b8;
            padding: 0.72rem 1.15rem;
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

        /* Main Workspace & Topbar */
        .admin-main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .admin-topbar {
            height: var(--topbar-height);
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 0;
            z-index: 990;
            padding: 0 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            transition: background-color 0.2s ease, border-color 0.2s ease;
        }
        [data-bs-theme="dark"] .admin-topbar {
            background: #0f172a;
            border-bottom-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .admin-content {
            padding: 1.75rem 2rem;
            flex: 1;
        }

        /* Desktop Sidebar Collapsed State */
        @media (min-width: 992px) {
            body.sidebar-collapsed .admin-sidebar {
                width: var(--sidebar-collapsed-width);
            }
            body.sidebar-collapsed .admin-main {
                margin-left: var(--sidebar-collapsed-width);
            }
            body.sidebar-collapsed .sidebar-text,
            body.sidebar-collapsed .nav-section-title,
            body.sidebar-collapsed .sidebar-footer-text {
                display: none !important;
            }
            body.sidebar-collapsed .admin-sidebar .nav-link {
                justify-content: center;
                padding: 0.75rem 0;
                margin: 0.3rem 0.6rem;
            }
            body.sidebar-collapsed .admin-sidebar .nav-link i {
                font-size: 1.25rem;
                margin: 0;
            }
            body.sidebar-collapsed .sidebar-brand {
                justify-content: center !important;
                padding: 0.75rem 0 !important;
            }
            body.sidebar-collapsed .admin-sidebar .badge {
                display: none !important;
            }
            body.sidebar-collapsed .user-profile-collapsed {
                justify-content: center !important;
            }
        }

        /* Mobile Responsive View */
        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0 !important;
            }
            .admin-topbar {
                padding: 0 1rem;
            }
            .admin-content {
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

        /* Modal styling */
        .modal {
            z-index: 1060 !important;
        }
        .modal-backdrop {
            z-index: 1050 !important;
            background-color: rgba(15, 23, 42, 0.6) !important;
            backdrop-filter: blur(4px);
        }
        .modal-content {
            background-color: #ffffff !important;
            background: #ffffff !important;
            opacity: 1 !important;
            border: 1px solid rgba(0, 0, 0, 0.15) !important;
            border-radius: 14px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35) !important;
            overflow: hidden;
        }
        [data-bs-theme="dark"] .modal-content {
            background-color: #111827 !important;
            background: #111827 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
            color: #f8fafc;
        }
        .modal-body {
            background-color: inherit;
        }
        .modal-header, .modal-footer {
            background-color: inherit;
        }

        /* Universal Pagination styling and SVG containment */
        .pagination {
            margin-bottom: 0;
            flex-wrap: wrap;
            gap: 4px;
        }
        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 8px !important;
        }
        .pagination .page-link {
            border-radius: 8px !important;
            padding: 0.38rem 0.75rem;
            color: #334155;
            font-size: 0.85rem;
            font-weight: 500;
            border-color: rgba(0, 0, 0, 0.1);
            transition: all 0.15s ease;
        }
        .pagination .page-link:hover {
            background-color: #f1f5f9;
            color: #1e293b;
        }
        .pagination .page-item.active .page-link {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }
        .pagination svg {
            width: 1rem !important;
            height: 1rem !important;
            max-width: 1rem !important;
            max-height: 1rem !important;
            display: inline-block;
            vertical-align: middle;
        }
        [data-bs-theme="dark"] .pagination .page-link {
            background-color: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }
        [data-bs-theme="dark"] .pagination .page-link:hover {
            background-color: #334155;
            color: #ffffff;
        }
        [data-bs-theme="dark"] .pagination .page-item.active .page-link {
            background-color: #3b82f6 !important;
            border-color: #3b82f6 !important;
            color: #ffffff !important;
        }

        /* Status Toggle Switches */
        .admin-status-toggle {
            cursor: pointer;
            width: 2.35rem !important;
            height: 1.25rem !important;
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .admin-status-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.2);
        }
        .admin-status-toggle:checked {
            background-color: #10b981;
            border-color: #10b981;
        }
        .admin-status-toggle.toggle-featured:checked {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
        .admin-status-toggle:disabled {
            opacity: 0.6;
            cursor: wait;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Mobile Sidebar Backdrop -->
    <div class="offcanvas-backdrop fade d-none" id="sidebarBackdrop"></div>

    <!-- Admin Sidebar -->
    <aside class="admin-sidebar" id="adminSidebar">
        <!-- Brand Header -->
        <div class="p-3 border-bottom border-secondary border-opacity-25 d-flex align-items-center justify-content-between sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 text-decoration-none text-white overflow-hidden">
                <span class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-3 p-2 flex-shrink-0" style="width: 36px; height: 36px;">
                    <i class="bi bi-diagram-3-fill fs-5"></i>
                </span>
                <div class="sidebar-text">
                    <div class="fw-bold fs-6 lh-1">Mahishika CMS</div>
                    <small class="text-secondary" style="font-size: 0.72rem;">Menu & Content Admin</small>
                </div>
            </a>
            <button class="btn btn-sm btn-link text-white d-lg-none p-0" id="closeSidebarBtn" aria-label="Close menu">
                <i class="bi bi-x-lg fs-5"></i>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow-1 py-3" aria-label="Admin Navigation">
            <div class="px-3 pb-2 text-uppercase text-secondary fw-semibold nav-section-title" style="font-size: 0.7rem; letter-spacing: 0.05em;">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                <i class="bi bi-speedometer2"></i>
                <span class="sidebar-text">Dashboard</span>
            </a>

            <div class="px-3 pt-3 pb-2 text-uppercase text-secondary fw-semibold nav-section-title" style="font-size: 0.7rem; letter-spacing: 0.05em;">Menu Management</div>
            <a href="{{ route('admin.categories') }}" class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" title="Top-Level Categories">
                <i class="bi bi-grid-fill"></i>
                <span class="sidebar-text">Categories (Top-Level)</span>
            </a>
            <a href="{{ route('admin.subcategories') }}" class="nav-link {{ request()->routeIs('admin.subcategories*') ? 'active' : '' }}" title="Sub-Categories">
                <i class="bi bi-list-nested"></i>
                <span class="sidebar-text">Sub-Categories</span>
            </a>

            <div class="px-3 pt-3 pb-2 text-uppercase text-secondary fw-semibold nav-section-title" style="font-size: 0.7rem; letter-spacing: 0.05em;">Content & Leads</div>
            <a href="{{ route('admin.portfolio') }}" class="nav-link {{ request()->routeIs('admin.portfolio*') ? 'active' : '' }}" title="Portfolio & Articles">
                <i class="bi bi-briefcase-fill"></i>
                <span class="sidebar-text">Portfolio & Articles</span>
            </a>
            <a href="{{ route('admin.consultations') }}" class="nav-link {{ request()->routeIs('admin.consultations*') ? 'active' : '' }}" title="Consultations">
                <i class="bi bi-chat-left-dots-fill"></i>
                <span class="sidebar-text">Consultations</span>
                @php
                    $newCount = \App\Models\Consultation::where('status', 'new')->count();
                @endphp
                @if($newCount > 0)
                    <span class="badge bg-danger ms-auto">{{ $newCount }}</span>
                @endif
            </a>

            <div class="px-3 pt-3 pb-2 text-uppercase text-secondary fw-semibold nav-section-title" style="font-size: 0.7rem; letter-spacing: 0.05em;">Live Site</div>
            <a href="{{ route('home') }}" target="_blank" class="nav-link text-info" title="View Public Website">
                <i class="bi bi-box-arrow-up-right"></i>
                <span class="sidebar-text">View Website</span>
            </a>
        </nav>

        <!-- Sidebar Footer -->
        <div class="p-3 border-top border-secondary border-opacity-25 small text-secondary">
            <!-- User Mini Card -->
            <div class="d-flex align-items-center gap-2 overflow-hidden user-profile-collapsed mb-3">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.85rem;">
                    {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                </div>
                <div class="sidebar-text text-truncate">
                    <div class="text-white fw-semibold text-truncate" style="font-size: 0.82rem;">{{ Auth::user()->name ?? 'softpromani' }}</div>
                    <div class="text-secondary text-truncate" style="font-size: 0.72rem;">{{ Auth::user()->email ?? 'softpromani@gmail.com' }}</div>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-2 sidebar-text">
                <span>Theme</span>
                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" id="sidebarThemeToggleBtn" aria-label="Toggle theme">
                    <i class="bi bi-moon-stars" id="sidebarThemeIcon"></i>
                </button>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="mt-2 sidebar-text">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center gap-1" style="font-size: 0.8rem;">
                    <i class="bi bi-box-arrow-right"></i> Sign Out
                </button>
            </form>

            <div class="mt-2 text-center text-muted sidebar-text" style="font-size: 0.72rem;">Mahishika Digital v1.0.0</div>
        </div>
    </aside>

    <!-- Admin Main Container -->
    <div class="admin-main">
        <!-- Professional Topbar -->
        <header class="admin-topbar">
            <!-- Left: Sidebar Collapse Button & Breadcrumb -->
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-sm btn-light border d-flex align-items-center justify-content-center rounded-3" 
                        id="collapseSidebarBtn" 
                        type="button" 
                        style="width: 38px; height: 38px;" 
                        title="Toggle Sidebar (Ctrl+B)" 
                        aria-label="Toggle Sidebar Navigation">
                    <i class="bi bi-layout-sidebar-inset fs-5 text-secondary" id="collapseSidebarIcon"></i>
                </button>

                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-2 d-none d-sm-inline-flex align-items-center gap-1">
                        <i class="bi bi-shield-check"></i> CMS
                    </span>
                    <span class="text-muted d-none d-sm-inline">/</span>
                    <h1 class="h5 mb-0 fw-bold text-truncate" style="max-width: 350px;">@yield('page_title', 'Dashboard')</h1>
                </div>
            </div>

            <!-- Right: Quick Links, Theme Switcher & Admin Dropdown -->
            <div class="d-flex align-items-center gap-2">
                <!-- Public Site -->
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline-primary d-none d-md-inline-flex align-items-center gap-1 rounded-pill px-3" target="_blank">
                    <i class="bi bi-globe"></i>
                    <span>Public Site</span>
                </a>

                <!-- API JSON -->
                <a href="/api/menu" class="btn btn-sm btn-outline-secondary d-none d-lg-inline-flex align-items-center gap-1 rounded-pill px-3" target="_blank">
                    <i class="bi bi-code-slash"></i>
                    <span>API JSON</span>
                </a>

                <!-- Inquiries Notification Bell -->
                <a href="{{ route('admin.consultations') }}" class="btn btn-sm btn-light border position-relative rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Consultation Inquiries">
                    <i class="bi bi-bell text-secondary"></i>
                    @if($newCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.65rem;">
                            {{ $newCount }}
                        </span>
                    @endif
                </a>

                <!-- Theme Switcher -->
                <button type="button" class="btn btn-sm btn-light border rounded-3 d-flex align-items-center justify-content-center" id="topbarThemeToggleBtn" style="width: 38px; height: 38px;" title="Toggle Dark/Light Mode">
                    <i class="bi bi-moon-stars text-secondary" id="topbarThemeIcon"></i>
                </button>

                <!-- Divider -->
                <div class="vr mx-1 text-secondary opacity-25 d-none d-sm-block" style="height: 24px;"></div>

                <!-- Admin User Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-3" type="button" id="adminUserDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width: 30px; height: 30px; font-size: 0.82rem;">
                            {{ strtoupper(substr(Auth::user()->name ?? 'S', 0, 1)) }}
                        </div>
                        <div class="text-start d-none d-md-block line-height-1">
                            <span class="fw-semibold small d-block">{{ Auth::user()->name ?? 'softpromani' }}</span>
                            <span class="text-muted" style="font-size: 0.68rem;">Super Admin</span>
                        </div>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border mt-2 p-2" aria-labelledby="adminUserDropdown" style="min-width: 220px; border-radius: 12px;">
                        <li class="px-3 py-2 border-bottom mb-1">
                            <div class="fw-bold text-truncate">{{ Auth::user()->name ?? 'softpromani' }}</div>
                            <div class="small text-muted text-truncate">{{ Auth::user()->email ?? 'softpromani@gmail.com' }}</div>
                        </li>
                        <li><a class="dropdown-item rounded py-2 small" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard</a></li>
                        <li><a class="dropdown-item rounded py-2 small" href="{{ route('admin.consultations') }}"><i class="bi bi-chat-left-dots me-2 text-info"></i> Consultation Leads</a></li>
                        <li><a class="dropdown-item rounded py-2 small" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-2 text-secondary"></i> View Public Site</a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item rounded py-2 small text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Admin Content Area -->
        <main class="admin-content">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
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
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Theme toggle logic (Synchronized between topbar & sidebar buttons)
        const html = document.documentElement;
        const topbarThemeBtn = document.getElementById('topbarThemeToggleBtn');
        const sidebarThemeBtn = document.getElementById('sidebarThemeToggleBtn');
        const topbarThemeIcon = document.getElementById('topbarThemeIcon');
        const sidebarThemeIcon = document.getElementById('sidebarThemeIcon');
        const savedTheme = localStorage.getItem('mahishika_admin_theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(savedTheme);

        function toggleTheme() {
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            localStorage.setItem('mahishika_admin_theme', next);
        }

        topbarThemeBtn?.addEventListener('click', toggleTheme);
        sidebarThemeBtn?.addEventListener('click', toggleTheme);

        function applyTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            const iconClass = theme === 'dark' ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars text-secondary';
            if (topbarThemeIcon) topbarThemeIcon.className = iconClass;
            if (sidebarThemeIcon) sidebarThemeIcon.className = iconClass;
        }

        // Sidebar Collapse Logic (Desktop + Mobile)
        const sidebar = document.getElementById('adminSidebar');
        const collapseBtn = document.getElementById('collapseSidebarBtn');
        const collapseIcon = document.getElementById('collapseSidebarIcon');
        const closeBtn = document.getElementById('closeSidebarBtn');
        const backdrop = document.getElementById('sidebarBackdrop');

        // Restore desktop collapsed preference
        const isCollapsed = localStorage.getItem('mahishika_sidebar_collapsed') === 'true';
        if (window.innerWidth >= 992 && isCollapsed) {
            document.body.classList.add('sidebar-collapsed');
            updateCollapseIcon(true);
        }

        function updateCollapseIcon(collapsed) {
            if (collapseIcon) {
                collapseIcon.className = collapsed 
                    ? 'bi bi-layout-sidebar fs-5 text-primary' 
                    : 'bi bi-layout-sidebar-inset fs-5 text-secondary';
            }
        }

        collapseBtn?.addEventListener('click', () => {
            if (window.innerWidth < 992) {
                // Mobile offcanvas drawer
                sidebar?.classList.add('show');
                backdrop?.classList.remove('d-none');
                backdrop?.classList.add('show');
            } else {
                // Desktop collapse/expand
                document.body.classList.toggle('sidebar-collapsed');
                const nowCollapsed = document.body.classList.contains('sidebar-collapsed');
                localStorage.setItem('mahishika_sidebar_collapsed', nowCollapsed ? 'true' : 'false');
                updateCollapseIcon(nowCollapsed);
            }
        });

        // Keyboard Shortcut: Ctrl + B / Cmd + B to toggle sidebar
        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'b') {
                e.preventDefault();
                collapseBtn?.click();
            }
        });

        const closeMobileSidebar = () => {
            sidebar?.classList.remove('show');
            backdrop?.classList.remove('show');
            backdrop?.classList.add('d-none');
        };

        closeBtn?.addEventListener('click', closeMobileSidebar);
        backdrop?.addEventListener('click', closeMobileSidebar);

        // Global Toast Notification Helper
        const liveToastEl = document.getElementById('adminLiveToast');
        const liveToast = liveToastEl ? new bootstrap.Toast(liveToastEl, { delay: 3500 }) : null;
        function showAdminToast(message, isSuccess = true) {
            const toastText = document.getElementById('adminToastText');
            const toastIcon = document.getElementById('adminToastIcon');
            if (toastText) toastText.textContent = message;
            if (toastIcon) {
                toastIcon.className = isSuccess 
                    ? 'bi bi-check-circle-fill text-success fs-5' 
                    : 'bi bi-exclamation-triangle-fill text-danger fs-5';
            }
            if (liveToast) liveToast.show();
        }

        // Global Status Toggle with Confirmation Modal
        let pendingToggle = null;
        let statusModal = null;

        function getStatusModal() {
            if (!statusModal) {
                const el = document.getElementById('statusConfirmModal');
                if (el) {
                    statusModal = new bootstrap.Modal(el);
                }
            }
            return statusModal;
        }

        document.addEventListener('click', (e) => {
            let toggle = e.target.closest('.admin-status-toggle');

            // Also capture clicks on companion label or its inner badge
            if (!toggle) {
                const label = e.target.closest('label[for]');
                if (label) {
                    const targetId = label.getAttribute('for');
                    const targetInput = document.getElementById(targetId);
                    if (targetInput && targetInput.classList.contains('admin-status-toggle')) {
                        toggle = targetInput;
                    }
                }
            }

            if (!toggle) return;

            // Prevent default so checkbox does not flip until user confirms in modal
            e.preventDefault();

            if (toggle.disabled) return;

            pendingToggle = toggle;

            const itemName = toggle.dataset.itemName || 'this item';
            const itemType = toggle.dataset.itemType || 'Item';
            const toggleType = toggle.dataset.toggleType || 'status'; // 'status' or 'featured'
            const isCurrentlyChecked = toggle.checked;
            const willBeChecked = !isCurrentlyChecked;

            const titleEl = document.getElementById('statusConfirmTitle');
            const headingEl = document.getElementById('statusConfirmHeading');
            const promptEl = document.getElementById('statusConfirmPrompt');
            const itemNameEl = document.getElementById('statusConfirmItemName');
            const itemTypeEl = document.getElementById('statusConfirmItemType');
            const newStateEl = document.getElementById('statusConfirmNewState');
            const avatarEl = document.getElementById('statusConfirmAvatar');
            const okBtn = document.getElementById('statusConfirmOkBtn');
            const okText = document.getElementById('statusConfirmOkText');

            if (itemNameEl) itemNameEl.textContent = itemName;
            if (itemTypeEl) itemTypeEl.textContent = itemType;

            if (toggleType === 'featured') {
                if (titleEl) titleEl.textContent = 'Confirm Featured Status';
                if (willBeChecked) {
                    if (headingEl) headingEl.textContent = `Feature this ${itemType.toLowerCase()}?`;
                    if (promptEl) promptEl.textContent = `Are you sure you want to mark "${itemName}" as Featured? It will be highlighted across the mega menu and showcase.`;
                    if (newStateEl) newStateEl.innerHTML = '<span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Featured</span>';
                    if (avatarEl) {
                        avatarEl.className = 'mb-3 d-inline-flex p-3 rounded-circle bg-warning-subtle text-warning';
                        avatarEl.innerHTML = '<i class="bi bi-star-fill fs-1"></i>';
                    }
                    if (okBtn) okBtn.className = 'btn btn-warning text-dark btn-sm px-3 fw-semibold';
                    if (okText) okText.textContent = 'Yes, Mark as Featured';
                } else {
                    if (headingEl) headingEl.textContent = `Unfeature this ${itemType.toLowerCase()}?`;
                    if (promptEl) promptEl.textContent = `Are you sure you want to revert "${itemName}" back to standard listing?`;
                    if (newStateEl) newStateEl.innerHTML = '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Standard</span>';
                    if (avatarEl) {
                        avatarEl.className = 'mb-3 d-inline-flex p-3 rounded-circle bg-secondary-subtle text-secondary';
                        avatarEl.innerHTML = '<i class="bi bi-star fs-1"></i>';
                    }
                    if (okBtn) okBtn.className = 'btn btn-secondary btn-sm px-3';
                    if (okText) okText.textContent = 'Yes, Set Standard';
                }
            } else {
                if (titleEl) titleEl.textContent = 'Confirm Status Change';
                if (willBeChecked) {
                    if (headingEl) headingEl.textContent = `Activate this ${itemType.toLowerCase()}?`;
                    if (promptEl) promptEl.textContent = `Are you sure you want to activate "${itemName}"? It will become visible on the public website navigation.`;
                    if (newStateEl) newStateEl.innerHTML = '<span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>';
                    if (avatarEl) {
                        avatarEl.className = 'mb-3 d-inline-flex p-3 rounded-circle bg-success-subtle text-success';
                        avatarEl.innerHTML = '<i class="bi bi-check-circle-fill fs-1"></i>';
                    }
                    if (okBtn) okBtn.className = 'btn btn-success btn-sm px-3';
                    if (okText) okText.textContent = 'Yes, Activate';
                } else {
                    if (headingEl) headingEl.textContent = `Disable this ${itemType.toLowerCase()}?`;
                    if (promptEl) promptEl.textContent = `Are you sure you want to disable "${itemName}"? It will be hidden from the website navigation.`;
                    if (newStateEl) newStateEl.innerHTML = '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Disabled</span>';
                    if (avatarEl) {
                        avatarEl.className = 'mb-3 d-inline-flex p-3 rounded-circle bg-danger-subtle text-danger';
                        avatarEl.innerHTML = '<i class="bi bi-eye-slash-fill fs-1"></i>';
                    }
                    if (okBtn) okBtn.className = 'btn btn-danger btn-sm px-3';
                    if (okText) okText.textContent = 'Yes, Disable';
                }
            }

            const modal = getStatusModal();
            modal?.show();
        });

        // When confirmation modal closes/cancels, reset pending toggle
        const statusModalEl = document.getElementById('statusConfirmModal');
        statusModalEl?.addEventListener('hidden.bs.modal', () => {
            pendingToggle = null;
            const spinner = document.getElementById('statusConfirmSpinner');
            if (spinner) spinner.classList.add('d-none');
            const okBtn = document.getElementById('statusConfirmOkBtn');
            if (okBtn) okBtn.disabled = false;
            const cancelBtn = document.getElementById('statusConfirmCancelBtn');
            if (cancelBtn) cancelBtn.disabled = false;
        });

        // When confirmed, send AJAX PATCH request and update toggle
        document.getElementById('statusConfirmOkBtn')?.addEventListener('click', async () => {
            if (!pendingToggle) return;

            const toggle = pendingToggle;
            const endpoint = toggle.dataset.endpoint;
            const labelEl = document.getElementById(toggle.dataset.labelId);
            const toggleType = toggle.dataset.toggleType || 'status';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const okBtn = document.getElementById('statusConfirmOkBtn');
            const cancelBtn = document.getElementById('statusConfirmCancelBtn');
            const spinner = document.getElementById('statusConfirmSpinner');

            if (okBtn) okBtn.disabled = true;
            if (cancelBtn) cancelBtn.disabled = true;
            if (spinner) spinner.classList.remove('d-none');

            try {
                const response = await fetch(endpoint, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: Failed to update status`);
                }

                const data = await response.json();

                // Officially toggle checked property
                toggle.checked = !toggle.checked;

                // Update label badge UI dynamically
                if (labelEl) {
                    if (toggleType === 'featured') {
                        const isFeatured = !!data.is_featured;
                        labelEl.innerHTML = isFeatured
                            ? '<span class="badge bg-warning text-dark"><i class="bi bi-star-fill me-1"></i>Featured</span>'
                            : '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Standard</span>';
                    } else {
                        const isActive = !!data.is_active;
                        labelEl.innerHTML = isActive
                            ? '<span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>'
                            : '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">Disabled</span>';
                    }
                }

                const modal = getStatusModal();
                modal?.hide();

                showAdminToast(data.message || 'Status updated successfully.', true);
            } catch (err) {
                console.error('Status toggle failed:', err);
                const modal = getStatusModal();
                modal?.hide();
                showAdminToast('Failed to update status. Please try again.', false);
            } finally {
                if (okBtn) okBtn.disabled = false;
                if (cancelBtn) cancelBtn.disabled = false;
                if (spinner) spinner.classList.add('d-none');
                pendingToggle = null;
            }
        });

        // Consultation Status Select AJAX Handler
        document.addEventListener('change', async (e) => {
            const select = e.target.closest('.consultation-status-select');
            if (!select) return;

            const endpoint = select.dataset.endpoint;
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!endpoint) return;

            select.disabled = true;

            try {
                const response = await fetch(endpoint, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: select.value })
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: Failed to update status`);
                }

                const data = await response.json();

                // Update styling
                select.classList.remove('border-danger', 'text-danger', 'fw-bold', 'border-success', 'text-success');
                if (select.value === 'new') {
                    select.classList.add('border-danger', 'text-danger', 'fw-bold');
                } else if (select.value === 'completed') {
                    select.classList.add('border-success', 'text-success');
                }

                showAdminToast(data.message || 'Consultation status updated.', true);
            } catch (err) {
                console.error('Consultation status update failed:', err);
                // Fallback to traditional form submit
                select.form?.submit();
            } finally {
                select.disabled = false;
            }
        });
    </script>

    <!-- Universal Status Confirmation Modal -->
    <div class="modal fade" id="statusConfirmModal" tabindex="-1" aria-labelledby="statusConfirmModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 440px;">
            <div class="modal-content shadow-lg border">
                <div class="modal-header border-bottom py-3">
                    <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2" id="statusConfirmModalLabel">
                        <i class="bi bi-shield-exclamation text-primary fs-5" id="statusConfirmIcon"></i>
                        <span id="statusConfirmTitle">Confirm Status Change</span>
                    </h5>
                    <button type="button" class="btn-close" id="statusConfirmCloseBtn" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3 d-inline-flex p-3 rounded-circle bg-warning-subtle text-warning" id="statusConfirmAvatar">
                        <i class="bi bi-toggle2-on fs-1"></i>
                    </div>
                    <h6 class="fw-bold mb-2 fs-5" id="statusConfirmHeading">Change status?</h6>
                    <p class="text-secondary small mb-3" id="statusConfirmPrompt">
                        Are you sure you want to change the status of this item?
                    </p>
                    <div class="p-3 rounded-3 bg-body-tertiary border text-start small">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Item Name:</span>
                            <span class="fw-bold text-body text-truncate ms-2" style="max-width: 240px;" id="statusConfirmItemName">Item</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">Module / Type:</span>
                            <span class="text-body fw-medium" id="statusConfirmItemType">Category</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-secondary">New Status:</span>
                            <span id="statusConfirmNewState">
                                <span class="badge bg-success-subtle text-success border border-success-subtle">Active</span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top py-2 px-4 bg-body-tertiary d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-secondary btn-sm px-3" id="statusConfirmCancelBtn" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-3 d-flex align-items-center gap-2" id="statusConfirmOkBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="statusConfirmSpinner" role="status" aria-hidden="true"></span>
                        <span id="statusConfirmOkText">Yes, Update Status</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090;">
        <div id="adminLiveToast" class="toast align-items-center text-bg-dark border-0 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2" id="adminToastMessage">
                    <i class="bi bi-check-circle-fill text-success fs-5" id="adminToastIcon"></i>
                    <span id="adminToastText">Status updated successfully.</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
