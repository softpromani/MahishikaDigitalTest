import { MegaMenu } from '../resources/js/mega-menu.js';

export default {
  title: 'Components/MegaMenu',
  tags: ['autodocs'],
  parameters: {
    layout: 'fullscreen',
  },
  argTypes: {
    theme: {
      control: 'select',
      options: ['light', 'dark'],
      description: 'Color theme of the menu',
    },
    activeCategory: {
      control: 'select',
      options: ['none', 'services', 'industries', 'work', 'approach', 'about'],
      description: 'Which mega-menu panel is expanded by default',
    },
  },
};

const sampleTemplate = (args) => {
  const container = document.createElement('div');
  container.setAttribute('data-theme', args.theme || 'light');
  container.setAttribute('data-bs-theme', args.theme || 'light');
  container.style.minHeight = '600px';
  container.style.background = args.theme === 'dark' ? '#060911' : '#f8fafc';
  container.style.color = args.theme === 'dark' ? '#f8fafc' : '#0f172a';

  container.innerHTML = `
    <header class="site-header" id="siteHeaderStory">
        <div class="header-container">
            <a href="#" class="brand-logo">
                <span class="brand-logo__mark"><i class="bi bi-cpu-fill fs-5"></i></span>
                <div>
                    <span class="brand-logo__name">Mahishika</span>
                    <span class="brand-logo__tag">Digital Agency</span>
                </div>
            </a>

            <nav class="desktop-nav" aria-label="Story Navigation">
                <ul class="mega-menu-list" role="menubar">
                    <li class="mega-menu-item">
                        <button type="button" class="mega-menu-trigger" aria-haspopup="true" aria-expanded="${args.activeCategory === 'services'}" aria-controls="panel-services-story">
                            <span>Services</span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                        <div class="mega-menu-panel ${args.activeCategory === 'services' ? 'is-open' : ''}" id="panel-services-story">
                            <div class="mega-menu-grid">
                                <div class="mega-column--overview">
                                    <div>
                                        <div class="mega-overview-badge"><i class="bi bi-layers-half"></i> 6 Capabilities</div>
                                        <h3 class="mega-overview-title">Services</h3>
                                        <p class="mega-overview-desc">End-to-end engineering and design capabilities tailored to enterprise scale.</p>
                                    </div>
                                    <a href="#" class="mega-overview-link">View all services &rarr;</a>
                                </div>
                                <div class="mega-column--links">
                                    <a href="#" class="mega-sublink">
                                        <div class="mega-sublink__icon"><i class="bi bi-cloud-check"></i></div>
                                        <div class="mega-sublink__content">
                                            <div class="mega-sublink__header">
                                                <span class="mega-sublink__title">Cloud Architecture & DevOps</span>
                                                <span class="mega-sublink__badge">Popular</span>
                                            </div>
                                            <p class="mega-sublink__desc">Multi-cloud Kubernetes, zero-downtime CI/CD pipelines.</p>
                                        </div>
                                    </a>
                                    <a href="#" class="mega-sublink">
                                        <div class="mega-sublink__icon"><i class="bi bi-code-slash"></i></div>
                                        <div class="mega-sublink__content">
                                            <div class="mega-sublink__header">
                                                <span class="mega-sublink__title">Custom Web & Full-Stack Apps</span>
                                                <span class="mega-sublink__badge">Core</span>
                                            </div>
                                            <p class="mega-sublink__desc">High-performance enterprise web apps with reactive architecture.</p>
                                        </div>
                                    </a>
                                    <a href="#" class="mega-sublink">
                                        <div class="mega-sublink__icon"><i class="bi bi-cpu"></i></div>
                                        <div class="mega-sublink__content">
                                            <div class="mega-sublink__header">
                                                <span class="mega-sublink__title">AI Engineering & Intelligent Agents</span>
                                                <span class="mega-sublink__badge mega-sublink__badge--new">New</span>
                                            </div>
                                            <p class="mega-sublink__desc">Custom LLM agents, RAG knowledge retrieval, and predictive pipelines.</p>
                                        </div>
                                    </a>
                                    <a href="#" class="mega-sublink">
                                        <div class="mega-sublink__icon"><i class="bi bi-shield-check"></i></div>
                                        <div class="mega-sublink__content">
                                            <div class="mega-sublink__header">
                                                <span class="mega-sublink__title">Cybersecurity & DevSecOps</span>
                                                <span class="mega-sublink__badge mega-sublink__badge--enterprise">Enterprise</span>
                                            </div>
                                            <p class="mega-sublink__desc">Zero-trust security architecture, penetration audits, and SOC2/HIPAA.</p>
                                        </div>
                                    </a>
                                </div>
                                <div class="mega-column--featured">
                                    <div class="featured-card">
                                        <div class="featured-card__media">
                                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=700&q=80" alt="FinTech Scale" class="featured-card__img">
                                            <span class="featured-card__tag">FinTech Cloud</span>
                                        </div>
                                        <div class="featured-card__body">
                                            <div class="featured-card__metric-box">
                                                <span class="featured-card__metric">99.999%</span>
                                                <span class="featured-card__metric-label">Uptime SLA</span>
                                            </div>
                                            <h4 class="featured-card__title">FinTech Scale: 5M+ Daily Transactions</h4>
                                            <p class="featured-card__excerpt">Architected distributed event-driven microservices core handling $2.8B monthly volume.</p>
                                            <span class="featured-card__cta">Explore Case Study &rarr;</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="mega-menu-item">
                        <button type="button" class="mega-menu-trigger">
                            <span>Industries</span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                    </li>
                    <li class="mega-menu-item">
                        <button type="button" class="mega-menu-trigger">
                            <span>Work</span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                    </li>
                    <li class="mega-menu-item">
                        <button type="button" class="mega-menu-trigger">
                            <span>Approach</span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                    </li>
                    <li class="mega-menu-item">
                        <button type="button" class="mega-menu-trigger">
                            <span>About</span>
                            <i class="bi bi-chevron-down chevron-icon"></i>
                        </button>
                    </li>
                </ul>
            </nav>

            <div class="header-actions">
                <button type="button" class="action-btn" aria-label="Search"><i class="bi bi-search"></i></button>
                <button type="button" class="action-btn" aria-label="Toggle theme"><i class="bi ${args.theme === 'dark' ? 'bi-sun-fill text-warning' : 'bi-moon-stars'}"></i></button>
                <button type="button" class="btn-cta-consultation">
                    <i class="bi bi-calendar2-check-fill"></i>
                    <span>Book a Consultation</span>
                </button>
            </div>
        </div>
    </header>
    <div style="padding: 3rem 2rem; max-width: 1200px; margin: 0 auto;">
        <h2 style="font-weight: 800; font-size: 2rem;">Services Landing Page Preview</h2>
        <p style="color: ${args.theme === 'dark' ? '#94a3b8' : '#64748b'};">This story demonstrates the accessible mega menu component, responsive layout tokens, and interactive micro-interactions.</p>
    </div>
  `;

  // Attach real event handlers
  setTimeout(() => {
    new MegaMenu({
      navSelector: container.querySelector('#siteHeaderStory'),
    });
  }, 0);

  return container;
};

export const DefaultClosed = sampleTemplate.bind({});
DefaultClosed.args = {
  theme: 'light',
  activeCategory: 'none',
};

export const ServicesExpanded = sampleTemplate.bind({});
ServicesExpanded.args = {
  theme: 'light',
  activeCategory: 'services',
};

export const DarkModeVariant = sampleTemplate.bind({});
DarkModeVariant.args = {
  theme: 'dark',
  activeCategory: 'services',
};

