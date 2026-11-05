<!DOCTYPE html>
<html lang="en" data-theme="light" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mahishika Digital | Enterprise Digital Agency & Cloud Engineering</title>
    <meta name="description" content="Mahishika Digital is a premier digital engineering agency crafting resilient cloud architectures, bespoke web platforms, AI agents, and accessible design systems.">
    <meta name="theme-color" content="#2563eb">

    <!-- Preconnect Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Custom CSS Design Tokens, Mega Menu & Landing Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">

    <!-- Google Tag Manager / Analytics DataLayer Initialization -->
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            'event': 'page_view',
            'page_title': 'Mahishika Digital - Services Landing Page',
            'theme': localStorage.getItem('mahishika_theme') || 'light'
        });
    </script>
</head>
<body>
    <!-- Skip to Content Link (WCAG 2.1 AA) -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- ==========================================================================
       Header with Custom Mega Menu
       ========================================================================== -->
    <header class="site-header" id="siteHeader">
        <div class="header-container">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-logo" aria-label="Mahishika Digital Home">
                <img src="{{ asset('assets/images/logo.webp') }}" alt="Mahishika Digital" class="brand-logo__img" height="36">
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="desktop-nav" aria-label="Primary Navigation">
                <ul class="mega-menu-list" role="menubar">
                    @foreach($categories as $category)
                        <li class="mega-menu-item" role="none">
                            <button type="button" 
                                    class="mega-menu-trigger" 
                                    role="menuitem" 
                                    aria-haspopup="true" 
                                    aria-expanded="false" 
                                    aria-controls="panel-{{ $category->slug }}"
                                    id="trigger-{{ $category->slug }}">
                                <span>{{ $category->name }}</span>
                                <i class="bi bi-chevron-down chevron-icon" aria-hidden="true"></i>
                            </button>

                            <!-- Mega Menu Dropdown Panel -->
                            <div class="mega-menu-panel" 
                                 id="panel-{{ $category->slug }}" 
                                 role="region" 
                                 aria-labelledby="trigger-{{ $category->slug }}" 
                                 aria-hidden="true">
                                <div class="mega-menu-grid">
                                    <!-- Column 1: Category Overview -->
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
                                            <a href="#{{ $category->slug }}-section" class="mega-overview-link">
                                                <span>View all {{ strtolower($category->name) }}</span>
                                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- Column 2: Sub-Categories Links Grid -->
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
                                                            <span class="mega-sublink__badge {{ strtolower($sub->badge) === 'new' ? 'mega-sublink__badge--new' : (strtolower($sub->badge) === 'enterprise' ? 'mega-sublink__badge--enterprise' : '') }}">
                                                                {{ $sub->badge }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <p class="mega-sublink__desc">{{ $sub->description }}</p>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>

                                    <!-- Column 3: Featured Case Study / Article Card -->
                                    <div class="mega-column--featured">
                                        @php
                                            $featured = $category->portfolioArticles->first();
                                        @endphp
                                        @if($featured)
                                            <a href="{{ $featured->link_url }}" class="featured-card">
                                                <div class="featured-card__media">
                                                    <img src="{{ $featured->image_url ?? 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=700&q=80' }}" 
                                                         alt="{{ $featured->title }}" 
                                                         class="featured-card__img" 
                                                         loading="lazy" 
                                                         width="320" 
                                                         height="130">
                                                    <span class="featured-card__tag">{{ $featured->tag ?? 'Spotlight' }}</span>
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
                                        @else
                                            <div class="p-3 text-center text-muted small bg-body-tertiary rounded h-100 d-flex align-items-center justify-content-center">
                                                <span>Custom engineering engagements tailored to your roadmap.</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <!-- Header Right Actions: Search, Theme Toggle, Consultation CTA & Mobile Toggle -->
            <div class="header-actions">
                <!-- Search Trigger Button -->
                <button type="button" 
                        class="action-btn" 
                        id="searchToggleBtn" 
                        aria-label="Search services, industries and case studies" 
                        aria-expanded="false" 
                        aria-controls="searchOverlay">
                    <i class="bi bi-search" aria-hidden="true"></i>
                </button>

                <!-- Dark / Light Mode Toggle Button -->
                <button type="button" 
                        class="action-btn" 
                        id="themeToggleBtn" 
                        aria-label="Toggle dark mode" 
                        aria-pressed="false">
                    <i class="bi bi-moon-stars" id="themeIcon" aria-hidden="true"></i>
                </button>

                <!-- Primary Top-Level CTA Button -->
                <button type="button" 
                        class="btn-cta-consultation d-none d-sm-inline-flex" 
                        data-open-consultation 
                        aria-label="Book a consultation with Mahishika Digital">
                    <i class="bi bi-calendar2-check-fill" aria-hidden="true"></i>
                    <span>Book a Consultation</span>
                </button>

                <!-- Mobile Hamburger Button -->
                <button type="button" 
                        class="hamburger-btn" 
                        id="hamburgerBtn" 
                        aria-label="Toggle navigation drawer" 
                        aria-expanded="false" 
                        aria-controls="mobileDrawer">
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                    <span class="hamburger-bar"></span>
                </button>
            </div>
        </div>

        <!-- ======================================================================
           Live Search Overlay
           ====================================================================== -->
        <div class="search-overlay" id="searchOverlay" role="search" aria-label="Mega menu search">
            <div class="search-container">
                <div class="search-input-wrapper">
                    <i class="bi bi-search search-icon" aria-hidden="true"></i>
                    <input type="search" 
                           class="search-input" 
                           id="megaSearchInput" 
                           placeholder="Search capabilities, industries, or case studies (e.g., 'Cloud', 'FinTech', 'AI')..." 
                           aria-label="Search services and articles" 
                           autocomplete="off">
                    <button type="button" class="search-close-btn" id="searchCloseBtn" aria-label="Close search">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="search-results-list" id="searchResultsList" role="listbox" aria-label="Search results"></div>
            </div>
        </div>
    </header>

    <!-- ==========================================================================
       Mobile Navigation Drawer
       ========================================================================== -->
    <div class="mobile-drawer-backdrop" id="mobileBackdrop" aria-hidden="true"></div>

    <aside class="mobile-drawer" id="mobileDrawer" role="dialog" aria-modal="true" aria-label="Mobile Navigation">
        <div class="mobile-drawer__header">
            <a href="{{ route('home') }}" class="brand-logo" aria-label="Mahishika Digital Home">
                <img src="{{ asset('assets/images/logo.webp') }}" alt="Mahishika Digital" class="brand-logo__img" height="30">
            </a>
            <button type="button" class="action-btn" id="mobileCloseBtn" aria-label="Close mobile navigation">
                <i class="bi bi-x-lg" aria-hidden="true"></i>
            </button>
        </div>

        <div class="mobile-drawer__body">
            <ul class="mobile-menu-accordion">
                @foreach($categories as $category)
                    <li class="mobile-menu-item">
                        <button type="button" 
                                class="mobile-menu-trigger" 
                                aria-expanded="false" 
                                aria-controls="mobile-sub-{{ $category->slug }}">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $category->icon ?? 'bi-folder' }} text-primary" aria-hidden="true"></i>
                                <span>{{ $category->name }}</span>
                            </div>
                            <i class="bi bi-chevron-down chevron-icon" aria-hidden="true"></i>
                        </button>
                        <div class="mobile-submenu-collapse" id="mobile-sub-{{ $category->slug }}">
                            <ul class="mobile-sublink-list">
                                @foreach($category->subCategories as $sub)
                                    <li>
                                        <a href="{{ $sub->url }}" class="mobile-sublink">
                                            <i class="bi {{ $sub->icon ?? 'bi-link' }} mobile-sublink__icon" aria-hidden="true"></i>
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
                <i class="bi bi-calendar2-check-fill me-2" aria-hidden="true"></i>
                <span>Book a Consultation</span>
            </button>
            <div class="mt-3 text-center">
                <a href="{{ route('admin.dashboard') }}" class="small text-secondary text-decoration-none">
                    <i class="bi bi-gear-fill me-1" aria-hidden="true"></i> Admin CMS Portal
                </a>
            </div>
        </div>
    </aside>

    <!-- ==========================================================================
       Main Content Container
       ========================================================================== -->
    <main id="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-glow" aria-hidden="true"></div>
            <div class="container position-relative">
                <div class="hero-content">
                    <div class="hero-badge">
                        <span class="hero-badge__dot" aria-hidden="true"></span>
                        <span>Accepting Strategic Architecture Engagements &bull; Q1/Q2</span>
                    </div>

                    <h1 class="hero-title">
                        Engineering Resilient <span class="hero-title__highlight">Digital Systems</span> for Visionary Enterprises
                    </h1>

                    <p class="hero-subtitle">
                        Mahishika Digital pairs cloud architects, full-stack engineers, and human-centered designers to build mission-critical web applications, autonomous AI workflows, and frictionless cross-platform experiences.
                    </p>

                    <div class="hero-actions">
                        <button type="button" class="btn-hero-primary" data-open-consultation>
                            <i class="bi bi-calendar2-check-fill" aria-hidden="true"></i>
                            <span>Book an Architecture Consultation</span>
                        </button>
                        <a href="#services-section" class="btn-hero-secondary">
                            <span>Explore Our Capabilities</span>
                            <i class="bi bi-arrow-down" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <!-- Metrics & Reliability Bar -->
                <div class="metrics-bar">
                    <div class="row g-4 align-items-center">
                        @foreach($stats as $stat)
                            <div class="col-6 col-md-3">
                                <div class="metric-item">
                                    <div class="metric-item__value">{{ $stat['value'] }}</div>
                                    <div class="metric-item__label">{{ $stat['label'] }}</div>
                                    <div class="metric-item__sub">{{ $stat['sub'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Capabilities Section -->
        <section class="section-wrapper" id="services-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">
                        <i class="bi bi-layers-half" aria-hidden="true"></i> Core Capabilities
                    </span>
                    <h2 class="section-title">Engineered for Scale, Speed, and Zero Compromise</h2>
                    <p class="section-desc">
                        From cloud-native microservices to reactive frontends and enterprise AI pipelines, we deliver end-to-end technical excellence.
                    </p>
                </div>

                <div class="row g-4">
                    @foreach($allServices as $service)
                        <div class="col-md-6 col-lg-4">
                            <div class="service-card" id="{{ str_replace('#', '', $service->url) }}">
                                <div class="service-card__icon-wrapper">
                                    <i class="bi {{ $service->icon ?? 'bi-gear-wide-connected' }}" aria-hidden="true"></i>
                                </div>
                                <h3 class="service-card__title">{{ $service->title }}</h3>
                                <p class="service-card__desc">{{ $service->description }}</p>
                                
                                <div class="service-card__pills">
                                    @if($service->badge)
                                        <span class="badge bg-primary-subtle text-primary">{{ $service->badge }}</span>
                                    @endif
                                    <span class="service-pill">WCAG 2.1 AA</span>
                                    <span class="service-pill">SOC2 Compliant</span>
                                    <span class="service-pill">Cloud-Ready</span>
                                </div>

                                <button type="button" 
                                        class="service-card__cta border-0 bg-transparent p-0 text-start" 
                                        data-open-consultation 
                                        data-service-preselect="{{ $service->title }}">
                                    <span>Discuss this capability</span>
                                    <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Industries Domain Expertise Section -->
        <section class="section-wrapper bg-body-tertiary" id="industries-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">
                        <i class="bi bi-buildings" aria-hidden="true"></i> Industry Domains
                    </span>
                    <h2 class="section-title">Deep Technical Expertise Across Complex Sectors</h2>
                    <p class="section-desc">
                        We understand regulatory frameworks, concurrency challenges, and domain constraints across high-velocity industries.
                    </p>
                </div>

                <div class="row g-4">
                    @foreach($allIndustries as $industry)
                        <div class="col-md-6 col-lg-4">
                            <div class="industry-box h-100">
                                <div class="industry-box__icon">
                                    <i class="bi {{ $industry->icon ?? 'bi-check2' }}" aria-hidden="true"></i>
                                </div>
                                <div>
                                    <h3 class="industry-box__title">{{ $industry->title }}</h3>
                                    <p class="industry-box__desc">{{ $industry->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Work & Featured Case Studies Section -->
        <section class="section-wrapper" id="work-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">
                        <i class="bi bi-briefcase" aria-hidden="true"></i> Proven Outcomes
                    </span>
                    <h2 class="section-title">Measurable Results for Industry Leaders</h2>
                    <p class="section-desc">
                        Real-world systems engineered to withstand millions of requests while delivering intuitive user experiences.
                    </p>
                </div>

                <div class="row g-4">
                    @foreach($featuredCaseStudies as $case)
                        <div class="col-md-6 col-lg-4">
                            <div class="case-card">
                                <div class="case-card__media">
                                    <img src="{{ $case->image_url ?? 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=700&q=80' }}" 
                                         alt="{{ $case->title }}" 
                                         class="case-card__img" 
                                         loading="lazy" 
                                         width="400" 
                                         height="220">
                                    <span class="case-card__tag">{{ $case->tag ?? 'Case Study' }}</span>
                                </div>
                                <div class="case-card__body">
                                    @if($case->metric)
                                        <div class="case-card__metric-callout">
                                            <span class="case-card__metric-val">{{ $case->metric }}</span>
                                            <span class="case-card__metric-lbl">{{ $case->metric_label }}</span>
                                        </div>
                                    @endif
                                    <h3 class="case-card__title">{{ $case->title }}</h3>
                                    <p class="case-card__desc">{{ $case->excerpt }}</p>
                                    <button type="button" 
                                            class="service-card__cta border-0 bg-transparent p-0 text-start mt-auto" 
                                            data-open-consultation 
                                            data-service-preselect="{{ $case->title }}">
                                        <span>Request Architectural Brief</span>
                                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Approach & Methodology Section -->
        <section class="section-wrapper bg-body-tertiary" id="approach-section">
            <div class="container">
                <div class="section-header">
                    <span class="section-tag">
                        <i class="bi bi-compass" aria-hidden="true"></i> Engineering Playbook
                    </span>
                    <h2 class="section-title">How We Ship Production Code in Week 2</h2>
                    <p class="section-desc">
                        Our disciplined 4-stage cadence eliminates bureaucratic waste and aligns engineering directly with business impact.
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <div class="approach-step">
                            <div class="approach-step__number">01</div>
                            <h3 class="approach-step__title">Architecture Blueprint</h3>
                            <p class="approach-step__desc">
                                We dissect requirements into decoupled domain boundaries, define contract schemas, and scaffold infrastructure as code before writing business logic.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="approach-step">
                            <div class="approach-step__number">02</div>
                            <h3 class="approach-step__title">2-Week Sprint Cadence</h3>
                            <p class="approach-step__desc">
                                Ephemeral preview environments on every Git pull request with automated linting, test suites, and transparent daily burndown tracking.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="approach-step">
                            <div class="approach-step__number">03</div>
                            <h3 class="approach-step__title">Accessibility & QA Gate</h3>
                            <p class="approach-step__desc">
                                Every component undergoes automated and keyboard testing for WCAG 2.1 AA compliance, cross-browser validation, and Lighthouse 90+ score enforcement.
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="approach-step">
                            <div class="approach-step__number">04</div>
                            <h3 class="approach-step__title">Zero-Downtime SRE</h3>
                            <p class="approach-step__desc">
                                Canary rollouts, automated rollback heuristics, distributed tracing, and 24/7 reliability monitoring backed by explicit SLAs.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Call to Action Banner -->
        <section class="section-wrapper" id="consultation-section">
            <div class="container">
                <div class="consultation-cta-card">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-8">
                            <span class="section-tag text-primary">
                                <i class="bi bi-stars" aria-hidden="true"></i> Start Your Transformation
                            </span>
                            <h2 class="h1 fw-bold text-primary mb-3">Ready to Build Something Extraordinary?</h2>
                            <p class="fs-5 text-secondary mb-0">
                                Schedule a 45-minute technical discovery session with our senior solutions architect. No sales pitch — just high-value architectural insight.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <button type="button" class="btn-hero-primary" data-open-consultation>
                                <i class="bi bi-calendar2-check-fill" aria-hidden="true"></i>
                                <span>Schedule Technical Call</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ==========================================================================
       Consultation Booking Modal (WCAG 2.1 AA Compliant)
       ========================================================================== -->
    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered consultation-modal-dialog">
            <div class="modal-content border-0 shadow-xl rounded-4 overflow-hidden">
                <div class="modal-header border-bottom py-3 px-4">
                    <div>
                        <h2 class="modal-title h5 fw-bold mb-1" id="consultationModalLabel">Book an Architecture Consultation</h2>
                        <p class="text-secondary small mb-0">Speak directly with a senior engineering architect from Mahishika Digital.</p>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close dialog"></button>
                </div>

                <div class="modal-body p-4">
                    <!-- Status message container -->
                    <div id="consultationStatusAlert" class="alert d-none" role="alert"></div>

                    <!-- Booking Form View -->
                    <form id="consultationForm" novalidate>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="clientName" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="clientName" name="name" required placeholder="e.g. John Doe">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6">
                                <label for="clientEmail" class="form-label">Work Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="clientEmail" name="email" required placeholder="john@company.com">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="clientCompany" class="form-label">Company / Organization</label>
                                <input type="text" class="form-control" id="clientCompany" name="company" placeholder="e.g. Acme Corp">
                            </div>
                            <div class="col-md-6">
                                <label for="clientPhone" class="form-label">Phone (Optional)</label>
                                <input type="tel" class="form-control" id="clientPhone" name="phone" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="serviceInterest" class="form-label">Primary Capability of Interest</label>
                                <select class="form-select" id="serviceInterest" name="service_interest">
                                    <option value="Cloud Architecture & DevOps">Cloud Architecture & DevOps</option>
                                    <option value="Custom Web & Full-Stack Apps">Custom Web & Full-Stack Apps</option>
                                    <option value="Mobile & Cross-Platform Apps">Mobile & Cross-Platform Apps</option>
                                    <option value="AI Engineering & Intelligent Agents">AI Engineering & Intelligent Agents</option>
                                    <option value="Product UI/UX & Design Systems">Product UI/UX & Design Systems</option>
                                    <option value="Cybersecurity & DevSecOps">Cybersecurity & DevSecOps</option>
                                    <option value="Full Digital Transformation">Full Digital Transformation</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="clientBudget" class="form-label">Estimated Budget Range</label>
                                <select class="form-select" id="clientBudget" name="budget">
                                    <option value="$25,000 - $50,000">$25,000 - $50,000</option>
                                    <option value="$50,000 - $100,000" selected>$50,000 - $100,000</option>
                                    <option value="$100,000 - $250,000">$100,000 - $250,000</option>
                                    <option value="$250,000+">$250,000+</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="clientMessage" class="form-label">Project Scope & Objectives <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="clientMessage" name="message" rows="3" required placeholder="Tell us about your system requirements, target launch timeline, and key performance milestones..."></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <button type="submit" class="btn-submit-consultation" id="consultationSubmitBtn">
                            <span>Confirm Consultation Request</span>
                            <i class="bi bi-arrow-right ms-2" aria-hidden="true"></i>
                        </button>
                    </form>

                    <!-- Success Confirmation View -->
                    <div id="consultationSuccessView" class="d-none text-center py-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle p-3 mb-3" style="width: 72px; height: 72px;">
                            <i class="bi bi-check-circle-fill fs-1" aria-hidden="true"></i>
                        </div>
                        <h3 class="h4 fw-bold mb-2">Consultation Scheduled!</h3>
                        <p class="text-secondary mb-4">
                            Thank you, <strong id="confirmedClientName">Valued Partner</strong>. Our principal solutions architect will review your technical requirements and contact you within 24 business hours.
                        </p>
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-dismiss="modal">
                            Return to Website
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ==========================================================================
       Site Footer
       ========================================================================== -->
    <footer class="site-footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('assets/images/logo.webp') }}" alt="Mahishika Digital" class="brand-logo__img" height="34">
                    </div>
                    <p class="text-secondary small mb-3">
                        A world-class digital agency engineering resilient cloud architectures, scalable web applications, and accessible design systems.
                    </p>
                    <div class="small text-muted">
                        <i class="bi bi-geo-alt me-1" aria-hidden="true"></i> San Francisco &bull; London &bull; Bengaluru
                    </div>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <div class="footer-heading">Capabilities</div>
                    <ul class="footer-links">
                        <li><a href="#services-cloud">Cloud Architecture</a></li>
                        <li><a href="#services-web">Full-Stack Apps</a></li>
                        <li><a href="#services-mobile">Mobile Systems</a></li>
                        <li><a href="#services-ai">AI & Machine Learning</a></li>
                        <li><a href="#services-design">UI/UX Systems</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <div class="footer-heading">Industries</div>
                    <ul class="footer-links">
                        <li><a href="#industry-fintech">FinTech & Banking</a></li>
                        <li><a href="#industry-healthtech">Healthcare & Telehealth</a></li>
                        <li><a href="#industry-ecommerce">Omnichannel Retail</a></li>
                        <li><a href="#industry-saas">Enterprise SaaS</a></li>
                        <li><a href="#industry-logistics">Smart Supply Chain</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <div class="footer-heading">Company</div>
                    <ul class="footer-links">
                        <li><a href="#about-story">Our Story</a></li>
                        <li><a href="#approach-section">The Playbook</a></li>
                        <li><a href="#work-section">Client Roster</a></li>
                        <li><a href="#about-careers">Careers (Hiring)</a></li>
                        <li><a href="{{ route('admin.dashboard') }}">Admin Portal</a></li>
                    </ul>
                </div>

                <div class="col-6 col-md-3 col-lg-2">
                    <div class="footer-heading">Compliance</div>
                    <ul class="footer-links">
                        <li><a href="#">WCAG 2.1 AA Statement</a></li>
                        <li><a href="#">Security & Privacy</a></li>
                        <li><a href="#">SOC2 Type II Report</a></li>
                        <li><a href="#">Open Source Notice</a></li>
                        <li><a href="/api/menu" target="_blank">Menu API JSON</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    &copy; {{ date('Y') }} Mahishika Digital Inc. All rights reserved. Built with precision and care.
                </div>
                <div class="d-flex align-items-center gap-3">
                    <span class="badge bg-body-secondary text-body fw-normal border">WCAG 2.1 AA Compliant</span>
                    <span class="badge bg-body-secondary text-body fw-normal border">Lighthouse 90+ Target</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Application JavaScript Bundle -->
    <script type="module" src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>

