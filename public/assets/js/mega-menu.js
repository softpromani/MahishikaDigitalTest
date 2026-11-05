/**
 * Mahishika Digital - Mega Menu Component
 * Custom vanilla JS implementation with WCAG 2.1 AA keyboard navigation,
 * focus trapping, intent debouncing, search, dark mode, and GTM dataLayer hooks.
 */

export class MegaMenu {
    constructor(options = {}) {
        this.nav = document.querySelector(options.navSelector || '#siteHeader');
        if (!this.nav) return;

        this.items = Array.from(this.nav.querySelectorAll('.mega-menu-item'));
        this.triggers = Array.from(this.nav.querySelectorAll('.mega-menu-trigger'));
        this.panels = Array.from(this.nav.querySelectorAll('.mega-menu-panel'));

        // Mobile drawer elements
        this.hamburgerBtn = document.querySelector(options.hamburgerSelector || '#hamburgerBtn');
        this.mobileDrawer = document.querySelector(options.drawerSelector || '#mobileDrawer');
        this.mobileBackdrop = document.querySelector(options.backdropSelector || '#mobileBackdrop');
        this.mobileCloseBtn = document.querySelector(options.mobileCloseSelector || '#mobileCloseBtn');
        this.mobileAccordionTriggers = Array.from(document.querySelectorAll('.mobile-menu-trigger'));

        // Search elements
        this.searchTrigger = document.querySelector(options.searchTriggerSelector || '#searchToggleBtn');
        this.searchOverlay = document.querySelector(options.searchOverlaySelector || '#searchOverlay');
        this.searchInput = document.querySelector(options.searchInputSelector || '#megaSearchInput');
        this.searchCloseBtn = document.querySelector(options.searchCloseSelector || '#searchCloseBtn');
        this.searchResults = document.querySelector(options.searchResultsSelector || '#searchResultsList');

        // Theme elements
        this.themeToggleBtn = document.querySelector(options.themeToggleSelector || '#themeToggleBtn');
        this.themeIcon = document.querySelector(options.themeIconSelector || '#themeIcon');

        // State
        this.currentOpenItem = null;
        this.hoverTimeout = null;
        this.searchDebounceTimer = null;
        this.focusableSelectors = 'a[href], button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])';

        this.init();
    }

    init() {
        this.initDesktopMenu();
        this.initMobileDrawer();
        this.initSearch();
        this.initTheme();
        this.initScrollSpy();
        this.initGTMTracking();
    }

    // =========================================================================
    // Desktop Mega Menu Logic (Accessible Keyboard + Hover Intent)
    // =========================================================================

