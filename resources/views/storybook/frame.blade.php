<!DOCTYPE html>
<html lang="en" data-theme="{{ $theme ?? 'light' }}" data-bs-theme="{{ $theme ?? 'light' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Storybook Canvas Frame</title>

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom Tokens, Mega Menu & Landing Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

    <style>
        body {
            background-color: var(--bg-page);
            color: var(--text-primary);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: var(--font-sans);
        }
        .story-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .story-body-content {
            padding: 3rem 1.5rem;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="story-container">
        @if($story === 'login')
            <!-- Auth Login Screen Story -->
            <div class="d-flex align-items-center justify-content-center flex-grow-1 p-3">
                <div class="card border-0 shadow-lg rounded-4 p-4 p-sm-5" style="max-width: 440px; width: 100%; background: var(--bg-surface);">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="brand-logo__mark" style="width: 44px; height: 44px;">
                            <i class="bi bi-cpu-fill fs-5"></i>
                        </span>
                        <div>
                            <h2 class="h5 fw-bold mb-0">Mahishika CMS</h2>
                            <span class="text-secondary small">Agency Portal Login</span>
                        </div>
                    </div>

                    <div class="p-3 mb-3 rounded-3 small border" style="background: var(--brand-accent-subtle); border-color: rgba(37,99,235,0.2) !important;">
                        <span class="fw-bold text-primary"><i class="bi bi-key-fill me-1"></i> Demo Credentials:</span>
                        <div class="text-muted mt-1">
                            <div>Email: <code>admin@mahishika.digital</code></div>
                            <div>Password: <code>password123</code></div>
                        </div>
                    </div>

                    <form onsubmit="alert('Login form story: credentials validated successfully.'); return false;">
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Admin Email</label>
                            <input type="email" class="form-control" value="admin@mahishika.digital" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label small fw-semibold">Password</label>
                            <input type="password" class="form-control" value="password123" required>
                        </div>
                        <div class="form-check mb-3 text-start">
                            <input class="form-check-input" type="checkbox" id="storyRemember" checked>
                            <label class="form-check-label small text-secondary" for="storyRemember">Remember session</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In to Portal
                        </button>
                    </form>
                </div>
            </div>
        @else
            <!-- Header & Mega Menu -->
            <header class="site-header" id="siteHeader">
                <div class="header-container">
                    <a href="#" class="brand-logo" aria-label="Mahishika Digital Home">
                        <span class="brand-logo__mark">
                            <i class="bi bi-cpu-fill fs-5" aria-hidden="true"></i>
                        </span>
                        <div>
                            <span class="brand-logo__name">Mahishika</span>
                            <span class="brand-logo__tag">Digital Agency</span>
                        </div>
                    </a>

                    <!-- Desktop Nav -->
                    <nav class="desktop-nav" aria-label="Primary Navigation">
                        <ul class="mega-menu-list" role="menubar">
                            @foreach($categories as $category)
                                @php
                                    $isCategoryActive = ($story === 'services' && $category->slug === 'services') ||
                                                        ($story === 'industries' && $category->slug === 'industries');
                                @endphp
                                <li class="mega-menu-item" role="none">
                                    <button type="button" 
                                            class="mega-menu-trigger" 
                                            role="menuitem" 
                                            aria-haspopup="true" 
                                            aria-expanded="{{ $isCategoryActive ? 'true' : 'false' }}" 
                                            aria-controls="panel-{{ $category->slug }}"
                                            id="trigger-{{ $category->slug }}">
                                        <span>{{ $category->name }}</span>
                                        <i class="bi bi-chevron-down chevron-icon" aria-hidden="true"></i>
                                    </button>

                                    <!-- Panel -->
                                    <div class="mega-menu-panel {{ $isCategoryActive ? 'is-open' : '' }}" 
                                         id="panel-{{ $category->slug }}" 
                                         role="region" 
                                         aria-labelledby="trigger-{{ $category->slug }}" 
                                         aria-hidden="{{ $isCategoryActive ? 'false' : 'true' }}">
                                        <div class="mega-menu-grid">
                                            <!-- Overview -->
                                            <div class="mega-column--overview">
                                                <div>
                                                    @if($category->badge)
                                                        <div class="mega-overview-badge">
                                                            <i class="bi {{ $category->icon ?? 'bi-stars' }}" aria-hidden="true"></i>
                                                            <span>{{ $category->badge }}</span>
                                                        </div>
                                                    @endif
                                                    <h3 class="mega-overview-title">{{ $category->name }}</h3>
                                                    <p class="mega-overview-desc">{{ $category->description }}</p>
                                                </div>
                                                <div>
                                                    <a href="#" class="mega-overview-link">
                                                        <span>View all {{ strtolower($category->name) }}</span>
                                                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Links Grid -->
                                            <div class="mega-column--links">
                                                @foreach($category->subCategories as $sub)
                                                    <a href="{{ $sub->url }}" class="mega-sublink">
                                                        <div class="mega-sublink__icon">
                                                            <i class="bi {{ $sub->icon ?? 'bi-arrow-right-short' }}" aria-hidden="true"></i>
                                                        </div>
                                                        <div class="mega-sublink__content">
                                                            <div class="mega-sublink__header">
                                                                <span class="mega-sublink__title">{{ $sub->title }}</span>
                                                                @if($sub->badge)
                                                                    <span class="mega-sublink__badge {{ strtolower($sub->badge) === 'new' ? 'mega-sublink__badge--new' : '' }}">
                                                                        {{ $sub->badge }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <p class="mega-sublink__desc">{{ $sub->description }}</p>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>

                                            <!-- Featured Card -->
                                            <div class="mega-column--featured">
                                                @php
                                                    $featured = $category->portfolioArticles->first();
                                                @endphp
                                                @if($featured)
                                                    <a href="#" class="featured-card">
                                                        <div class="featured-card__media">
                                                            <img src="{{ $featured->image_url ?? 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=700&q=80' }}" 
                                                                 alt="{{ $featured->title }}" 
                                                                 class="featured-card__img" 
                                                                 width="320" 
                                                                 height="130">
                                                            <span class="featured-card__tag">{{ $featured->tag ?? 'Case Study' }}</span>
                                                        </div>
                                                        <div class="featured-card__body">
                                                            @if($featured->metric)
                                                                <div class="featured-card__metric-box">
                                                                    <span class="featured-card__metric">{{ $featured->metric }}</span>
                                                                    <span class="featured-card__metric-label">{{ $featured->metric_label }}</span>
                                                                </div>
                                                            @endif
                                                            <h4 class="featured-card__title">{{ $featured->title }}</h4>
                                                            <p class="featured-card__excerpt">{{ $featured->excerpt }}</p>
                                                            <span class="featured-card__cta">
                                                                <span>Explore Case Study</span>
                                                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                                            </span>
                                                        </div>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </nav>

                    <!-- Actions -->
                    <div class="header-actions">
                        <button type="button" class="action-btn" id="searchToggleBtn" aria-label="Search" aria-expanded="{{ $story === 'search' ? 'true' : 'false' }}">
                            <i class="bi bi-search"></i>
                        </button>
                        <button type="button" class="action-btn" id="themeToggleBtn" aria-label="Toggle theme">
                            <i class="bi {{ $theme === 'dark' ? 'bi-sun-fill text-warning' : 'bi-moon-stars' }}" id="themeIcon"></i>
                        </button>
                        <button type="button" class="btn-cta-consultation d-none d-sm-inline-flex" data-open-consultation>
                            <i class="bi bi-calendar2-check-fill"></i>
                            <span>Book a Consultation</span>
                        </button>
                        <button type="button" class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle navigation" aria-expanded="{{ $story === 'mobile' ? 'true' : 'false' }}">
                            <span class="hamburger-bar"></span>
                            <span class="hamburger-bar"></span>
                            <span class="hamburger-bar"></span>
                        </button>
                    </div>
                </div>

                <!-- Search Overlay -->
                <div class="search-overlay {{ $story === 'search' ? 'is-active' : '' }}" id="searchOverlay" role="search">
                    <div class="search-container">
                        <div class="search-input-wrapper">
                            <i class="bi bi-search search-icon"></i>
                            <input type="search" class="search-input" id="megaSearchInput" placeholder="Search capabilities, industries, or case studies..." value="{{ $story === 'search' ? 'Cloud' : '' }}">
                            <button type="button" class="search-close-btn" id="searchCloseBtn" aria-label="Close search">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                        <div class="search-results-list {{ $story === 'search' ? 'has-results' : '' }}" id="searchResultsList">
                            @if($story === 'search')
                                <a href="#" class="search-result-item">
                                    <div class="search-result-item__main">
                                        <i class="bi bi-cloud-check search-result-item__icon"></i>
                                        <div>
                                            <div class="search-result-item__title"><mark class="bg-warning-subtle text-dark fw-bold">Cloud</mark> Architecture & DevOps</div>
                                            <div class="search-result-item__desc">Multi-cloud Kubernetes, zero-downtime CI/CD pipelines.</div>
                                        </div>
                                    </div>
                                    <span class="search-result-item__tag">Service</span>
                                </a>
                                <a href="#" class="search-result-item">
                                    <div class="search-result-item__main">
                                        <i class="bi bi-briefcase search-result-item__icon text-info"></i>
                                        <div>
                                            <div class="search-result-item__title">FinTech Scale: 5M+ Transactions (<mark class="bg-warning-subtle text-dark fw-bold">Cloud</mark>)</div>
                                            <div class="search-result-item__desc">Architected distributed event-driven microservices core.</div>
                                        </div>
                                    </div>
                                    <span class="search-result-item__tag bg-primary-subtle text-primary">99.999% SLA</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </header>

            <!-- Mobile Drawer -->
            <div class="mobile-drawer-backdrop {{ $story === 'mobile' ? 'is-active' : '' }}" id="mobileBackdrop"></div>
            <aside class="mobile-drawer {{ $story === 'mobile' ? 'is-active' : '' }}" id="mobileDrawer" role="dialog" aria-modal="true">
                <div class="mobile-drawer__header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="brand-logo__mark" style="width: 32px; height: 32px;">
                            <i class="bi bi-cpu-fill fs-6"></i>
                        </span>
                        <span class="fw-bold fs-6">Mahishika Digital</span>
                    </div>
                    <button type="button" class="action-btn" id="mobileCloseBtn">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <div class="mobile-drawer__body">
                    <ul class="mobile-menu-accordion">
                        @foreach($categories as $category)
                            <li class="mobile-menu-item">
                                <button type="button" class="mobile-menu-trigger" aria-expanded="{{ $story === 'mobile' && $category->slug === 'services' ? 'true' : 'false' }}" aria-controls="mobile-sub-{{ $category->slug }}">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi {{ $category->icon ?? 'bi-folder' }} text-primary"></i>
                                        <span>{{ $category->name }}</span>
                                    </div>
                                    <i class="bi bi-chevron-down chevron-icon"></i>
                                </button>
                                <div class="mobile-submenu-collapse {{ $story === 'mobile' && $category->slug === 'services' ? 'is-open' : '' }}" id="mobile-sub-{{ $category->slug }}">
                                    <ul class="mobile-sublink-list">
                                        @foreach($category->subCategories as $sub)
                                            <li>
                                                <a href="{{ $sub->url }}" class="mobile-sublink">
                                                    <i class="bi {{ $sub->icon ?? 'bi-link' }} mobile-sublink__icon"></i>
                                                    <span>{{ $sub->title }}</span>
                                                    @if($sub->badge)
                                                        <span class="badge bg-primary-subtle text-primary ms-auto" style="font-size: 0.65rem;">{{ $sub->badge }}</span>
                                                    @endif
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mobile-drawer__footer">
                    <button type="button" class="btn-submit-consultation w-100" data-open-consultation>
                        <i class="bi bi-calendar2-check-fill me-2"></i>
                        <span>Book a Consultation</span>
                    </button>
                </div>
            </aside>

            <!-- Story Body Content -->
            <div class="story-body-content flex-grow-1">
                <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2">
                    <i class="bi bi-layers-half me-1"></i> Story: <strong>{{ ucfirst($story) }}</strong>
                </span>
                <h1 class="h3 fw-bold mb-2">Mahishika Digital Component Canvas</h1>
                <p class="text-secondary small">
                    This frame runs in an isolated context where CSS media queries match the viewport width exactly.
                    Interact with the header, toggle dropdowns, or test keyboard keys (<kbd>Tab</kbd>, <kbd>Esc</kbd>, <kbd>Enter</kbd>, <kbd>&larr;</kbd>, <kbd>&rarr;</kbd>).
                </p>
            </div>
        @endif
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Mega Menu JS Module -->
    <script type="module">
        import { MegaMenu } from "{{ asset('assets/js/mega-menu.js') }}";
        import { ConsultationController } from "{{ asset('assets/js/consultation.js') }}";

        document.addEventListener('DOMContentLoaded', () => {
            const menu = new MegaMenu();
            const consultation = new ConsultationController();

            // Intercept dataLayer events and relay to parent Storybook logger
            const originalPush = window.dataLayer?.push;
            if (window.dataLayer) {
                window.dataLayer.push = function(...args) {
                    if (window.parent && window.parent !== window) {
                        window.parent.postMessage({ type: 'STORYBOOK_ACTION', payload: args[0] }, '*');
                    }
                    return originalPush.apply(this, args);
                };
            }
        });
    </script>
</body>
</html>
