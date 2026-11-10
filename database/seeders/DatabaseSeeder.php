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
     * Seed the application's database with matching frontend and backend structure.
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

        // Category 1: Services (Parent Capabilities / Test Requirement)
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
                'url' => '#tech-hub',
                'icon' => 'bi-cloud-check',
                'badge' => 'Popular',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Custom Web & Full-Stack Apps',
                'slug' => 'custom-web-fullstack-apps',
                'description' => 'High-performance enterprise web apps built with modern reactive architectures.',
                'url' => '#tech-web-dev',
                'icon' => 'bi-code-slash',
                'badge' => 'Core',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Mobile & Cross-Platform Apps',
                'slug' => 'mobile-cross-platform-apps',
                'description' => 'Fluid iOS, Android, and Flutter experiences with 60fps animations and offline sync.',
                'url' => '#tech-mobile-apps',
                'icon' => 'bi-phone',
                'badge' => null,
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'AI Engineering & Intelligent Agents',
                'slug' => 'ai-engineering-intelligent-agents',
                'description' => 'Custom LLM agents, RAG knowledge retrieval, and predictive analytics pipelines.',
                'url' => '#tech-custom-software',
                'icon' => 'bi-cpu',
                'badge' => 'New',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'title' => 'Product UI/UX & Design Systems',
                'slug' => 'product-design-systems',
                'description' => 'Human-centered user research, accessible Figma systems, and atomic design tokens.',
                'url' => '#design-hub',
                'icon' => 'bi-palette',
                'badge' => null,
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'title' => 'Cybersecurity & DevSecOps',
                'slug' => 'cybersecurity-devsecops',
                'description' => 'Zero-trust security architecture, penetration audits, and SOC2/HIPAA compliance.',
                'url' => '#tech-hosting',
                'icon' => 'bi-shield-check',
                'badge' => 'Enterprise',
                'sort_order' => 6,
                'is_active' => true,
            ],
        ]);

        // Category 2: Tech (Mega Menu Vertical 1)
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

        // Featured Portfolio Case Study 2: CloudScale (Technology & SaaS)
        $tech->portfolioArticles()->create([
            'title' => 'CloudScale: Single revenue source of truth for $12M ARR billing',
            'slug' => 'cloudscale-single-revenue-source-truth',
            'type' => 'case_study',
            'client_name' => 'CloudScale',
            'tag' => 'Technology & SaaS',
            'excerpt' => 'Stripe • BigQuery • Salesforce',
            'content' => 'Decoupled subscription events led to recurring 15% revenue discrepancies.',
            'metric' => '99.99%',
            'metric_label' => 'Data Match • 3.4x deployment speed',
            'image_url' => '/assets/images/portfolio-saas.jpg',
            'link_url' => '#portfolio',
            'is_featured' => true,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // Category 3: Design (Mega Menu Vertical 2)
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

        // Category 4: Video (Mega Menu Vertical 3)
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

        // Category 5: Marketing (Mega Menu Vertical 4)
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

        // Featured Portfolio Case Study 1: Nordic Glow (Retail & E-Commerce)
        $marketing->portfolioArticles()->create([
            'title' => 'Nordic Glow: +42% ROAS through server-side conversion tracking',
            'slug' => 'nordic-glow-roas-server-side-tracking',
            'type' => 'case_study',
            'client_name' => 'Nordic Glow',
            'tag' => 'Retail & E-Commerce',
            'excerpt' => 'Shopify Plus • GA4 • Meta CAPI',
            'content' => 'Browser privacy blocks caused 40% of Shopify conversions to drop from ad platforms.',
            'metric' => '+42%',
            'metric_label' => 'Verified ROAS (0.8s checkout)',
            'image_url' => '/assets/images/portfolio-retail.jpg',
            'link_url' => '#portfolio',
            'is_featured' => true,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Category 6: Industries (Navbar & Landing Section)
        $industries = Category::create([
            'name' => 'Industries',
            'slug' => 'industries',
            'description' => 'Deep domain expertise across regulated and high-velocity sectors.',
            'icon' => 'bi-buildings',
            'badge' => 'Sectors',
            'sort_order' => 6,
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

        // Category 7: About (Navbar & Landing Section)
        $about = Category::create([
            'name' => 'About',
            'slug' => 'about',
            'description' => 'Who we are, what drives us, and our vision for digital craftsmanship.',
            'icon' => 'bi-people',
            'badge' => 'Company',
            'sort_order' => 7,
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

        // Sample Consultations Matching Figma Design
        Consultation::create([
            'name' => 'Elena Rostova',
            'email' => 'elena@vanguardfintech.com',
            'phone' => '+1 (555) 234-5678',
            'company' => 'Vanguard Financial Technologies',
            'service_interest' => 'Not sure yet',
            'help_topics' => ['Tech', 'Marketing'],
            'budget' => '$50,000 - $100,000',
            'timeline' => 'Immediate (Within 1 month)',
            'message' => 'Looking to modernize our transaction processing backend and set up server-side conversion tracking.',
            'status' => 'new',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
        ]);

        Consultation::create([
            'name' => 'Marcus Chen',
            'email' => 'marcus@biopulsehealth.io',
            'phone' => '+1 (555) 876-5432',
            'company' => 'BioPulse Health',
            'service_interest' => 'Not sure yet',
            'help_topics' => ['Design', 'Tech'],
            'budget' => '$100,000+',
            'timeline' => '1-3 months',
            'message' => 'We need an enterprise clinical decision support design system and patient portal architecture.',
            'status' => 'contacted',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7)',
        ]);
    }
}