    initDesktopMenu() {
        this.triggers.forEach((trigger, index) => {
            const item = trigger.closest('.mega-menu-item');
            const panel = item?.querySelector('.mega-menu-panel');

            // Click trigger to toggle
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
                if (isExpanded) {
                    this.closeItem(item);
                } else {
                    this.openItem(item, true);
                }
            });

            // Hover with intent delay
            if (item) {
                item.addEventListener('mouseenter', () => {
                    clearTimeout(this.hoverTimeout);
                    this.hoverTimeout = setTimeout(() => {
                        this.openItem(item, false);
                    }, 120);
                });

                item.addEventListener('mouseleave', () => {
                    clearTimeout(this.hoverTimeout);
                    this.hoverTimeout = setTimeout(() => {
                        this.closeItem(item);
                    }, 180);
                });
            }

            // Keyboard navigation on top-level triggers
            trigger.addEventListener('keydown', (e) => {
                switch (e.key) {
                    case 'ArrowRight':
                        e.preventDefault();
                        const nextTrigger = this.triggers[(index + 1) % this.triggers.length];
                        nextTrigger?.focus();
                        break;

                    case 'ArrowLeft':
                        e.preventDefault();
                        const prevTrigger = this.triggers[(index - 1 + this.triggers.length) % this.triggers.length];
                        prevTrigger?.focus();
                        break;

                    case 'ArrowDown':
                        e.preventDefault();
                        this.openItem(item, true);
                        if (panel) {
                            const firstLink = panel.querySelector(this.focusableSelectors);
                            firstLink?.focus();
                        }
                        break;

                    case 'Escape':
                        e.preventDefault();
                        this.closeItem(item);
                        trigger.focus();
                        break;
                }
            });

            // Inside panel keyboard navigation & focus-out detection
            if (panel) {
                panel.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        e.preventDefault();
                        this.closeItem(item);
                        trigger.focus();
                    }
                });

                // Listen for Tab out of panel
                panel.addEventListener('focusout', (e) => {
                    setTimeout(() => {
                        if (!panel.contains(document.activeElement) && !trigger.contains(document.activeElement)) {
                            this.closeItem(item);
                        }
                    }, 20);
                });
            }
        });

        // Click outside closes any open mega menu
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.mega-menu-item') && !e.target.closest('.search-overlay')) {
                this.closeAll();
            }
        });
    }

    openItem(item, shouldPushEvent = true) {
        if (!item) return;
        const trigger = item.querySelector('.mega-menu-trigger');
        const panel = item.querySelector('.mega-menu-panel');
        if (!panel || !trigger) return;

        // Close other open items
        if (this.currentOpenItem && this.currentOpenItem !== item) {
            this.closeItem(this.currentOpenItem);
        }

        trigger.setAttribute('aria-expanded', 'true');
        panel.classList.add('is-open');
        panel.setAttribute('aria-hidden', 'false');
        this.currentOpenItem = item;

        // Analytics Hook
        if (shouldPushEvent) {
            this.pushDataLayer({
                event: 'mega_menu_open',
                menu_category: trigger.textContent.trim(),
            });
        }
    }

    closeItem(item) {
        if (!item) return;
        const trigger = item.querySelector('.mega-menu-trigger');
        const panel = item.querySelector('.mega-menu-panel');
        if (!panel || !trigger) return;

        trigger.setAttribute('aria-expanded', 'false');
        panel.classList.remove('is-open');
        panel.setAttribute('aria-hidden', 'true');

        if (this.currentOpenItem === item) {
            this.currentOpenItem = null;
        }
    }

    closeAll() {
        this.items.forEach(item => this.closeItem(item));
    }

    // =========================================================================
    // Mobile Drawer Navigation (Slide-in, Accordion, Focus Trap)
    // =========================================================================

    initMobileDrawer() {
        if (!this.hamburgerBtn || !this.mobileDrawer) return;

        // Synchronize initial expanded state
        if (this.mobileDrawer.classList.contains('is-active')) {
            this.hamburgerBtn.setAttribute('aria-expanded', 'true');
        }

        this.hamburgerBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            const isOpen = this.hamburgerBtn.getAttribute('aria-expanded') === 'true';
            if (isOpen) {
                this.closeMobileDrawer();
            } else {
                this.openMobileDrawer();
            }
        });

        this.mobileCloseBtn?.addEventListener('click', (e) => {
            e.stopPropagation();
            this.closeMobileDrawer();
        });
        this.mobileBackdrop?.addEventListener('click', (e) => {
            e.stopPropagation();
            this.closeMobileDrawer();
        });

        // Accordion sublevels
        this.mobileAccordionTriggers.forEach((accordionTrigger) => {
            accordionTrigger.addEventListener('click', () => {
                const targetId = accordionTrigger.getAttribute('aria-controls');
                const targetSubmenu = document.getElementById(targetId);
                const isExpanded = accordionTrigger.getAttribute('aria-expanded') === 'true';

                // Close other open accordions
                this.mobileAccordionTriggers.forEach(otherTrigger => {
                    if (otherTrigger !== accordionTrigger) {
                        otherTrigger.setAttribute('aria-expanded', 'false');
                        const otherId = otherTrigger.getAttribute('aria-controls');
                        document.getElementById(otherId)?.classList.remove('is-open');
                    }
                });

                if (isExpanded) {
                    accordionTrigger.setAttribute('aria-expanded', 'false');
                    targetSubmenu?.classList.remove('is-open');
                } else {
                    accordionTrigger.setAttribute('aria-expanded', 'true');
                    targetSubmenu?.classList.add('is-open');
                }
            });
        });

        // Close drawer on link click
        this.mobileDrawer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                this.closeMobileDrawer();
            });
        });

        // Trap focus & Escape key inside mobile drawer
        document.addEventListener('keydown', (e) => {
            if (this.mobileDrawer.classList.contains('is-active')) {
                if (e.key === 'Escape') {
                    e.preventDefault();
                    this.closeMobileDrawer();
                } else if (e.key === 'Tab') {
                    this.trapFocus(e, this.mobileDrawer);
                }
            }
        });
    }

    openMobileDrawer() {
        this.hamburgerBtn.setAttribute('aria-expanded', 'true');
        this.mobileDrawer.classList.add('is-active');
        this.mobileBackdrop?.classList.add('is-active');
        document.body.style.overflow = 'hidden';

        // Focus first link or close button inside drawer
        const focusTarget = this.mobileDrawer.querySelector(this.focusableSelectors);
        focusTarget?.focus();

        this.pushDataLayer({ event: 'mobile_menu_open' });
    }

    closeMobileDrawer() {
        this.hamburgerBtn.setAttribute('aria-expanded', 'false');
        this.mobileDrawer.classList.remove('is-active');
        this.mobileBackdrop?.classList.remove('is-active');
        document.body.style.overflow = '';
        this.hamburgerBtn.focus();
    }

    trapFocus(e, container) {
        const focusableElements = container.querySelectorAll(this.focusableSelectors);
        if (focusableElements.length === 0) return;

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        if (e.shiftKey && document.activeElement === firstElement) {
            e.preventDefault();
            lastElement.focus();
        } else if (!e.shiftKey && document.activeElement === lastElement) {
            e.preventDefault();
            firstElement.focus();
        }
    }

    // =========================================================================
    // Mega Menu Search (Client-Side & Server API with Keyboard Selection)
    // =========================================================================

    initSearch() {
        if (!this.searchTrigger || !this.searchOverlay) return;

        this.searchTrigger.addEventListener('click', (e) => {
            e.preventDefault();
            this.toggleSearch();
        });

        this.searchCloseBtn?.addEventListener('click', () => {
            this.closeSearch();
        });

        this.searchInput?.addEventListener('input', (e) => {
            const query = e.target.value.trim();
            clearTimeout(this.searchDebounceTimer);
            this.searchDebounceTimer = setTimeout(() => {
                this.performSearch(query);
            }, 200);
        });

        this.searchInput?.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeSearch();
            } else if (e.key === 'ArrowDown') {
                e.preventDefault();
                const firstResult = this.searchResults?.querySelector('.search-result-item');
                firstResult?.focus();
            }
        });

        this.searchResults?.addEventListener('keydown', (e) => {
            const items = Array.from(this.searchResults.querySelectorAll('.search-result-item'));
            const currentIndex = items.indexOf(document.activeElement);

            if (e.key === 'ArrowDown') {
                e.preventDefault();
                const nextIndex = (currentIndex + 1) % items.length;
                items[nextIndex]?.focus();
            } else if (e.key === 'ArrowUp') {
                e.preventDefault();
                if (currentIndex === 0) {
                    this.searchInput?.focus();
                } else {
                    const prevIndex = (currentIndex - 1 + items.length) % items.length;
                    items[prevIndex]?.focus();
                }
            } else if (e.key === 'Escape') {
                this.closeSearch();
            }
        });
    }

    toggleSearch() {
        const isActive = this.searchOverlay.classList.contains('is-active');
        if (isActive) {
            this.closeSearch();
        } else {
            this.openSearch();
        }
    }

    openSearch() {
        this.closeAll();
        this.searchOverlay.classList.add('is-active');
        this.searchTrigger.setAttribute('aria-expanded', 'true');
        setTimeout(() => this.searchInput?.focus(), 100);

        this.pushDataLayer({ event: 'menu_search_open' });
    }

    closeSearch() {
        this.searchOverlay.classList.remove('is-active');
        this.searchTrigger.setAttribute('aria-expanded', 'false');
        if (this.searchInput) this.searchInput.value = '';
        if (this.searchResults) {
            this.searchResults.innerHTML = '';
            this.searchResults.classList.remove('has-results');
        }
        this.searchTrigger.focus();
    }

    async performSearch(query) {
        if (!this.searchResults) return;

        if (query.length < 2) {
            this.searchResults.innerHTML = '';
            this.searchResults.classList.remove('has-results');
            return;
        }

        // Try API search first; fallback to client-side DOM filter
        try {
            const res = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
            if (res.ok) {
                const data = await res.json();
                this.renderSearchResults(data, query);
                return;
            }
        } catch (err) {
            // Server offline or static deployment fallback
        }

        this.performClientSearch(query);
    }

    performClientSearch(query) {
        const q = query.toLowerCase();
        const results = [];

        // Scan all mega menu sublinks
        document.querySelectorAll('.mega-sublink, .featured-card').forEach(link => {
            const title = link.querySelector('.mega-sublink__title, .featured-card__title')?.textContent || '';
            const desc = link.querySelector('.mega-sublink__desc, .featured-card__excerpt')?.textContent || '';
            if (title.toLowerCase().includes(q) || desc.toLowerCase().includes(q)) {
                results.push({
                    title,
                    desc,
                    url: link.getAttribute('href') || '#',
                    tag: link.classList.contains('featured-card') ? 'Case Study' : 'Service',
                });
            }
        });

        this.renderClientResults(results, query);
    }

    renderSearchResults(data, query) {
        const { categories = [], sub_categories = [], articles = [] } = data.results || {};
        const total = (data.total || 0);

        if (total === 0) {
            this.searchResults.innerHTML = `
                <div class="p-3 text-center text-muted small">
                    <i class="bi bi-search me-1"></i> No matching services, industries, or case studies found for "<strong>${this.escapeHtml(query)}</strong>".
                </div>
            `;
            this.searchResults.classList.add('has-results');
            return;
        }

        let html = '';

        sub_categories.forEach(sub => {
            html += `
                <a href="${this.escapeHtml(sub.url)}" class="search-result-item">
                    <div class="search-result-item__main">
                        <i class="bi ${this.escapeHtml(sub.icon || 'bi-link-45deg')} search-result-item__icon"></i>
                        <div>
                            <div class="search-result-item__title">${this.highlightMatch(sub.title, query)}</div>
                            <div class="search-result-item__desc">${this.escapeHtml(sub.description || '')}</div>
                        </div>
                    </div>
                    <span class="search-result-item__tag">${this.escapeHtml(sub.category?.name || 'Service')}</span>
                </a>
            `;
        });

        articles.forEach(art => {
            html += `
                <a href="${this.escapeHtml(art.link_url)}" class="search-result-item">
                    <div class="search-result-item__main">
                        <i class="bi bi-briefcase search-result-item__icon text-info"></i>
                        <div>
                            <div class="search-result-item__title">${this.highlightMatch(art.title, query)}</div>
                            <div class="search-result-item__desc">${this.escapeHtml(art.excerpt || '')}</div>
                        </div>
                    </div>
                    <span class="search-result-item__tag bg-primary-subtle text-primary">${this.escapeHtml(art.metric || 'Case Study')}</span>
                </a>
            `;
        });

        this.searchResults.innerHTML = html;
        this.searchResults.classList.add('has-results');

        this.pushDataLayer({
            event: 'search_query',
            search_term: query,
            result_count: total,
        });
    }

    renderClientResults(results, query) {
        if (results.length === 0) {
            this.searchResults.innerHTML = `
                <div class="p-3 text-center text-muted small">
                    <i class="bi bi-search me-1"></i> No matches found for "<strong>${this.escapeHtml(query)}</strong>".
                </div>
            `;
            this.searchResults.classList.add('has-results');
            return;
        }

        const html = results.map(r => `
            <a href="${this.escapeHtml(r.url)}" class="search-result-item">
                <div class="search-result-item__main">
                    <i class="bi bi-check2-circle search-result-item__icon"></i>
                    <div>
                        <div class="search-result-item__title">${this.highlightMatch(r.title, query)}</div>
                        <div class="search-result-item__desc">${this.escapeHtml(r.desc)}</div>
                    </div>
                </div>
                <span class="search-result-item__tag">${this.escapeHtml(r.tag)}</span>
            </a>
        `).join('');

        this.searchResults.innerHTML = html;
        this.searchResults.classList.add('has-results');
    }

    highlightMatch(text, query) {
        if (!query) return this.escapeHtml(text);
        const regex = new RegExp(`(${this.escapeRegExp(query)})`, 'gi');
        return this.escapeHtml(text).replace(regex, '<mark class="bg-warning-subtle text-dark fw-bold">$1</mark>');
    }

    escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    escapeRegExp(str) {
        return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    // =========================================================================
    // Dark / Light Mode Toggle
    // =========================================================================

    initTheme() {
        const root = document.documentElement;
        const saved = localStorage.getItem('mahishika_theme') || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

        this.setTheme(saved, false);

        this.themeToggleBtn?.addEventListener('click', () => {
            const current = root.getAttribute('data-theme') || 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            this.setTheme(next, true);
        });

        // Listen for OS system theme changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('mahishika_theme')) {
                this.setTheme(e.matches ? 'dark' : 'light', false);
            }
        });
    }

    setTheme(theme, userInitiated = true) {
        const root = document.documentElement;
        root.setAttribute('data-theme', theme);
        root.setAttribute('data-bs-theme', theme);
        localStorage.setItem('mahishika_theme', theme);

        if (this.themeIcon) {
            this.themeIcon.className = theme === 'dark' ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars';
        }

        if (this.themeToggleBtn) {
            this.themeToggleBtn.setAttribute('aria-pressed', theme === 'dark');
            this.themeToggleBtn.setAttribute('aria-label', `Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`);
        }

        if (userInitiated) {
            this.pushDataLayer({
                event: 'theme_toggle',
                theme: theme,
            });
        }
    }

    // =========================================================================
    // Header Scrollspy & Shadow
    // =========================================================================

    initScrollSpy() {
        const handleScroll = () => {
            if (window.scrollY > 20) {
                this.nav.classList.add('is-scrolled');
            } else {
                this.nav.classList.remove('is-scrolled');
            }
        };

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll();
    }

    // =========================================================================
    // Analytics Hooks (Google Tag Manager dataLayer)
    // =========================================================================

    initGTMTracking() {
        window.dataLayer = window.dataLayer || [];

        // Track sublink clicks
        document.querySelectorAll('.mega-sublink, .featured-card, .mobile-sublink').forEach(link => {
            link.addEventListener('click', (e) => {
                const title = link.querySelector('.mega-sublink__title, .featured-card__title')?.textContent || link.textContent.trim();
                const url = link.getAttribute('href');
                const category = link.closest('.mega-menu-item')?.querySelector('.mega-menu-trigger')?.textContent.trim() || 'General';

                this.pushDataLayer({
                    event: 'mega_menu_click',
                    item_title: title,
                    item_url: url,
                    category: category,
                });
            });
        });
    }

    pushDataLayer(payload) {
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            timestamp: new Date().toISOString(),
            ...payload,
        });
    }
}
