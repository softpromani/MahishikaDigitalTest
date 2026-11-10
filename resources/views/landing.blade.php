<!DOCTYPE html>
<html lang="en" data-theme="light" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Analytics & Tracking Services | Mahishika Digital</title>
    <meta name="description" content="GA4, Tag Manager, and conversion tracking set up properly with one revenue dashboard that connects marketing to revenue.">
    <meta name="theme-color" content="#0070f3">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 & Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/css/tokens.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/mega-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
</head>
<body>
    <!-- Accessibility Skip Link -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- ==========================================================================
       Site Header with Mega Menu (from Zeplin & Task PDF)
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
                    <!-- 1. Services with 3-Column Zeplin Mega Menu Dropdown -->
                    <li class="mega-menu-item" role="none">
                        <button type="button" 
                                class="mega-menu-trigger" 
                                role="menuitem" 
                                aria-haspopup="true" 
                                aria-expanded="false" 
                                aria-controls="megaMenuZeplin"
                                id="servicesTrigger">
                            <span>Services</span>
                            <i class="bi bi-chevron-down chevron-icon" aria-hidden="true"></i>
                        </button>

                        <!-- Zeplin 3-Column Floating Mega Menu -->
                        <div class="mega-menu-panel--zeplin" id="megaMenuZeplin" role="region" aria-labelledby="servicesTrigger" aria-hidden="true">
                            <div class="mega-zeplin-body">
                                <!-- Column 1: Verticals Sidebar (Design, Video, Tech, Marketing) -->
                                <div class="mega-zeplin-sidebar">
                                    <div class="mega-sidebar-title">Services</div>
                                    
                                    @php
                                        // Ensure standard order for verticals
                                        $verticalOrder = ['design', 'video', 'tech', 'marketing'];
                                        $sortedVerticals = $serviceVerticals->sortBy(function($cat) use ($verticalOrder) {
                                            $idx = array_search($cat->slug, $verticalOrder);
                                            return $idx !== false ? $idx : 99;
                                        });
                                    @endphp

                                    @foreach($sortedVerticals as $vCat)
                                        @php
                                            $dotClass = match($vCat->slug) {
                                                'design' => 'tab-dot--design',
                                                'video' => 'tab-dot--video',
                                                'tech' => 'tab-dot--tech',
                                                'marketing' => 'tab-dot--marketing',
                                                default => 'tab-dot--tech'
                                            };
                                            // Tech is default active tab as shown in Zeplin
                                            $isActive = ($vCat->slug === 'tech');
                                        @endphp
                                        <button type="button" 
                                                class="mega-vertical-tab {{ $isActive ? 'is-active' : '' }}" 
                                                data-vertical-target="panel-vertical-{{ $vCat->slug }}"
                                                aria-selected="{{ $isActive ? 'true' : 'false' }}">
                                            <div class="tab-left">
                                                <span class="tab-dot {{ $dotClass }}"></span>
                                                <div class="text-start">
                                                    <div class="tab-name">{{ $vCat->name }}</div>
                                                    <span class="tab-count">{{ $vCat->subCategories->count() }} services</span>
                                                </div>
                                            </div>
                                            <i class="bi bi-chevron-right tab-chevron" aria-hidden="true"></i>
                                        </button>
                                    @endforeach
                                </div>

                                <!-- Column 2: Center Services Grid (2 Columns x 3 Rows) -->
                                <div class="mega-zeplin-center">
                                    @foreach($sortedVerticals as $vCat)
                                        @php
                                            $isActive = ($vCat->slug === 'tech');
                                            $hubTitle = $vCat->name . ' Services';
                                            $tagline = $vCat->description ?? ($vCat->slug === 'tech' ? 'A site, store, or app that works without babysitting.' : 'Capabilities tailored for enterprise scale.');
                                        @endphp
                                        <div class="mega-tab-content-panel {{ $isActive ? 'is-active' : '' }}" id="panel-vertical-{{ $vCat->slug }}">
                                            <div class="mega-center-header">
                                                <div class="title-row">
                                                    <h3>{{ $hubTitle }}</h3>
                                                    <a href="#{{ $vCat->slug }}-hub" class="mega-hub-link">
                                                        <span>Explore {{ $vCat->name }} hub</span>
                                                        <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                                <p class="tagline">{{ $tagline }}</p>
                                            </div>

                                            <div class="mega-service-grid">
                                                @foreach($vCat->subCategories as $index => $sub)
                                                    @php
                                                        // Highlight the first item as in Zeplin (Website Development)
                                                        $isHighlight = ($vCat->slug === 'tech' && $index === 0);
                                                    @endphp
                                                    <a href="{{ $sub->url }}" class="mega-service-item {{ $isHighlight ? 'is-highlighted' : '' }}">
                                                        <div class="item-title-row">
                                                            <span class="item-title">{{ $sub->title }}</span>
                                                            <i class="bi bi-arrow-right item-arrow" aria-hidden="true"></i>
                                                        </div>
                                                        <p class="item-desc">{{ $sub->description }}</p>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Column 3: Featured Project -->
                                <div class="mega-zeplin-featured">
                                    <div class="mega-featured-title">Featured Project</div>

                                    @foreach($sortedVerticals as $vCat)
                                        @php
                                            $isActive = ($vCat->slug === 'tech');
                                            $featuredItem = $vCat->portfolioArticles->where('is_featured', true)->first() ?? $vCat->portfolioArticles->first();
                                            $localImgs = [
                                                'tech' => asset('assets/images/tech-case.jpg'),
                                                'design' => asset('assets/images/design-case.jpg'),
                                                'video' => asset('assets/images/video-case.jpg'),
                                                'marketing' => asset('assets/images/marketing-case.jpg'),
                                            ];
                                            $caseImg = $localImgs[$vCat->slug] ?? asset('assets/images/tech-case.jpg');
                                            if ($featuredItem && !empty($featuredItem->image_url)) {
                                                if (str_starts_with($featuredItem->image_url, '/')) {
                                                    $caseImg = asset(ltrim($featuredItem->image_url, '/'));
                                                } elseif (!str_starts_with($featuredItem->image_url, 'http')) {
                                                    $caseImg = asset($featuredItem->image_url);
                                                }
                                            }
                                            $caseHeadline = $featuredItem ? $featuredItem->title : '[' . ($vCat->name) . ' Client]: checkout rebuilt and mobile load time cut in half';
                                            $caseLink = $featuredItem ? $featuredItem->link_url : '#portfolio';
                                        @endphp
                                        <div class="mega-featured-item-panel {{ $isActive ? 'd-flex' : 'd-none' }} flex-column h-100" id="featured-vertical-{{ $vCat->slug }}">
                                            <div class="featured-case-box">
                                                <img src="{{ $caseImg }}" alt="{{ $caseHeadline }}" class="featured-case-img" loading="eager">
                                                <span class="featured-case-tag">{{ $vCat->name }} Case</span>
                                            </div>
                                            <h4 class="featured-case-headline">{{ $caseHeadline }}</h4>
                                            <a href="{{ $caseLink }}" class="featured-case-link">
                                                <span>View in portfolio</span>
                                                <i class="bi bi-arrow-right" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Bottom Bar -->
                            <div class="mega-zeplin-footer">
                                <div class="footer-left">
                                    <strong>Not sure where to start?</strong>
                                    <span>We'll map it with you.</span>
                                </div>
                                <div class="footer-right">
                                    <a href="#growth-audit" class="mega-footer-link--primary" data-bs-toggle="modal" data-bs-target="#consultationModal">Get a free growth audit &rarr;</a>
                                    <a href="#all-services" class="mega-footer-link--secondary">All services &rarr;</a>
                                </div>
                            </div>
                        </div>
                    </li>

                    <!-- 2. Portfolio -->
                    <li class="mega-menu-item" role="none">
                        <a href="#portfolio" class="mega-menu-trigger" role="menuitem">Portfolio</a>
                    </li>

                    <!-- 3. Industries -->
                    <li class="mega-menu-item" role="none">
                        <a href="#industries" class="mega-menu-trigger" role="menuitem">Industries</a>
                    </li>

                    <!-- 4. About (with hover dropdown showing subcategories) -->
                    <li class="mega-menu-item about-nav-item" role="none">
                        <a href="#about" class="mega-menu-trigger d-inline-flex align-items-center gap-1" role="menuitem" id="aboutTrigger">
                            <span>About</span>
                            <i class="bi bi-chevron-down chevron-icon" aria-hidden="true" style="font-size: 0.7rem;"></i>
                        </a>
                        @if(isset($aboutCategory) && $aboutCategory && $aboutCategory->subCategories->isNotEmpty())
                            <div class="about-dropdown-menu shadow-lg" role="region" aria-labelledby="aboutTrigger">
                                <div class="about-dropdown-header">
                                    <span class="about-dropdown-caption">Company &amp; Culture</span>
                                </div>
                                <ul class="about-dropdown-list list-unstyled mb-0">
                                    @foreach($aboutCategory->subCategories as $sub)
                                        <li>
                                            <a href="{{ $sub->url }}" class="about-dropdown-item">
                                                <div class="about-item-icon">
                                                    <i class="bi {{ $sub->icon ?? 'bi-building' }}"></i>
                                                </div>
                                                <div class="about-item-body">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="about-item-title">{{ $sub->title }}</span>
                                                        @if($sub->badge)
                                                            <span class="about-item-badge">{{ $sub->badge }}</span>
                                                        @endif
                                                    </div>
                                                    <span class="about-item-sub">{{ Str::limit($sub->description, 50) }}</span>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                <div class="about-dropdown-footer">
                                    <a href="#about" class="about-dropdown-all">
                                        <span>View all about company</span>
                                        <i class="bi bi-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        @endif
                    </li>

                    <!-- 5. Blog -->
                    <li class="mega-menu-item" role="none">
                        <a href="#insights" class="mega-menu-trigger" role="menuitem">Blog</a>
                    </li>

                    <!-- 6. Contact -->
                    <li class="mega-menu-item" role="none">
                        <a href="#contact" class="mega-menu-trigger" role="menuitem" data-bs-toggle="modal" data-bs-target="#consultationModal">Contact</a>
                    </li>
                </ul>
            </nav>

            <!-- Header Actions -->
            <div class="header-actions">
                <!-- Primary CTA Button (from Figma) -->
                <a href="#growth-audit" class="btn-zeplin-primary d-none d-sm-inline-flex" data-bs-toggle="modal" data-bs-target="#consultationModal">
                    Book a growth audit
                </a>

                <!-- Mobile Hamburger Button (Strictly shown only on tablet / mobile) -->
                <button type="button" class="mobile-toggle-btn d-lg-none" id="mobileMenuBtn" aria-label="Open mobile navigation" aria-expanded="false" aria-controls="mobileDrawer">
                    <i class="bi bi-list fs-4"></i>
                </button>
            </div>
        </div>
    </header>

    <!-- Mega Menu Backdrop Overlay -->
    <div class="mega-menu-backdrop" id="megaMenuBackdrop"></div>

    <!-- Mobile Drawer -->
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
                <!-- Services Accordion Item -->
                <li class="mobile-menu-item">
                    <button type="button" class="mobile-menu-trigger" aria-expanded="true" aria-controls="mobile-sub-services">
                        <span class="d-flex align-items-center gap-2">
                            <i class="bi bi-layers-half text-primary"></i>
                            <span class="fw-bold">Services</span>
                        </span>
                        <i class="bi bi-chevron-down chevron-icon" aria-hidden="true"></i>
                    </button>
                    <div class="mobile-submenu-collapse is-open" id="mobile-sub-services">
                        <ul class="mobile-sublink-list">
                            @foreach($serviceVerticals as $vCat)
                                <li class="px-3 pt-2 pb-1 text-uppercase text-secondary fw-bold small" style="font-size: 0.72rem;">{{ $vCat->name }}</li>
                                @foreach($vCat->subCategories as $sub)
                                    <li>
                                        <a href="{{ $sub->url }}" class="mobile-sublink">
                                            <i class="bi {{ $sub->icon ?? 'bi-arrow-right-short' }} mobile-sublink__icon"></i>
                                            <span>{{ $sub->title }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                </li>

                <li class="mobile-menu-item">
                    <a href="#portfolio" class="mobile-menu-trigger text-decoration-none">
                        <span>Portfolio</span>
                    </a>
                </li>
                <li class="mobile-menu-item">
                    <a href="#industries" class="mobile-menu-trigger text-decoration-none">
                        <span>Industries</span>
                    </a>
                </li>
                <li class="mobile-menu-item">
                    <a href="#about" class="mobile-menu-trigger text-decoration-none">
                        <span>About</span>
                    </a>
                </li>
                <li class="mobile-menu-item">
                    <a href="#insights" class="mobile-menu-trigger text-decoration-none">
                        <span>Blog</span>
                    </a>
                </li>
                <li class="mobile-menu-item">
                    <a href="#contact" class="mobile-menu-trigger text-decoration-none" data-bs-toggle="modal" data-bs-target="#consultationModal">
                        <span>Contact</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="mobile-drawer__footer">
            <a href="#growth-audit" class="btn-zeplin-primary w-100 justify-content-center" data-bs-toggle="modal" data-bs-target="#consultationModal">
                Book a Consultation
            </a>
            <div class="mt-3 text-center">
                <a href="{{ route('admin.dashboard') }}" class="small text-secondary text-decoration-none">
                    <i class="bi bi-shield-lock me-1"></i> Admin Portal
                </a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main id="main-content">
        <!-- ==========================================================================
           3. Hero Section (Image 1 from Zeplin)
           ========================================================================== -->
        <section class="py-5" id="overview">
            <div class="container-xl">
                <div class="row g-4 align-items-start">
                    <!-- Left Hero Column -->
                    <div class="col-lg-7 pe-lg-4">
                        <!-- Breadcrumb -->
                        <nav aria-label="breadcrumb" class="marketing-breadcrumb">
                            <a href="{{ route('home') }}">Home</a>
                            <span class="mx-1">/</span>
                            <a href="#services">Services</a>
                            <span class="mx-1">/</span>
                            <a href="#marketing">Marketing</a>
                            <span class="mx-1">/</span>
                            <span class="current">Analytics &amp; Tracking</span>
                        </nav>

                        <!-- H1 Heading -->
                        <h1 class="marketing-h1">Numbers you can actually trust.</h1>

                        <!-- Subhead -->
                        <p class="marketing-subhead">
                            GA4, Tag Manager and conversion tracking set up properly, with one dashboard that shows which channels drive revenue, so every decision starts from real data.
                        </p>

                        <!-- CTAs -->
                        <div class="d-flex flex-wrap align-items-center gap-3">
                            <a href="#growth-audit" class="btn-zeplin-primary" data-bs-toggle="modal" data-bs-target="#consultationModal">
                                Book a growth audit
                            </a>
                            <a href="#portfolio" class="btn-zeplin-outline">
                                See related portfolio pieces
                            </a>
                        </div>

                        <!-- Pill Badges -->
                        <div class="hero-pill-group">
                            <span class="hero-pill-badge">GA4 + Tag Manager</span>
                            <span class="hero-pill-badge">Conversion tracking</span>
                            <span class="hero-pill-badge">One revenue dashboard</span>
                        </div>

                        <!-- Revenue Dashboard Graphic Card -->
                        <div class="revenue-dashboard-preview">
                            <div class="revenue-dashboard-header">Revenue Dashboard &bull; All Channels</div>

                            <!-- 4 Metric Cards -->
                            <div class="metric-blocks-grid">
                                <div class="metric-mini-card">
                                    <span class="label">Revenue</span>
                                    <div class="val is-placeholder" data-placeholder="true">&#8377;[00L]</div>
                                </div>
                                <div class="metric-mini-card">
                                    <span class="label">Leads</span>
                                    <div class="val is-placeholder" data-placeholder="true">[000]</div>
                                </div>
                                <div class="metric-mini-card">
                                    <span class="label">CPA</span>
                                    <div class="val is-placeholder" data-placeholder="true">&#8377;[000]</div>
                                </div>
                                <div class="metric-mini-card">
                                    <span class="label">ROAS</span>
                                    <div class="val is-placeholder" data-placeholder="true">[0.0x]</div>
                                </div>
                            </div>

                            <!-- Bar Chart Visual -->
                            <div class="dashboard-bar-chart-card">
                                <div class="bar-chart-column">
                                    <div class="bar-chart-pillar" style="height: 52px;" title="SEO: ₹2.4L"></div>
                                    <span class="bar-chart-label">SEO</span>
                                </div>
                                <div class="bar-chart-column">
                                    <div class="bar-chart-pillar" style="height: 108px;" title="Paid: ₹4.8L"></div>
                                    <span class="bar-chart-label">Paid</span>
                                </div>
                                <div class="bar-chart-column">
                                    <div class="bar-chart-pillar" style="height: 80px;" title="Social: ₹3.1L"></div>
                                    <span class="bar-chart-label">Social</span>
                                </div>
                                <div class="bar-chart-column">
                                    <div class="bar-chart-pillar" style="height: 125px;" title="Email: ₹5.6L"></div>
                                    <span class="bar-chart-label">Email</span>
                                </div>
                                <div class="bar-chart-column">
                                    <div class="bar-chart-pillar" style="height: 44px;" title="Referral: ₹1.9L"></div>
                                    <span class="bar-chart-label">Referral</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Floating Form Aside Card -->
                    <div class="col-lg-5">
                        <aside class="zeplin-form-aside" id="growth-audit-aside">
                            <div class="card-content">
                                <h3>Book a growth audit</h3>
                                <p class="card-subtext">Tell us what you track today. We'll show you what's missing.</p>

                                <form action="{{ route('consultations.submit') }}" method="POST" id="asideGrowthAuditForm">
                                    @csrf
                                    <div class="zeplin-input-group">
                                        <label for="asideName">Name</label>
                                        <input type="text" name="name" id="asideName" class="zeplin-form-control" required placeholder="Your full name">
                                    </div>

                                    <div class="zeplin-input-group">
                                        <label for="asideEmail">Work email</label>
                                        <input type="email" name="email" id="asideEmail" class="zeplin-form-control" required placeholder="name@company.com">
                                    </div>

                                    <div class="zeplin-input-group">
                                        <label for="asideCompany">Company</label>
                                        <input type="text" name="company" id="asideCompany" class="zeplin-form-control" placeholder="Company or organization">
                                    </div>

                                    <div class="zeplin-input-group">
                                        <label for="asideStart">Where should we start?</label>
                                        <select name="service_interest" id="asideStart" class="zeplin-form-control">
                                            <option value="Not sure yet">Not sure yet</option>
                                            <option value="GA4 & Tag Manager Setup">GA4 &amp; Tag Manager Setup</option>
                                            <option value="Conversion Tracking & CAPI">Conversion Tracking &amp; CAPI</option>
                                            <option value="Revenue Dashboards & Reporting">Revenue Dashboards &amp; Reporting</option>
                                            <option value="Full Tracking Audit">Full Tracking Audit</option>
                                        </select>
                                    </div>

                                    <div class="zeplin-input-group">
                                        <label>What do you need help with?</label>
                                        <div class="help-checkbox-grid">
                                            <label class="help-check-pill">
                                                <input type="checkbox" name="help_topics[]" value="Design" class="form-check-input mt-0">
                                                <span>Design</span>
                                            </label>
                                            <label class="help-check-pill">
                                                <input type="checkbox" name="help_topics[]" value="Video" class="form-check-input mt-0">
                                                <span>Video</span>
                                            </label>
                                            <label class="help-check-pill">
                                                <input type="checkbox" name="help_topics[]" value="Tech" class="form-check-input mt-0">
                                                <span>Tech</span>
                                            </label>
                                            <label class="help-check-pill">
                                                <input type="checkbox" name="help_topics[]" value="Marketing" class="form-check-input mt-0" checked>
                                                <span>Marketing</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="zeplin-input-group">
                                        <label for="asideMessage">What's not working today?</label>
                                        <textarea name="message" id="asideMessage" class="zeplin-form-control" rows="3" placeholder="Discrepant channel reports, missing GA4 events, broken Meta pixel..."></textarea>
                                    </div>

                                    <button type="submit" class="btn-submit-audit" id="asideSubmitBtn">
                                        Book my growth audit
                                    </button>

                                    <a href="#consultationModal" data-bs-toggle="modal" data-bs-target="#consultationModal" class="expert-link">
                                        Book a free discussion with Expert
                                    </a>

                                    <ul class="aside-bullet-list">
                                        <li class="aside-bullet-item">
                                            <span class="aside-bullet-dot" style="background-color: #f59e0b;"></span>
                                            <span>Talk to the team that does the work</span>
                                        </li>
                                        <li class="aside-bullet-item">
                                            <span class="aside-bullet-dot" style="background-color: #ef4444;"></span>
                                            <span>Leave with a ranked list of gaps</span>
                                        </li>
                                        <li class="aside-bullet-item">
                                            <span class="aside-bullet-dot" style="background-color: #0ea5e9;"></span>
                                            <span>No obligation to use all four services</span>
                                        </li>
                                    </ul>
                                </form>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================================================
           4. Sticky In-Page Navigation Bar (Image 2 from Zeplin)
           ========================================================================== -->
        <nav class="in-page-nav-bar" aria-label="Section navigation">
            <div class="container-xl">
                <ul class="in-page-nav-list">
                    <li><a href="#overview" class="in-page-nav-link active">Overview</a></li>
                    <li><a href="#what-we-build" class="in-page-nav-link">What we build</a></li>
                    <li><a href="#where-to-start" class="in-page-nav-link">Where to start</a></li>
                    <li><a href="#how-it-connects" class="in-page-nav-link">How it connects</a></li>
                    <li><a href="#process" class="in-page-nav-link">Process</a></li>
                    <li><a href="#portfolio" class="in-page-nav-link">Portfolio</a></li>
                    <li><a href="#about" class="in-page-nav-link">About</a></li>
                    <li><a href="#insights" class="in-page-nav-link">Blog</a></li>
                    <li><a href="#faq" class="in-page-nav-link">FAQ</a></li>
                </ul>
            </div>
        </nav>

        <!-- ==========================================================================
           5. Problem Quotes Section (Image 2 from Zeplin)
           ========================================================================== -->
        <section class="py-5">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-8">
                        <h2 class="marketing-section-h2">Every channel reports a different number.</h2>
                        <p class="marketing-section-sub">Without trustworthy tracking, every budget decision is a guess.</p>

                        <!-- 4 Quote Cards -->
                        <div class="problem-quotes-grid">
                            <div class="problem-quote-card border-amber">
                                <h3 class="quote-title">&ldquo;Google and Meta both claim the same sale.&rdquo;</h3>
                                <p class="quote-desc">Each platform counts conversions its own way.</p>
                            </div>
                            <div class="problem-quote-card border-red">
                                <h3 class="quote-title">&ldquo;Our GA4 numbers don't match our CRM.&rdquo;</h3>
                                <p class="quote-desc">Events and conversions were never set up consistently.</p>
                            </div>
                            <div class="problem-quote-card border-cyan">
                                <h3 class="quote-title">&ldquo;We don't know which channel drives revenue.&rdquo;</h3>
                                <p class="quote-desc">Leads lose their source somewhere between the click and the deal.</p>
                            </div>
                            <div class="problem-quote-card border-green">
                                <h3 class="quote-title">&ldquo;Our reports take a week to put together.&rdquo;</h3>
                                <p class="quote-desc">Data lives in five tools and a spreadsheet.</p>
                            </div>
                        </div>

                        <h3 class="h4 fw-bold text-dark mt-4 mb-2" style="color: #1e295d !important;">
                            Every channel depends on tracking being right first. That's why it's usually where we start.
                        </h3>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================================================
           6. What We Build: 4 Solution Cards (Image 3 from Zeplin)
           ========================================================================== -->
        <section class="py-5 bg-body-tertiary" id="what-we-build">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-8">
                        <h2 class="marketing-section-h2">Four parts of measurement, one source of truth.</h2>
                        <p class="marketing-section-sub">Each part fixes a gap. Together, you see the whole funnel.</p>

                        <!-- 4 Service Cards Grid -->
                        <div class="solution-services-grid">
                            <!-- Card 1 -->
                            <div class="solution-service-card">
                                <h4>GA4 and event setup</h4>
                                <p class="card-subtext">The foundation every report depends on.</p>
                                <ul class="solution-bullet-list">
                                    <li class="solution-bullet-item">GA4 property and event plan</li>
                                    <li class="solution-bullet-item">Ecommerce and lead events</li>
                                    <li class="solution-bullet-item">Consent mode setup</li>
                                </ul>
                            </div>

                            <!-- Card 2 -->
                            <div class="solution-service-card">
                                <h4>Tag management</h4>
                                <p class="card-subtext">Tags that fire when they should.</p>
                                <ul class="solution-bullet-list">
                                    <li class="solution-bullet-item">Google Tag Manager setup</li>
                                    <li class="solution-bullet-item">Server-side tagging</li>
                                    <li class="solution-bullet-item">Tag audits and cleanup</li>
                                </ul>
                            </div>

                            <!-- Card 3 -->
                            <div class="solution-service-card">
                                <h4>Conversion tracking</h4>
                                <p class="card-subtext">Platforms that learn from real results.</p>
                                <ul class="solution-bullet-list">
                                    <li class="solution-bullet-item">Meta Pixel and Conversions API</li>
                                    <li class="solution-bullet-item">Google Ads conversions</li>
                                    <li class="solution-bullet-item">Offline and CRM conversions</li>
                                </ul>
                            </div>

                            <!-- Card 4 (Highlighted in Zeplin) -->
                            <div class="solution-service-card is-active-border">
                                <h4>Dashboards and reporting</h4>
                                <p class="card-subtext">One view of what drives revenue.</p>
                                <ul class="solution-bullet-list">
                                    <li class="solution-bullet-item">Looker Studio dashboards</li>
                                    <li class="solution-bullet-item">Channel attribution views</li>
                                    <li class="solution-bullet-item">Monthly ROI reporting</li>
                                </ul>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           7. Outcomes: Delivered vs What Changes (Image 4 from Zeplin)
                           ========================================================================== -->
                        <h2 class="marketing-section-h2">What you walk away with.</h2>
                        <p class="marketing-section-sub">One version of the truth, updated automatically.</p>

                        <div class="outcomes-grid">
                            <!-- Delivered Green Box -->
                            <div class="outcome-box--delivered">
                                <h3 class="outcome-box-title">Delivered</h3>
                                <ul class="outcome-bullet-list">
                                    <li class="outcome-bullet-item">A clean GA4 and Tag Manager setup</li>
                                    <li class="outcome-bullet-item">Conversion tracking on every ad platform</li>
                                    <li class="outcome-bullet-item">A revenue dashboard across channels</li>
                                </ul>
                            </div>

                            <!-- What changes for you Gray Box -->
                            <div class="outcome-box--changes">
                                <h3 class="outcome-box-title">What changes for you</h3>
                                <ul class="outcome-bullet-list">
                                    <li class="outcome-bullet-item">Budget decisions start from real data</li>
                                    <li class="outcome-bullet-item">Ad platforms optimise on real conversions</li>
                                    <li class="outcome-bullet-item">Reporting takes minutes, not days</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================================================
           8. Where Should Your Tracking Start? (Image 4 from Zeplin)
           ========================================================================== -->
        <section class="py-5" id="where-to-start">
            <div class="container-xl">
                <div class="row">
                    <div class="col-lg-8">
                        <h2 class="marketing-section-h2">Where should your tracking start?</h2>
                        <p class="marketing-section-sub">It depends on what you can't see today.</p>

                        <div class="where-start-grid">
                            <div class="where-start-card is-active-green">
                                <h4>Foundation first</h4>
                                <p class="start-desc">Your GA4 setup is missing or broken.</p>
                                <ul class="solution-bullet-list">
                                    <li class="solution-bullet-item">Missing or duplicated events</li>
                                    <li class="solution-bullet-item">Numbers that don't add up</li>
                                </ul>
                            </div>

                            <div class="where-start-card">
                                <h4>Conversions first</h4>
                                <p class="start-desc">Ad platforms can't see what converts.</p>
                                <ul class="solution-bullet-list">
                                    <li class="solution-bullet-item">No Conversions API</li>
                                    <li class="solution-bullet-item">Leads not linked to campaigns</li>
                                </ul>
                            </div>

                            <div class="where-start-card">
                                <h4>Reporting first</h4>
                                <p class="start-desc">The data exists but nobody can read it.</p>
                                <ul class="solution-bullet-list">
                                    <li class="solution-bullet-item">Manual weekly reports</li>
                                    <li class="solution-bullet-item">No single dashboard</li>
                                </ul>
                            </div>
                        </div>

                        <div class="callout-banner-pill">
                            Most setups need all three. The audit shows which gap is costing you the most.
                        </div>

                        <!-- ==========================================================================
                           9. Cross-Discipline Integration Tree (Image 5 from Zeplin)
                           ========================================================================== -->
                        <div class="integration-tree-container" id="how-it-connects">
                            <h2 class="marketing-section-h2">Tracking that every other team depends on.</h2>
                            <p class="marketing-section-sub">Analytics only works if every channel and page is measured the same way.</p>

                            <!-- Root System Box -->
                            <div class="system-root-card">
                                <h4>Your measurement system</h4>
                                <p>Built by Marketing, used by three other disciplines</p>
                            </div>

                            <!-- 3 Branches -->
                            <div class="discipline-branches-grid">
                                <div class="discipline-branch-card border-amber">
                                    <h5>Design uses it</h5>
                                    <p>Heatmaps and funnel data show which layouts actually convert.</p>
                                    <a href="#design-hub">Explore design &rarr;</a>
                                </div>

                                <div class="discipline-branch-card border-red">
                                    <h5>Video uses it</h5>
                                    <p>View and retention data decide which videos get more budget.</p>
                                    <a href="#video-hub">Explore video &rarr;</a>
                                </div>

                                <div class="discipline-branch-card border-cyan">
                                    <h5>Tech feeds it</h5>
                                    <p>Clean code and a data layer make tracking accurate and fast.</p>
                                    <a href="#tech-hub">Explore tech &rarr;</a>
                                </div>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           10. How an Analytics Engagement Runs (Process from Zeplin)
                           ========================================================================== -->
                        <div class="process-section" id="process">
                            <h2 class="marketing-section-h2">How an analytics engagement runs.</h2>
                            <p class="marketing-section-sub">Our 4-D Growth Framework &amp; Approach, applied to measurement.</p>

                            <div class="process-timeline-list">
                                <!-- Step 1 -->
                                <div class="process-timeline-step">
                                    <div class="process-step-num step-orange">1</div>
                                    <div class="process-step-body">
                                        <h4>Discover and audit</h4>
                                        <p>We audit your GA4, tags, pixels and CRM data, and list every gap.</p>
                                        <span class="takeaway">You get: a tracking audit with fixes ranked.</span>
                                    </div>
                                </div>

                                <!-- Step 2 -->
                                <div class="process-timeline-step">
                                    <div class="process-step-num step-red">2</div>
                                    <div class="process-step-body">
                                        <h4>Design and architect</h4>
                                        <p>We write a measurement plan: events, conversions and dashboards.</p>
                                        <span class="takeaway">You get: an approved measurement plan.</span>
                                    </div>
                                </div>

                                <!-- Step 3 -->
                                <div class="process-timeline-step">
                                    <div class="process-step-num step-cyan">3</div>
                                    <div class="process-step-body">
                                        <h4>Deploy and develop</h4>
                                        <p>We implement tags, conversions and dashboards, and test every one.</p>
                                        <span class="takeaway">You get: verified tracking and a live dashboard.</span>
                                    </div>
                                </div>

                                <!-- Step 4 -->
                                <div class="process-timeline-step">
                                    <div class="process-step-num step-green">4</div>
                                    <div class="process-step-body">
                                        <h4>Drive and optimize</h4>
                                        <p>We monitor data quality and report monthly on channel ROI.</p>
                                        <span class="takeaway">You get: monthly ROI reporting and alerts.</span>
                                    </div>
                                </div>
                            </div>

                            <div class="callout-banner-pill">
                                We test every tag before go-live and monitor data quality after, so numbers stay trustworthy.
                            </div>
                        </div>

                        <!-- ==========================================================================
                           11. Tools We Work In (from Zeplin)
                           ========================================================================== -->
                        <div class="tools-section pt-4">
                            <h2 class="marketing-section-h2">Tools we work in.</h2>
                            <div class="tools-chips-wrap">
                                <span class="tool-chip">Google Analytics 4</span>
                                <span class="tool-chip">Google Tag Manager</span>
                                <span class="tool-chip">Looker Studio</span>
                                <span class="tool-chip">Meta Conversions API</span>
                                <span class="tool-chip">BigQuery</span>
                                <span class="tool-chip">HubSpot</span>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           12. Portfolio / Case Studies (from Zeplin)
                           ========================================================================== -->
                        <div class="portfolio-section" id="portfolio">
                            <h2 class="marketing-section-h2">Data that finally matched the bank account.</h2>
                            <p class="marketing-section-sub">Real client work and outcomes delivered with precision measurement and modern infrastructure.</p>

                            <div class="zeplin-portfolio-grid">
                                @forelse($portfolioArticles as $case)
                                    @php
                                        $cardImg = $case->image_url ?? asset('assets/images/portfolio-retail.jpg');
                                        if (str_starts_with($cardImg, '/')) {
                                            $cardImg = asset(ltrim($cardImg, '/'));
                                        }
                                        $resultColorClass = ($loop->iteration % 2 === 1) ? 'text-success' : 'text-primary';
                                        $fallbackTag = $case->category ? $case->category->name : 'Case Study';
                                    @endphp
                                    <div class="zeplin-portfolio-card">
                                        <div class="zeplin-portfolio-thumb">
                                            <img src="{{ $cardImg }}" alt="{{ $case->title }}" class="w-100 h-100 object-fit-cover" onerror="this.src='{{ asset('assets/images/portfolio-retail.jpg') }}'">
                                            <span class="portfolio-thumb-tag">{{ $case->tag ?? $fallbackTag }}</span>
                                        </div>
                                        <div class="portfolio-cat-row">
                                            <span class="portfolio-cat-text">{{ $case->excerpt ?? ($case->client_name ?? 'Featured Case Study') }}</span>
                                            <div class="portfolio-tri-dots">
                                                <span class="dot dot-amber"></span>
                                                <span class="dot dot-cyan"></span>
                                                <span class="dot dot-green"></span>
                                            </div>
                                        </div>
                                        <h4>{{ $case->title }}</h4>
                                        <div class="problem-result-block">
                                            @if($case->content)
                                                <div>
                                                    <span class="meta-label">The problem</span>
                                                    <span class="text-secondary">{{ $case->content }}</span>
                                                </div>
                                            @endif
                                            @if($case->metric)
                                                <div>
                                                    <span class="meta-label">The result</span>
                                                    <div class="result-val {{ $resultColorClass }}">
                                                        {{ $case->metric }}
                                                        @if($case->metric_label)
                                                            <span class="fs-6 fw-normal text-muted">{{ $case->metric_label }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <!-- Fallback if database has no articles yet -->
                                    <div class="col-12 py-5 text-center text-muted">
                                        <p>No portfolio case studies available at the moment.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Testimonial Dark Card -->
                            <div class="zeplin-testimonial-dark">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="{{ asset('assets/images/avatar-marcus.jpg') }}" alt="Marcus Vance Headshot" class="rounded-circle object-fit-cover border border-2 border-primary-subtle" width="54" height="54">
                                    <div>
                                        <div class="text-white fw-bold">Marcus Vance</div>
                                        <div class="text-white-50 small">VP of Growth &amp; Performance, Apex Brands</div>
                                        <div class="d-flex text-warning small mt-1">
                                            <i class="bi bi-star-fill"></i>
                                            <i class="bi bi-star-fill ms-1"></i>
                                            <i class="bi bi-star-fill ms-1"></i>
                                            <i class="bi bi-star-fill ms-1"></i>
                                            <i class="bi bi-star-fill ms-1"></i>
                                            <span class="text-white-50 ms-2" style="font-size: 0.72rem;">Verified Enterprise Review</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="zeplin-testimonial-quote">
                                    &ldquo;For the first time in five years, marketing and finance agree on what each channel is worth. The GA4 and server-side tracking setup paid for itself in the first 30 days.&rdquo;
                                </div>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           13. Industries Block (from Zeplin)
                           ========================================================================== -->
                        <div class="industries-block-box" id="industries">
                            <h2 class="marketing-section-h2">Analytics across sectors.</h2>
                            <p class="marketing-section-sub">Any business spending on more than one channel.</p>

                            <div class="industry-chip-wrap">
                                <a href="#industry-retail" class="industry-chip">Retail and e-commerce</a>
                                <a href="#industry-tech" class="industry-chip">Technology and SaaS</a>
                                <a href="#industry-bfsi" class="industry-chip">BFSI</a>
                                <a href="#industry-edtech" class="industry-chip">Education and EdTech</a>
                                <a href="#industry-travel" class="industry-chip">Travel and hospitality</a>
                            </div>

                            <div class="industry-note-banner">
                                Link each chip to its industry page, and show only industries where you have proof.
                            </div>
                        </div>

                        <!-- ==========================================================================
                           14. Ways to Work Together (3 Packages from Zeplin)
                           ========================================================================== -->
                        <div class="ways-section">
                            <h2 class="marketing-section-h2">Ways to work together.</h2>
                            <p class="marketing-section-sub">A one-time audit, a full setup, or ongoing measurement.</p>

                            <div class="ways-work-grid">
                                <!-- Package 1 -->
                                <div class="ways-work-card top-amber">
                                    <h4>Tracking audit</h4>
                                    <p class="card-subtext">Find every gap.</p>
                                    <ul class="ways-bullet-list">
                                        <li class="ways-bullet-item">GA4, tag and pixel audit</li>
                                        <li class="ways-bullet-item">Prioritised fix list</li>
                                        <li class="ways-bullet-item">No ongoing commitment</li>
                                    </ul>
                                </div>

                                <!-- Package 2 -->
                                <div class="ways-work-card top-cyan">
                                    <h4>Full setup</h4>
                                    <p class="card-subtext">Tracking and dashboards, done properly.</p>
                                    <ul class="ways-bullet-list">
                                        <li class="ways-bullet-item">GA4 and Tag Manager</li>
                                        <li class="ways-bullet-item">Conversion tracking</li>
                                        <li class="ways-bullet-item">Revenue dashboard</li>
                                    </ul>
                                </div>

                                <!-- Package 3 -->
                                <div class="ways-work-card top-green">
                                    <h4>Measurement retainer</h4>
                                    <p class="card-subtext">Data you can keep trusting.</p>
                                    <ul class="ways-bullet-list">
                                        <li class="ways-bullet-item">Monthly data-quality checks</li>
                                        <li class="ways-bullet-item">New events as you grow</li>
                                        <li class="ways-bullet-item">Monthly ROI reporting</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           15. FAQ Accordion (from Zeplin)
                           ========================================================================== -->
                        <div class="zeplin-faq-wrap" id="faq">
                            <h2 class="marketing-section-h2">Questions about analytics and tracking.</h2>

                            <!-- FAQ 1 (Open by default in Zeplin) -->
                            <div class="zeplin-faq-item is-open">
                                <button type="button" class="zeplin-faq-trigger" aria-expanded="true">
                                    <span>Do we need GA4 if we already use other tools?</span>
                                    <span class="zeplin-faq-icon">&plus;</span>
                                </button>
                                <div class="zeplin-faq-body">
                                    Usually yes. GA4 is free, connects to Google Ads, and gives a neutral view across channels that platform reports don't.
                                </div>
                            </div>

                            <!-- FAQ 2 -->
                            <div class="zeplin-faq-item">
                                <button type="button" class="zeplin-faq-trigger" aria-expanded="false">
                                    <span>What is server-side tracking, and do we need it?</span>
                                    <span class="zeplin-faq-icon">&plus;</span>
                                </button>
                                <div class="zeplin-faq-body">
                                    Server-side tracking moves tag processing from the visitor's browser to your cloud server. This bypasses ad-blockers and iOS privacy restrictions, ensuring 100% data fidelity for ad platforms like Meta Conversions API and Google Ads.
                                </div>
                            </div>

                            <!-- FAQ 3 -->
                            <div class="zeplin-faq-item">
                                <button type="button" class="zeplin-faq-trigger" aria-expanded="false">
                                    <span>How do you handle cookie consent and privacy?</span>
                                    <span class="zeplin-faq-icon">&plus;</span>
                                </button>
                                <div class="zeplin-faq-body">
                                    We implement Google Consent Mode v2 and integrate compliant CMP banners (Cookiebot / OneTrust). Tags only fire based on granted permissions, fully adhering to GDPR and CCPA requirements.
                                </div>
                            </div>

                            <!-- FAQ 4 -->
                            <div class="zeplin-faq-item">
                                <button type="button" class="zeplin-faq-trigger" aria-expanded="false">
                                    <span>Can you connect our CRM data to ad platforms?</span>
                                    <span class="zeplin-faq-icon">&plus;</span>
                                </button>
                                <div class="zeplin-faq-body">
                                    Yes. We establish automated pipelines between HubSpot, Salesforce, or your custom CRM and ad networks to pass qualified lead and closed-won deal data back for accurate algorithm optimization.
                                </div>
                            </div>

                            <!-- FAQ 5 -->
                            <div class="zeplin-faq-item">
                                <button type="button" class="zeplin-faq-trigger" aria-expanded="false">
                                    <span>How long does a tracking setup take?</span>
                                    <span class="zeplin-faq-icon">&plus;</span>
                                </button>
                                <div class="zeplin-faq-body">
                                    A comprehensive audit is delivered in 3 to 5 business days. Full GTM, GA4, CAPI implementation and verified revenue dashboards typically take 10 to 14 days start to finish.
                                </div>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           16. More from Marketing (from Zeplin)
                           ========================================================================== -->
                        <div class="more-marketing-section">
                            <h2 class="marketing-section-h2">More from Marketing.</h2>
                            <div class="more-marketing-grid">
                                <a href="#marketing-all" class="more-marketing-card">
                                    <div class="rounded-3 overflow-hidden mb-3" style="height: 105px;">
                                        <img src="{{ asset('assets/images/marketing-case.jpg') }}" alt="All Marketing Services" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <h5>All Marketing services</h5>
                                    <p>SEO, paid ads, social, leads and analytics.</p>
                                </a>
                                <a href="#lead-gen" class="more-marketing-card">
                                    <div class="rounded-3 overflow-hidden mb-3" style="height: 105px;">
                                        <img src="{{ asset('assets/images/lead-gen.jpg') }}" alt="Lead Generation & Funnels" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <h5>Lead Generation &amp; Funnels</h5>
                                    <p>Track every lead from click to deal.</p>
                                </a>
                                <a href="#performance-ads" class="more-marketing-card">
                                    <div class="rounded-3 overflow-hidden mb-3" style="height: 105px;">
                                        <img src="{{ asset('assets/images/performance-ads.jpg') }}" alt="Performance Marketing & Paid Ads" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <h5>Performance Marketing &amp; Paid Ads</h5>
                                    <p>Ads that optimise on real conversions.</p>
                                </a>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           17. About Mahishika Digital (from CMS Categories & Subcategories)
                           ========================================================================== -->
                        <div class="about-section-wrap" id="about">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                                <div>
                                    <h2 class="marketing-section-h2 mb-2">About Mahishika Digital.</h2>
                                    <p class="marketing-section-sub mb-0">Engineers, architects, and visual storytellers building durable digital products and growth infrastructure.</p>
                                </div>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-people-fill me-1"></i> Company &amp; Culture
                                </span>
                            </div>

                            @if(isset($aboutCategory) && $aboutCategory && $aboutCategory->subCategories->isNotEmpty())
                                <div class="about-grid">
                                    @foreach($aboutCategory->subCategories as $sub)
                                        <div class="about-card" id="{{ ltrim($sub->url, '#') }}">
                                            <div class="d-flex align-items-center justify-content-between mb-3">
                                                <div class="about-card-icon">
                                                    <i class="bi {{ $sub->icon ?? 'bi-building' }}"></i>
                                                </div>
                                                @if($sub->badge)
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">{{ $sub->badge }}</span>
                                                @endif
                                            </div>
                                            <h4 class="about-card-title">{{ $sub->title }}</h4>
                                            <p class="about-card-desc">{{ $sub->description }}</p>
                                            <div class="about-card-footer mt-auto pt-3">
                                                <a href="#consultationModal" data-bs-toggle="modal" data-bs-target="#consultationModal" class="about-card-link">
                                                    <span>Explore details</span>
                                                    <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Trust Metrics Strip -->
                            <div class="about-metrics-strip mt-4">
                                <div class="metric-item">
                                    <div class="metric-val text-primary">99.99%</div>
                                    <div class="metric-name">Infrastructure Uptime</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-val text-success">120+</div>
                                    <div class="metric-name">Global Deployments</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-val text-info">14 Days</div>
                                    <div class="metric-name">Sprint-to-Production</div>
                                </div>
                                <div class="metric-item">
                                    <div class="metric-val text-warning">4.9 / 5</div>
                                    <div class="metric-name">Verified Partner CSAT</div>
                                </div>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           18. Engineering & Growth Insights (Blog)
                           ========================================================================== -->
                        <div class="blog-section-wrap" id="insights">
                            <div id="blog" style="position: relative; top: -80px;"></div>
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                                <div>
                                    <h2 class="marketing-section-h2 mb-2">Latest insights &amp; handbooks.</h2>
                                    <p class="marketing-section-sub mb-0">Production architectural teardowns, tracking guides, and growth engineering playbooks.</p>
                                </div>
                                <span class="badge bg-info-subtle text-info border border-info-subtle px-3 py-2 rounded-pill fw-semibold">
                                    <i class="bi bi-journal-text me-1"></i> Engineering Blog
                                </span>
                            </div>

                            <div class="blog-articles-grid">
                                <!-- Article 1 -->
                                <article class="blog-article-card">
                                    <div class="blog-article-thumb">
                                        <img src="{{ asset('assets/images/portfolio-retail.jpg') }}" alt="Server-Side CAPI" class="w-100 h-100 object-fit-cover">
                                        <span class="blog-thumb-badge">Analytics &bull; GA4</span>
                                    </div>
                                    <div class="blog-article-body">
                                        <div class="blog-meta-row">
                                            <span>Nov 2026</span>
                                            <span>&bull;</span>
                                            <span>6 min read</span>
                                        </div>
                                        <h4>Server-Side CAPI vs. Client Pixels: How to Recover 40% Lost Conversion Data</h4>
                                        <p>Why browser privacy updates drop high-intent conversion signals, and how server-side proxy tagging restores full attribution.</p>
                                        <div class="blog-card-bottom">
                                            <span class="blog-author-name"><i class="bi bi-person-circle me-1"></i>Jeetu Prajapati</span>
                                            <a href="#consultationModal" data-bs-toggle="modal" data-bs-target="#consultationModal" class="blog-read-link">
                                                Read guide &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </article>

                                <!-- Article 2 -->
                                <article class="blog-article-card">
                                    <div class="blog-article-thumb">
                                        <img src="{{ asset('assets/images/portfolio-saas.jpg') }}" alt="CloudScale Data Platform" class="w-100 h-100 object-fit-cover">
                                        <span class="blog-thumb-badge">SaaS &bull; Infrastructure</span>
                                    </div>
                                    <div class="blog-article-body">
                                        <div class="blog-meta-row">
                                            <span>Oct 2026</span>
                                            <span>&bull;</span>
                                            <span>8 min read</span>
                                        </div>
                                        <h4>Single Revenue Source of Truth: Aligning Stripe, BigQuery &amp; Finance</h4>
                                        <p>How subscription churn and refund timing disparities create discrepancies between marketing and finance, and how to fix them.</p>
                                        <div class="blog-card-bottom">
                                            <span class="blog-author-name"><i class="bi bi-person-circle me-1"></i>Elena Rostova</span>
                                            <a href="#consultationModal" data-bs-toggle="modal" data-bs-target="#consultationModal" class="blog-read-link">
                                                Read guide &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </article>

                                <!-- Article 3 -->
                                <article class="blog-article-card">
                                    <div class="blog-article-thumb">
                                        <img src="{{ asset('assets/images/tech-case.jpg') }}" alt="14-Day Sprint Engine" class="w-100 h-100 object-fit-cover">
                                        <span class="blog-thumb-badge">Delivery &bull; Agile</span>
                                    </div>
                                    <div class="blog-article-body">
                                        <div class="blog-meta-row">
                                            <span>Oct 2026</span>
                                            <span>&bull;</span>
                                            <span>5 min read</span>
                                        </div>
                                        <h4>The 14-Day Delivery Engine: How We Ship Production Code in Week 2</h4>
                                        <p>Our opinionated scaffolding, ephemeral preview environments, and automated CI test gates that eliminate months of discovery meetings.</p>
                                        <div class="blog-card-bottom">
                                            <span class="blog-author-name"><i class="bi bi-person-circle me-1"></i>Marcus Vance</span>
                                            <a href="#consultationModal" data-bs-toggle="modal" data-bs-target="#consultationModal" class="blog-read-link">
                                                Read guide &rarr;
                                            </a>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        </div>

                        <!-- ==========================================================================
                           19. Bottom Navy CTA Card (from Zeplin)
                           ========================================================================== -->
                        <div class="bottom-cta-navy-card">
                            <h2>Make every decision with numbers you trust.</h2>
                            <p>Tell us what you track today. We'll show you what's missing and what it's costing you.</p>
                            <a href="#consultationModal" class="btn-cta-white" data-bs-toggle="modal" data-bs-target="#consultationModal">
                                Book a growth audit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ==========================================================================
       18. Clean White Footer (Image 6 from Zeplin)
       ========================================================================== -->
    <footer class="zeplin-page-footer">
        <div class="container-xl">
            <div class="row g-4 justify-content-between">
                <!-- Column 1: Brand Info -->
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="d-inline-block mb-3">
                        <img src="{{ asset('assets/images/logo.webp') }}" alt="Mahishika Digital" class="brand-logo__img" height="34">
                    </a>
                    <p class="text-secondary small mb-3" style="max-width: 320px; line-height: 1.6;">
                        Empowering brands with data-driven growth, visual storytelling, and modern digital infrastructure.
                    </p>
                </div>

                <!-- Column 2: Services -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="zeplin-footer-heading">Services</h5>
                    <ul class="zeplin-footer-links">
                        <li><a href="#design-hub">Design</a></li>
                        <li><a href="#video-hub">Video</a></li>
                        <li><a href="#tech-hub">Tech</a></li>
                        <li><a href="#marketing-hub">Marketing</a></li>
                    </ul>
                </div>

                <!-- Column 3: Company -->
                <div class="col-lg-2 col-md-3 col-6">
                    <h5 class="zeplin-footer-heading">Company</h5>
                    <ul class="zeplin-footer-links">
                        <li><a href="#about">About</a></li>
                        <li><a href="#portfolio">Portfolio</a></li>
                        <li><a href="#industries">Industries</a></li>
                        <li><a href="#insights">Blog</a></li>
                        <li><a href="#write-for-us">Write for us</a></li>
                        <li><a href="#careers">Careers</a></li>
                    </ul>
                </div>

                <!-- Column 4: Contact -->
                <div class="col-lg-3 col-md-6">
                    <h5 class="zeplin-footer-heading">Contact</h5>
                    <ul class="zeplin-footer-links">
                        <li><a href="mailto:chat@mahishika.com" class="text-primary fw-medium">chat@mahishika.com</a></li>
                        <li><a href="tel:+918595117352">+91 8595 117 352</a></li>
                        <li class="pt-2">
                            <div class="d-flex align-items-center gap-2 small text-secondary">
                                <a href="https://linkedin.com" target="_blank">[LinkedIn]</a>
                                <a href="https://instagram.com" target="_blank">[Instagram]</a>
                                <a href="https://youtube.com" target="_blank">[YouTube]</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="zeplin-footer-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    &copy; {{ date('Y') }} Mahishika Digital Pvt. Ltd. All rights reserved.
                </div>
                <div>
                    <a href="{{ route('admin.dashboard') }}" class="text-secondary text-decoration-none small">
                        <i class="bi bi-shield-lock me-1"></i> Admin Portal
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==========================================================================
       19. Consultation Modal
       ========================================================================== -->
    <div class="modal fade" id="consultationModal" tabindex="-1" aria-labelledby="consultationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg border-0" style="border-radius: 18px; overflow: hidden;">
                <div class="modal-header border-bottom py-3 px-4 bg-body-tertiary">
                    <div class="d-flex align-items-center gap-2">
                        <span class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-calendar2-check-fill fs-5"></i>
                        </span>
                        <div>
                            <h5 class="modal-title fw-bold fs-6 mb-0" id="consultationModalLabel">Book a Growth Audit &amp; Technical Discovery</h5>
                            <small class="text-muted">Speak directly with a senior engineering architect from Mahishika Digital.</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <form action="{{ route('consultations.submit') }}" method="POST" id="modalConsultationForm">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="mName" class="form-label fw-semibold">Your Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="mName" name="name" required placeholder="e.g. Alex Morgan">
                            </div>
                            <div class="col-md-6">
                                <label for="mEmail" class="form-label fw-semibold">Work Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="mEmail" name="email" required placeholder="alex@company.com">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="mCompany" class="form-label fw-semibold">Company / Organization</label>
                                <input type="text" class="form-control" id="mCompany" name="company" placeholder="e.g. Acme FinTech Labs">
                            </div>
                            <div class="col-md-6">
                                <label for="mPhone" class="form-label fw-semibold">Phone (Optional)</label>
                                <input type="tel" class="form-control" id="mPhone" name="phone" placeholder="+1 (555) 000-0000">
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="mService" class="form-label fw-semibold">Service Focus</label>
                                <select class="form-select" id="mService" name="service_interest">
                                    <option value="Analytics & Tracking" selected>Analytics &amp; Tracking (GA4 + GTM)</option>
                                    <option value="Website Development">Website Development</option>
                                    <option value="WordPress & E-commerce">WordPress &amp; E-commerce</option>
                                    <option value="Custom Web & Cloud Apps">Custom Web &amp; Cloud Apps</option>
                                    <option value="Mobile App Development">Mobile App Development</option>
                                    <option value="UI/UX Product Design">UI/UX Product Design</option>
                                    <option value="Video & Motion Graphics">Video &amp; Motion Graphics</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="mBudget" class="form-label fw-semibold">Budget Range</label>
                                <select class="form-select" id="mBudget" name="budget">
                                    <option value="$10,000 - $25,000">$10,000 - $25,000</option>
                                    <option value="$25,000 - $50,000" selected>$25,000 - $50,000</option>
                                    <option value="$50,000 - $100,000">$50,000 - $100,000</option>
                                    <option value="$100,000+">$100,000+</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="mMessage" class="form-label fw-semibold">Project Scope &amp; Gaps <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="mMessage" name="message" rows="3" required placeholder="What are your key metrics, tracking bottlenecks, or launch deadlines?"></textarea>
                        </div>

                        <button type="submit" class="btn-submit-audit w-100" id="modalSubmitBtn">
                            Confirm Growth Audit Request &rarr;
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Floating Theme Mode Toggle (Bottom Right beside scrollbar) -->
    <button type="button" class="floating-theme-toggle" id="themeToggleBtn" aria-label="Toggle dark/light mode" title="Switch Theme">
        <i class="bi bi-moon-stars" id="themeIcon"></i>
    </button>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom Script for Zeplin Mega Menu & Interactive Elements -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Zeplin Mega Menu Trigger & Vertical Tabs
            const servicesTrigger = document.getElementById('servicesTrigger');
            const megaMenuZeplin = document.getElementById('megaMenuZeplin');
            const megaMenuBackdrop = document.getElementById('megaMenuBackdrop');
            const verticalTabs = document.querySelectorAll('.mega-vertical-tab');
            const servicesItem = servicesTrigger?.closest('.mega-menu-item');

            function openZeplinMegaMenu() {
                megaMenuZeplin?.classList.add('is-open');
                megaMenuBackdrop?.classList.add('is-active');
                servicesTrigger?.setAttribute('aria-expanded', 'true');
                servicesTrigger?.querySelector('.chevron-icon')?.classList.replace('bi-chevron-down', 'bi-chevron-up');
            }

            function closeZeplinMegaMenu() {
                megaMenuZeplin?.classList.remove('is-open');
                megaMenuBackdrop?.classList.remove('is-active');
                servicesTrigger?.setAttribute('aria-expanded', 'false');
                servicesTrigger?.querySelector('.chevron-icon')?.classList.replace('bi-chevron-up', 'bi-chevron-down');
            }

            servicesTrigger?.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                if (megaMenuZeplin?.classList.contains('is-open')) {
                    closeZeplinMegaMenu();
                } else {
                    openZeplinMegaMenu();
                }
            });

            // Backdrop click closes
            megaMenuBackdrop?.addEventListener('click', closeZeplinMegaMenu);

            // Hover with smooth delay
            let menuTimeout;
            servicesItem?.addEventListener('mouseenter', () => {
                clearTimeout(menuTimeout);
                openZeplinMegaMenu();
            });

            servicesItem?.addEventListener('mouseleave', () => {
                menuTimeout = setTimeout(() => {
                    closeZeplinMegaMenu();
                }, 220);
            });

            megaMenuZeplin?.addEventListener('mouseenter', () => {
                clearTimeout(menuTimeout);
            });

            megaMenuZeplin?.addEventListener('mouseleave', () => {
                menuTimeout = setTimeout(() => {
                    closeZeplinMegaMenu();
                }, 220);
            });

            // Close on click outside
            document.addEventListener('click', (e) => {
                if (!megaMenuZeplin?.contains(e.target) && !servicesTrigger?.contains(e.target)) {
                    closeZeplinMegaMenu();
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeZeplinMegaMenu();
            });

            // Interactive Tab Switching inside Mega Menu on hover/click
            verticalTabs.forEach(tab => {
                const switchTab = () => {
                    verticalTabs.forEach(t => {
                        t.classList.remove('is-active');
                        t.setAttribute('aria-selected', 'false');
                    });
                    tab.classList.add('is-active');
                    tab.setAttribute('aria-selected', 'true');

                    const targetId = tab.dataset.verticalTarget;
                    document.querySelectorAll('.mega-tab-content-panel').forEach(p => p.classList.remove('is-active'));
                    const targetPanel = document.getElementById(targetId);
                    if (targetPanel) targetPanel.classList.add('is-active');

                    // Switch right featured project
                    const slug = targetId.replace('panel-vertical-', '');
                    document.querySelectorAll('.mega-featured-item-panel').forEach(fp => {
                        fp.classList.remove('d-flex');
                        fp.classList.add('d-none');
                    });
                    const targetFeatured = document.getElementById('featured-vertical-' + slug);
                    if (targetFeatured) {
                        targetFeatured.classList.remove('d-none');
                        targetFeatured.classList.add('d-flex');
                    }
                };

                tab.addEventListener('mouseenter', switchTab);
                tab.addEventListener('click', switchTab);
            });

            // 2. Mobile Drawer Accordion
            const mobileBtn = document.getElementById('mobileMenuBtn');
            const mobileClose = document.getElementById('mobileCloseBtn');
            const mobileDrawer = document.getElementById('mobileDrawer');

            mobileBtn?.addEventListener('click', () => {
                mobileDrawer?.classList.add('is-active');
                document.body.style.overflow = 'hidden';
            });

            mobileClose?.addEventListener('click', () => {
                mobileDrawer?.classList.remove('is-active');
                document.body.style.overflow = '';
            });

            // 3. FAQ Accordion Toggle
            const faqItems = document.querySelectorAll('.zeplin-faq-item');
            faqItems.forEach(item => {
                const trigger = item.querySelector('.zeplin-faq-trigger');
                trigger?.addEventListener('click', () => {
                    const isOpen = item.classList.contains('is-open');
                    // Toggle current
                    if (isOpen) {
                        item.classList.remove('is-open');
                        trigger.setAttribute('aria-expanded', 'false');
                    } else {
                        item.classList.add('is-open');
                        trigger.setAttribute('aria-expanded', 'true');
                    }
                });
            });

            // 4. Theme Toggle Logic
            const htmlEl = document.documentElement;
            const themeBtn = document.getElementById('themeToggleBtn');
            const themeIcon = document.getElementById('themeIcon');
            const saved = localStorage.getItem('mahishika_theme') || 'light';
            setTheme(saved);

            themeBtn?.addEventListener('click', () => {
                const cur = htmlEl.getAttribute('data-theme') || 'light';
                const next = cur === 'dark' ? 'light' : 'dark';
                setTheme(next);
            });

            function setTheme(t) {
                htmlEl.setAttribute('data-theme', t);
                htmlEl.setAttribute('data-bs-theme', t);
                localStorage.setItem('mahishika_theme', t);
                if (themeIcon) {
                    themeIcon.className = t === 'dark' ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars';
                }
            }

            // 5. Sticky In-Page Nav Active Indicator on Scroll
            const inPageLinks = document.querySelectorAll('.in-page-nav-link');
            window.addEventListener('scroll', () => {
                const scrollPos = window.scrollY + 120;
                inPageLinks.forEach(link => {
                    const sec = document.querySelector(link.getAttribute('href'));
                    if (sec) {
                        const top = sec.offsetTop;
                        const height = sec.offsetHeight;
                        if (scrollPos >= top && scrollPos < top + height) {
                            inPageLinks.forEach(l => l.classList.remove('active'));
                            link.classList.add('active');
                        }
                    }
                });
            });

            // 6. Smooth Scroll for Navigation Anchors
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href');
                    if (!targetId || targetId === '#' || targetId.startsWith('#consultationModal')) return;
                    const targetEl = document.querySelector(targetId);
                    if (targetEl) {
                        e.preventDefault();
                        const headerOffset = 80;
                        const elementPosition = targetEl.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                        history.pushState(null, null, targetId);
                        // If mobile drawer is open, close it
                        if (mobileDrawer && mobileDrawer.classList.contains('is-active')) {
                            mobileDrawer.classList.remove('is-active');
                            document.body.style.overflow = '';
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
