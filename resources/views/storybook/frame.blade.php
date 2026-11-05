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
        body.is-mobile-story {
            height: 100vh;
            max-height: 100vh;
            overflow: hidden !important;
            min-height: auto;
        }
        .story-container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        body.is-mobile-story .story-container {
            height: 100vh;
            max-height: 100vh;
            overflow: hidden;
            min-height: auto;
        }

        /* Simulated Mobile Device Container for Mobile Story */
        .mobile-screen-wrapper {
            background: var(--bg-surface);
            height: 100vh;
            max-height: 100vh;
            display: flex;
            flex-direction: column;
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        .mobile-phone-status-bar {
            height: 32px;
            background: var(--bg-surface);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.25rem;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--text-primary);
            border-bottom: 1px solid var(--border-subtle);
            flex-shrink: 0;
            z-index: 20;
        }

        .mobile-phone-nav-header {
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--border-color);
            background: var(--bg-surface);
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            flex-shrink: 0;
            z-index: 20;
        }

        .mobile-phone-body {
            padding: 1rem 1.25rem;
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }

        .mobile-phone-footer {
            padding: 0.85rem 1rem;
            border-top: 1px solid var(--border-color);
            background: var(--bg-surface);
            box-shadow: 0 -2px 10px rgba(0,0,0,0.03);
            flex-shrink: 0;
            z-index: 20;
        }

        .mobile-home-indicator {
            width: 120px;
            height: 4px;
            background: var(--text-muted);
            border-radius: 2px;
            margin: 0.5rem auto 0;
            opacity: 0.35;
        }

        .story-body-content {
            padding: 3rem 1.5rem;
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>
<body class="{{ $story === 'mobile' ? 'is-mobile-story' : '' }}">
    <div class="story-container">
        @if($story === 'mobile')
            <!-- Dedicated Clean Mobile Viewport Story -->
            <div class="mobile-screen-wrapper">
                <!-- Phone Status Bar -->
                <div class="mobile-phone-status-bar">
                    <span>9:41</span>
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-wifi"></i>
                        <i class="bi bi-reception-4"></i>
                        <i class="bi bi-battery-full"></i>
                    </div>
                </div>

                <!-- Mobile Navbar Header -->
                <div class="mobile-phone-nav-header">
                    <div class="d-flex align-items-center gap-2">
                        <span class="brand-logo__mark" style="width: 32px; height: 32px;">
                            <i class="bi bi-cpu-fill fs-6"></i>
                        </span>
                        <div>
                            <span class="fw-bold" style="font-size: 0.95rem;">Mahishika</span>
                            <span class="d-block text-muted" style="font-size: 0.65rem; text-transform: uppercase;">Digital Agency</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <button type="button" class="action-btn" style="width: 36px; height: 36px;" onclick="toggleMobileSearch()">
                            <i class="bi bi-search" style="font-size: 0.9rem;"></i>
                        </button>
                        <button type="button" class="action-btn" style="width: 36px; height: 36px;" onclick="window.parent.postMessage({ type: 'STORYBOOK_ACTION', payload: { event: 'theme_toggle' } }, '*')">
                            <i class="bi {{ $theme === 'dark' ? 'bi-sun-fill text-warning' : 'bi-moon-stars' }}" style="font-size: 0.9rem;"></i>
                        </button>
                        <button type="button" class="hamburger-btn" style="width: 36px; height: 36px;" aria-expanded="true">
                            <i class="bi bi-x-lg text-primary" style="font-size: 1.1rem;"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Search Input Box -->
                <div class="p-3 pb-0" id="mobileSearchBox" style="display: none;">
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="search" class="form-control border-start-0" placeholder="Search services...">
                    </div>
                </div>

                <!-- Mobile Menu Accordion Body -->
                <div class="mobile-phone-body">
                    <ul class="mobile-menu-accordion">
                        @foreach($categories as $category)
                            <li class="mobile-menu-item">
                                <button type="button" 
                                        class="mobile-menu-trigger" 
                                        aria-expanded="{{ $category->slug === 'services' ? 'true' : 'false' }}" 
                                        onclick="toggleAccordion('mobile-sub-{{ $category->slug }}', this)">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi {{ $category->icon ?? 'bi-folder' }} text-primary"></i>
                                        <span class="fw-bold" style="font-size: 0.98rem;">{{ $category->name }}</span>
                                    </div>
                                    <i class="bi bi-chevron-down chevron-icon"></i>
                                </button>
                                <div class="mobile-submenu-collapse {{ $category->slug === 'services' ? 'is-open' : '' }}" id="mobile-sub-{{ $category->slug }}">
                                    <ul class="mobile-sublink-list ps-2 pe-1">
                                        @foreach($category->subCategories as $sub)
                                            <li>
                                                <a href="{{ $sub->url }}" class="mobile-sublink" onclick="window.parent.postMessage({ type: 'STORYBOOK_ACTION', payload: { event: 'mobile_link_click', title: '{{ $sub->title }}' } }, '*')">
                                                    <div class="d-flex align-items-center gap-2 flex-grow-1">
                                                        <i class="bi {{ $sub->icon ?? 'bi-link' }} mobile-sublink__icon" style="flex-shrink: 0;"></i>
                                                        <span style="font-size: 0.88rem;">{{ $sub->title }}</span>
                                                    </div>
                                                    @if($sub->badge)
                                                        <span class="badge bg-primary-subtle text-primary ms-2" style="font-size: 0.65rem;">{{ $sub->badge }}</span>
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

                <!-- Mobile CTA Footer -->
                <div class="mobile-phone-footer">
                    <button type="button" class="btn-submit-consultation w-100" onclick="alert('Opening consultation booking modal...'); window.parent.postMessage({ type: 'STORYBOOK_ACTION', payload: { event: 'consultation_modal_open' } }, '*')">
                        <i class="bi bi-calendar2-check-fill me-2"></i>
                        <span>Book a Consultation</span>
                    </button>
                    <div class="mobile-home-indicator"></div>
                </div>
            </div>

            <script>
                function toggleAccordion(id, btn) {
                    const target = document.getElementById(id);
                    const isExpanded = btn.getAttribute('aria-expanded') === 'true';
                    btn.setAttribute('aria-expanded', !isExpanded);
                    target.classList.toggle('is-open');
                }
                function toggleMobileSearch() {
                    const box = document.getElementById('mobileSearchBox');
                    box.style.display = box.style.display === 'none' ? 'block' : 'none';
                }
            </script>

        @elseif($story === 'login')
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

                    <form onsubmit="alert('Login credentials valid. Redirecting to CMS dashboard...'); return false;">
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

        @elseif($story === 'docs')
            <!-- Documentation Story -->
            <div class="p-4 p-md-5 max-w-4xl mx-auto text-start">
                <span class="badge bg-success-subtle text-success p-2 mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i> WCAG 2.1 AA Checklist Verification
                </span>
                <h1 class="h3 fw-bold mb-4">Accessibility & Technical Architecture</h1>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <div class="card p-3 h-100 border-0 shadow-sm" style="background: var(--bg-surface);">
                            <h2 class="h6 fw-bold text-primary"><i class="bi bi-keyboard me-2"></i>Keyboard Navigation</h2>
                            <ul class="small text-secondary ps-3 mb-0" style="line-height: 1.7;">
                                <li><code>Tab / Shift+Tab</code>: Sequential forward and backward focus.</li>
                                <li><code>Enter / Space</code>: Toggles dropdown or follows link.</li>
                                <li><code>Escape</code>: Instantly closes open panel and returns focus to trigger.</li>
                                <li><code>ArrowLeft / ArrowRight</code>: Navigates top-level menu items.</li>
                                <li><code>ArrowDown</code>: Enters open panel and focuses first link.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 h-100 border-0 shadow-sm" style="background: var(--bg-surface);">
                            <h2 class="h6 fw-bold text-primary"><i class="bi bi-universal-access me-2"></i>ARIA Attributes</h2>
                            <ul class="small text-secondary ps-3 mb-0" style="line-height: 1.7;">
                                <li><code>aria-expanded="true|false"</code>: Updated on triggers.</li>
                                <li><code>aria-controls="panel-id"</code>: Associates panels.</li>
                                <li><code>aria-haspopup="true"</code>: Indicates popup menu.</li>
                                <li><code>role="menubar"</code> & <code>role="menuitem"</code>: Semantic menu roles.</li>
                                <li><code>aria-hidden="true|false"</code>: Screen reader exclusion.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- Header & Mega Menu Desktop / Standard -->
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
                        <button type="button" class="hamburger-btn" id="hamburgerBtn" aria-label="Toggle navigation">
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
