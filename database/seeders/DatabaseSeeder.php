<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Consultation;
use App\Models\PortfolioArticle;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 0. Seed Admin Users
        User::firstOrCreate(
            ['email' => 'admin@mahishika.digital'],
            [
                'name' => 'Jeetu Prajapati',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin@mahishika.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );
        // Category 1: Services
        $services = Category::create([
            'name' => 'Services',
            'slug' => 'services',
            'description' => 'End-to-end engineering and design capabilities tailored to enterprise scale.',
            'icon' => 'bi-layers-half',
            'badge' => '6 Capabilities',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $services->subCategories()->createMany([
            [
                'title' => 'Cloud Architecture & DevOps',
                'slug' => 'cloud-architecture-devops',
                'description' => 'Multi-cloud Kubernetes, zero-downtime CI/CD pipelines, and FinOps cost optimization.',
                'url' => '#services-cloud',
                'icon' => 'bi-cloud-check',
                'badge' => 'Popular',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Custom Web & Full-Stack Apps',
                'slug' => 'custom-web-fullstack-apps',
                'description' => 'High-performance enterprise web apps built with modern reactive architectures.',
                'url' => '#services-web',
                'icon' => 'bi-code-slash',
                'badge' => 'Core',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Mobile & Cross-Platform Apps',
                'slug' => 'mobile-cross-platform-apps',
                'description' => 'Fluid iOS, Android, and Flutter experiences with 60fps animations and offline sync.',
                'url' => '#services-mobile',
                'icon' => 'bi-phone',
                'badge' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'AI Engineering & Intelligent Agents',
                'slug' => 'ai-engineering-intelligent-agents',
                'description' => 'Custom LLM agents, RAG knowledge retrieval, and predictive analytics pipelines.',
                'url' => '#services-ai',
                'icon' => 'bi-cpu',
                'badge' => 'New',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Product UI/UX & Design Systems',
                'slug' => 'product-design-systems',
                'description' => 'Human-centered user research, accessible Figma systems, and atomic design tokens.',
                'url' => '#services-design',
                'icon' => 'bi-palette',
                'badge' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Cybersecurity & DevSecOps',
                'slug' => 'cybersecurity-devsecops',
                'description' => 'Zero-trust security architecture, penetration audits, and SOC2/HIPAA compliance.',
                'url' => '#services-security',
                'icon' => 'bi-shield-check',
                'badge' => 'Enterprise',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ]);

        $services->portfolioArticles()->createMany([
            [
                'title' => 'FinTech Scale: 5M+ Daily Transactions with 99.999% SLA',
                'slug' => 'fintech-scale-5m-daily-transactions',
                'type' => 'case_study',
                'client_name' => 'Apex Digital Bank',
                'excerpt' => 'Architected a distributed event-driven microservices core handling $2.8B monthly volume with sub-50ms latency.',
                'tag' => 'FinTech Cloud',
                'metric' => '99.999%',
                'metric_label' => 'Uptime SLA',
                'image_url' => '/assets/images/tech-case.jpg',
                'link_url' => '#work-apex',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Zeplin Mega Menu Vertical 1: Tech (Default Active)
        $tech = Category::create([
            'name' => 'Tech',
            'slug' => 'tech',
            'description' => 'A site, store, or app that works without babysitting.',
            'icon' => 'bi-code-slash',
            'badge' => '6 services',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $tech->subCategories()->createMany([
            [
                'title' => 'Website Development',
                'slug' => 'website-development',
                'description' => 'Fast sites your team can update themselves.',
                'url' => '#tech-web-dev',
                'icon' => 'bi-window',
                'badge' => 'Popular',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'WordPress & E-commerce',
                'slug' => 'wordpress-ecommerce',
                'description' => 'Stores built to sell, on WooCommerce or Shopify.',
                'url' => '#tech-ecommerce',
                'icon' => 'bi-bag',
                'badge' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Web & Custom Software',
                'slug' => 'web-custom-software',
                'description' => 'Portals, dashboards, and tools around your workflow.',
                'url' => '#tech-custom-software',
                'icon' => 'bi-laptop',
                'badge' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Mobile App Development',
                'slug' => 'mobile-app-development',
                'description' => 'iOS and Android apps, built once and maintained.',
                'url' => '#tech-mobile-apps',
                'icon' => 'bi-phone',
                'badge' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Integrations & Automation',
                'slug' => 'integrations-automation',
                'description' => 'Payments, CRMs, and ERPs, connected and tested.',
                'url' => '#tech-integrations',
                'icon' => 'bi-plug',
                'badge' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Hosting & Maintenance',
                'slug' => 'hosting-maintenance',
                'description' => 'Uptime, backups, and security, handled.',
                'url' => '#tech-hosting',
                'icon' => 'bi-shield-check',
                'badge' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ]);

        $tech->portfolioArticles()->createMany([
            [
                'title' => '[Client]: checkout rebuilt and mobile load time cut in half',
                'slug' => 'client-checkout-rebuilt-load-time-cut-in-half',
                'type' => 'case_study',
                'client_name' => 'Scale Retail',
                'excerpt' => 'Re-architected checkout flow and headless infrastructure, cutting mobile load time in half and boosting conversion by 38%.',
                'tag' => 'E-Commerce',
                'metric' => '-50%',
                'metric_label' => 'Load Time',
                'image_url' => '/assets/images/tech-case.jpg',
                'link_url' => '#work-checkout',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Zeplin Mega Menu Vertical 2: Design
        $design = Category::create([
            'name' => 'Design',
            'slug' => 'design',
            'description' => 'Human-centered design systems, UI/UX, and brand identity.',
            'icon' => 'bi-palette',
            'badge' => '6 services',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $design->subCategories()->createMany([
            [
                'title' => 'Brand & Identity',
                'slug' => 'brand-identity',
                'description' => 'Memorable brand logos, typography, and visual guidelines.',
                'url' => '#design-brand',
                'icon' => 'bi-brush',
                'badge' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'UI/UX Product Design',
                'slug' => 'uiux-product-design',
                'description' => 'Frictionless web & mobile app experiences designed for conversion.',
                'url' => '#design-uiux',
                'icon' => 'bi-layout-text-window',
                'badge' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Design Systems',
                'slug' => 'design-systems',
                'description' => 'Scalable Figma component libraries and token architectures.',
                'url' => '#design-systems',
                'icon' => 'bi-grid-1x2',
                'badge' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Wireframing & Prototyping',
                'slug' => 'wireframing-prototyping',
                'description' => 'Interactive click-through prototypes for rapid user validation.',
                'url' => '#design-prototyping',
                'icon' => 'bi-bezier2',
                'badge' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Web Design',
                'slug' => 'web-design',
                'description' => 'Modern, responsive landing pages that captivate visitors.',
                'url' => '#design-web',
                'icon' => 'bi-display',
                'badge' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Product UI Audits',
                'slug' => 'product-ui-audits',
                'description' => 'Accessibility, UX friction, and heuristic evaluations.',
                'url' => '#design-audits',
                'icon' => 'bi-check2-circle',
                'badge' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ]);

        $design->portfolioArticles()->createMany([
            [
                'title' => 'Fintech Core: Design system scaled to 40+ engineering squads',
                'slug' => 'fintech-core-design-system-scale',
                'type' => 'case_study',
                'client_name' => 'Apex Global',
                'excerpt' => 'Unified multi-platform Figma design system with 200+ accessible components cutting frontend build cycles by 45%.',
                'tag' => 'Design Systems',
                'metric' => '45%',
                'metric_label' => 'Faster Dev Cycles',
                'image_url' => '/assets/images/design-case.jpg',
                'link_url' => '#work-design-system',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Zeplin Mega Menu Vertical 3: Video
        $video = Category::create([
            'name' => 'Video',
            'slug' => 'video',
            'description' => 'Engaging brand motion graphics, 3D product renders, and video stories.',
            'icon' => 'bi-play-circle',
            'badge' => '5 services',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $video->subCategories()->createMany([
            [
                'title' => 'Motion Graphics',
                'slug' => 'motion-graphics',
                'description' => 'Dynamic 2D/3D motion graphics that elevate your product story.',
                'url' => '#video-motion',
                'icon' => 'bi-film',
                'badge' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => '3D Product Showcases',
                'slug' => '3d-product-showcases',
                'description' => 'Photorealistic 3D product renders and animated feature tours.',
                'url' => '#video-3d',
                'icon' => 'bi-box',
                'badge' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Explainer Videos',
                'slug' => 'explainer-videos',
                'description' => 'Clear, concise visual walk-throughs that demystify complex software.',
                'url' => '#video-explainer',
                'icon' => 'bi-play-btn',
                'badge' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Brand Storytelling',
                'slug' => 'brand-storytelling',
                'description' => 'Cinematic brand films that resonate with enterprise buyers.',
                'url' => '#video-storytelling',
                'icon' => 'bi-camera-reels',
                'badge' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Social & Performance Video',
                'slug' => 'social-performance-video',
                'description' => 'High-converting vertical video creative for ad campaigns.',
                'url' => '#video-social',
                'icon' => 'bi-phone-landscape',
                'badge' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
        ]);

        $video->portfolioArticles()->createMany([
            [
                'title' => 'AI SaaS Platform: 3D product launch film driving 100k+ views',
                'slug' => 'ai-saas-launch-3d-film',
                'type' => 'case_study',
                'client_name' => 'Cortex AI',
                'excerpt' => 'Produced full 3D interactive launch campaign generating 12,000 signups in first 48 hours.',
                'tag' => '3D Animation',
                'metric' => '12K+',
                'metric_label' => 'Signups in 48h',
                'image_url' => '/assets/images/video-case.jpg',
                'link_url' => '#work-cortex',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Zeplin Mega Menu Vertical 4: Marketing
        $marketing = Category::create([
            'name' => 'Marketing',
            'slug' => 'marketing',
            'description' => 'Analytics, GA4 tracking, conversion optimization, and paid acquisition.',
            'icon' => 'bi-graph-up-arrow',
            'badge' => '6 services',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        $marketing->subCategories()->createMany([
            [
                'title' => 'Analytics & Tracking',
                'slug' => 'analytics-tracking',
                'description' => 'GA4, Tag Manager and conversion tracking set up properly.',
                'url' => '#marketing-analytics',
                'icon' => 'bi-bar-chart',
                'badge' => 'Featured',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Conversion Rate Optimization',
                'slug' => 'conversion-rate-optimization',
                'description' => 'Rigorous A/B testing and checkout funnel enhancements.',
                'url' => '#marketing-cro',
                'icon' => 'bi-bullseye',
                'badge' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Paid Search & Social Ads',
                'slug' => 'paid-search-social-ads',
                'description' => 'High-ROI Google, LinkedIn, and Meta acquisition campaigns.',
                'url' => '#marketing-paid',
                'icon' => 'bi-megaphone',
                'badge' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Search Engine Optimization',
                'slug' => 'search-engine-optimization',
                'description' => 'Technical SEO architectures and authoritative content clusters.',
                'url' => '#marketing-seo',
                'icon' => 'bi-search',
                'badge' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Lifecycle & Email Automation',
                'slug' => 'lifecycle-email-automation',
                'description' => 'Automated retention flows and segmented CRM campaigns.',
                'url' => '#marketing-lifecycle',
                'icon' => 'bi-envelope-paper',
                'badge' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Growth Strategy & Audits',
                'slug' => 'growth-strategy-audits',
                'description' => 'Actionable audit reports uncovering untapped revenue levers.',
                'url' => '#marketing-audits',
                'icon' => 'bi-clipboard-data',
                'badge' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ]);

        $marketing->portfolioArticles()->createMany([
            [
                'title' => 'Vanguard Analytics: Server-side tracking setup delivering 100% data accuracy',
                'slug' => 'vanguard-analytics-tracking-accuracy',
                'type' => 'case_study',
                'client_name' => 'Vanguard Freight',
                'excerpt' => 'Migrated GA4 and CAPI server-side, eliminating data loss and unlocking +24% ad ROAS.',
                'tag' => 'Analytics',
                'metric' => '+24%',
                'metric_label' => 'Ad ROAS Lift',
                'image_url' => '/assets/images/tech-case.jpg',
                'link_url' => '#work-vanguard-analytics',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Category 2: Industries
        $industries = Category::create([
            'name' => 'Industries',
            'slug' => 'industries',
            'description' => 'Deep domain expertise across regulated and high-velocity sectors.',
            'icon' => 'bi-buildings',
            'badge' => 'Sectors',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $industries->subCategories()->createMany([
            [
                'title' => 'Financial Services & FinTech',
                'slug' => 'financial-services-fintech',
                'description' => 'Payment orchestration, algorithmic trading desks, and fraud detection engines.',
                'url' => '#industry-fintech',
                'icon' => 'bi-cash-coin',
                'badge' => 'Regulated',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Healthcare & HealthTech',
                'slug' => 'healthcare-healthtech',
                'description' => 'HIPAA-compliant telemedicine, electronic records, and AI clinical workflows.',
                'url' => '#industry-healthtech',
                'icon' => 'bi-heart-pulse',
                'badge' => 'HIPAA',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'E-Commerce & Omnichannel Retail',
                'slug' => 'ecommerce-omnichannel-retail',
                'description' => 'Headless commerce, high-concurrency checkout pipelines, and predictive search.',
                'url' => '#industry-ecommerce',
                'icon' => 'bi-bag-check',
                'badge' => 'High Scale',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Enterprise SaaS & B2B Platforms',
                'slug' => 'enterprise-saas-b2b',
                'description' => 'Multi-tenant cloud architecture, usage metering, and enterprise SSO/RBAC.',
                'url' => '#industry-saas',
                'icon' => 'bi-diagram-3',
                'badge' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Logistics & Smart Supply Chain',
                'slug' => 'logistics-smart-supply-chain',
                'description' => 'Real-time telematics, dynamic route dispatch, and automated warehouse tracking.',
                'url' => '#industry-logistics',
                'icon' => 'bi-truck',
                'badge' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Media, Entertainment & EdTech',
                'slug' => 'media-entertainment-edtech',
                'description' => 'Sub-second video streaming, interactive LMS platforms, and creator monetization.',
                'url' => '#industry-edtech',
                'icon' => 'bi-play-circle',
                'badge' => null,
                'sort_order' => 6,
                'is_active' => true,
            ],
        ]);

        $industries->portfolioArticles()->createMany([
            [
                'title' => 'HealthPulse: Telehealth Platform Serving 2.4M Patients',
                'slug' => 'healthpulse-telehealth-platform',
                'type' => 'case_study',
                'client_name' => 'HealthPulse Global',
                'excerpt' => 'End-to-end encrypted video consultations, real-time vital telemetry, and automated clinical transcription.',
                'tag' => 'HealthTech',
                'metric' => '2.4M+',
                'metric_label' => 'Active Patients',
                'image_url' => '/assets/images/tech-case.jpg',
                'link_url' => '#work-healthpulse',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Category 3: Work
        $work = Category::create([
            'name' => 'Work',
            'slug' => 'work',
            'description' => 'A curated selection of mission-critical platforms we have designed and engineered.',
            'icon' => 'bi-briefcase',
            'badge' => 'Case Studies',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $work->subCategories()->createMany([
            [
                'title' => 'Enterprise Case Studies',
                'slug' => 'enterprise-case-studies',
                'description' => 'Deep dive into system architectures, performance benchmarks, and measurable ROI.',
                'url' => '#work-cases',
                'icon' => 'bi-journal-code',
                'badge' => 'Featured',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Client Roster & Partnerships',
                'slug' => 'client-roster-partnerships',
                'description' => 'Trusted by market leaders, venture-backed scaleups, and visionary institutions.',
                'url' => '#work-clients',
                'icon' => 'bi-star',
                'badge' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Open Source & Developer Labs',
                'slug' => 'opensource-developer-labs',
                'description' => 'Production libraries, CLI tooling, and web standards our engineers contribute to.',
                'url' => '#work-oss',
                'icon' => 'bi-github',
                'badge' => 'OSS',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Design Systems & Tokens',
                'slug' => 'design-systems-tokens',
                'description' => 'Unified multi-platform design tokens ensuring pixel-accurate brand consistency.',
                'url' => '#work-design-systems',
                'icon' => 'bi-brush',
                'badge' => null,
                'sort_order' => 4,
                'is_active' => true,
            ],
        ]);

        $work->portfolioArticles()->createMany([
            [
                'title' => 'Aura Commerce: +312% Mobile Conversion Lift',
                'slug' => 'aura-commerce-replatforming',
                'type' => 'case_study',
                'client_name' => 'Aura Luxury Retail',
                'excerpt' => 'Migrated legacy monolith to headless Edge-rendered storefront with 0.8s time-to-interactive.',
                'tag' => 'E-Commerce',
                'metric' => '+312%',
                'metric_label' => 'Mobile Conversion',
                'image_url' => '/assets/images/marketing-case.jpg',
                'link_url' => '#work-aura',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Vanguard Logistics: Automated Fleet Dispatch Engine',
                'slug' => 'vanguard-logistics-fleet-dispatch',
                'type' => 'case_study',
                'client_name' => 'Vanguard Freight',
                'excerpt' => 'AI route optimization cutting deadhead mileage by 38% across 14,000 commercial vehicles.',
                'tag' => 'Logistics AI',
                'metric' => '-38%',
                'metric_label' => 'Fuel Consumption',
                'image_url' => '/assets/images/video-case.jpg',
                'link_url' => '#work-vanguard',
                'is_featured' => true,
                'sort_order' => 2,
                'is_active' => true,
            ],
        ]);

        // Category 4: Approach
        $approach = Category::create([
            'name' => 'Approach',
            'slug' => 'approach',
            'description' => 'Our disciplined engineering mindset and battle-tested delivery methodology.',
            'icon' => 'bi-compass',
            'badge' => 'Process',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $approach->subCategories()->createMany([
            [
                'title' => 'Architecture-First Engineering',
                'slug' => 'architecture-first-engineering',
                'description' => 'Modularity, clean domain boundaries, and zero-compromise scalability from day one.',
                'url' => '#approach-architecture',
                'icon' => 'bi-diagram-2',
                'badge' => 'Philosophy',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Agile 2-Week Sprint Cadence',
                'slug' => 'agile-sprint-cadence',
                'description' => 'Rapid iterative shipping, automated test gates, and continuous business alignment.',
                'url' => '#approach-agile',
                'icon' => 'bi-stopwatch',
                'badge' => null,
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Human-Centered UX & Usability',
                'slug' => 'human-centered-ux',
                'description' => 'Rigorous user research, accessibility testing (WCAG 2.1 AA), and interactive prototypes.',
                'url' => '#approach-ux',
                'icon' => 'bi-eye',
                'badge' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Observability & SRE Reliability',
                'slug' => 'observability-sre-reliability',
                'description' => 'End-to-end tracing, automated canary rollouts, and 24/7 incident response SLAs.',
                'url' => '#approach-sre',
                'icon' => 'bi-speedometer2',
                'badge' => '99.99%',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ]);

        $approach->portfolioArticles()->createMany([
            [
                'title' => 'How We Ship Production Code in Week 2: The Mahishika Playbook',
                'slug' => 'how-we-ship-production-code-week-2',
                'type' => 'article',
                'client_name' => 'Engineering Handbook',
                'excerpt' => 'Our opinionated scaffolding, trunk-based development, and ephemeral preview environments.',
                'tag' => 'Methodology',
                'metric' => '14 Days',
                'metric_label' => 'First Production Deploy',
                'image_url' => '/assets/images/portfolio-saas.jpg',
                'link_url' => '#article-playbook',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Category 5: About
        $about = Category::create([
            'name' => 'About',
            'slug' => 'about',
            'description' => 'Who we are, what drives us, and our vision for digital craftsmanship.',
            'icon' => 'bi-people',
            'badge' => 'Company',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        $about->subCategories()->createMany([
            [
                'title' => 'Our Story & Purpose',
                'slug' => 'our-story-purpose',
                'description' => 'Engineers and designers building durable digital products for the next generation.',
                'url' => '#about-story',
                'icon' => 'bi-book',
                'badge' => null,
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Global Team & Leadership',
                'slug' => 'global-team-leadership',
                'description' => 'Senior technologists, system architects, and design leaders working as one unit.',
                'url' => '#about-team',
                'icon' => 'bi-person-badge',
                'badge' => '12 Countries',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Careers & Open Roles',
                'slug' => 'careers-open-roles',
                'description' => 'We are hiring principal engineers, senior product designers, and solution architects.',
                'url' => '#about-careers',
                'icon' => 'bi-lightning-charge',
                'badge' => 'We\'re Hiring',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Recognition, Press & Awards',
                'slug' => 'recognition-press-awards',
                'description' => 'Webby Awards honoree, Awwwards Site of the Day, and Red Dot Design winner.',
                'url' => '#about-awards',
                'icon' => 'bi-trophy',
                'badge' => 'Awwwards',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ]);

        $about->portfolioArticles()->createMany([
            [
                'title' => 'Life at Mahishika: Why Senior Engineers Choose Craft Over Bureaucracy',
                'slug' => 'life-at-mahishika-culture',
                'type' => 'article',
                'client_name' => 'Culture Spotlight',
                'excerpt' => 'Flat hierarchy, zero meetings on Thursdays, and a quarterly \$5k innovation allowance.',
                'tag' => 'Culture',
                'metric' => '4.9 / 5',
                'metric_label' => 'Glassdoor Rating',
                'image_url' => '/assets/images/portfolio-retail.jpg',
                'link_url' => '#article-culture',
                'is_featured' => true,
                'sort_order' => 1,
                'is_active' => true,
            ],
        ]);

        // Sample initial consultations for admin demonstration
        Consultation::create([
            'name' => 'Elena Rostova',
            'email' => 'elena@vanguardfintech.com',
            'phone' => '+1 (555) 234-5678',
            'company' => 'Vanguard Financial Technologies',
            'service_interest' => 'Cloud Architecture & DevOps',
            'budget' => '$50,000 - $100,000',
            'timeline' => 'Immediate (Within 1 month)',
            'message' => 'Looking to modernize our transaction processing backend to handle 10x peak trading volume before Q3.',
            'status' => 'new',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ]);

        Consultation::create([
            'name' => 'Marcus Chen',
            'email' => 'marcus@biopulsehealth.io',
            'phone' => '+1 (555) 876-5432',
            'company' => 'BioPulse Health',
            'service_interest' => 'AI Engineering & Intelligent Agents',
            'budget' => '$100,000+',
            'timeline' => '1-3 months',
            'message' => 'We need an enterprise HIPAA-compliant clinical decision support agent with custom RAG over our medical records.',
            'status' => 'contacted',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
        ]);
    }
}
