document.addEventListener('DOMContentLoaded', () => {
    const menuButton = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const siteHeader = document.querySelector('[data-site-header]');

    const closeMenu = () => {
        if (!menuButton || !mobileMenu) return;
        menuButton.setAttribute('aria-expanded', 'false');
        menuButton.setAttribute('aria-label', 'Open navigation menu');
        mobileMenu.hidden = true;
        document.body.classList.remove('menu-open');
    };

    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', () => {
            const willOpen = menuButton.getAttribute('aria-expanded') !== 'true';
            menuButton.setAttribute('aria-expanded', String(willOpen));
            menuButton.setAttribute('aria-label', willOpen ? 'Close navigation menu' : 'Open navigation menu');
            mobileMenu.hidden = !willOpen;
            document.body.classList.toggle('menu-open', willOpen);
        });

        mobileMenu.querySelectorAll('a').forEach((link) => link.addEventListener('click', closeMenu));

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeMenu();
                menuButton.focus();
            }
        });

        document.addEventListener('click', (event) => {
            if (!mobileMenu.hidden && !mobileMenu.contains(event.target) && !menuButton.contains(event.target)) {
                closeMenu();
            }
        });
    }

    if (siteHeader) {
        const syncHeader = () => siteHeader.classList.toggle('is-scrolled', window.scrollY > 12);
        syncHeader();
        window.addEventListener('scroll', syncHeader, { passive: true });
    }

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const revealItems = document.querySelectorAll('.reveal-on-scroll');

    revealItems.forEach((item) => {
        const delay = Number(item.dataset.revealDelay || 0);
        item.style.setProperty('--reveal-delay', `${delay}ms`);
    });

    if (reducedMotion || !('IntersectionObserver' in window)) {
        revealItems.forEach((item) => item.classList.add('is-visible'));
    } else {
        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px' });

        revealItems.forEach((item) => revealObserver.observe(item));
    }

    const params = new URLSearchParams(window.location.search);
    const serviceSelect = document.getElementById('service');

    if (serviceSelect && params.get('service') && !serviceSelect.value) {
        serviceSelect.value = params.get('service');
    }

    if (params.get('gotoquote') === '1' || params.get('gotoquote') === 'true') {
        window.requestAnimationFrame(() => {
            document.getElementById('quote-flow')?.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
        });
    }

    if (window.lucide) {
        window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
    }
});
