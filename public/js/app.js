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
    const postcodeInput = document.getElementById('postcode');
    const spaceInput = document.querySelector(`[name="space_type"][value="${CSS.escape(params.get('space') || '')}"]`);

    if (serviceSelect && params.get('service')) serviceSelect.value = params.get('service');
    if (postcodeInput && params.get('postcode')) postcodeInput.value = params.get('postcode');
    if (spaceInput) spaceInput.checked = true;

    if (params.get('gotoquote') === '1' || params.get('gotoquote') === 'true') {
        window.requestAnimationFrame(() => {
            document.getElementById('quote-flow')?.scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
        });
    }

    initialiseQuoteFlow();

    if (window.lucide) {
        window.lucide.createIcons({ attrs: { 'stroke-width': 1.8 } });
    }
});

function initialiseQuoteFlow() {
    const form = document.querySelector('[data-quote-flow]');
    if (!form) return;

    const steps = Array.from(form.querySelectorAll('[data-quote-step]'));
    const quoteLayout = form.closest('.quote-layout');
    const progressBar = quoteLayout?.querySelector('[data-quote-progress]');
    const progressText = quoteLayout?.querySelector('[data-quote-progress-text]');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let activeStep = 0;

    const showStep = (nextStep, shouldScroll = false) => {
        activeStep = Math.max(0, Math.min(nextStep, steps.length - 1));

        steps.forEach((step, index) => {
            step.hidden = index !== activeStep;
            step.setAttribute('aria-hidden', String(index !== activeStep));
        });

        const percentage = ((activeStep + 1) / steps.length) * 100;
        if (progressBar) progressBar.style.width = `${percentage}%`;
        if (progressText) progressText.textContent = `Step ${activeStep + 1} of ${steps.length}`;

        const firstControl = steps[activeStep].querySelector('input:not([type="hidden"]), select, textarea, button');
        if (firstControl && shouldScroll) firstControl.focus({ preventScroll: true });
        if (shouldScroll) {
            steps[activeStep].scrollIntoView({ behavior: reducedMotion ? 'auto' : 'smooth', block: 'start' });
        }
    };

    const validateStep = () => {
        const requiredControls = Array.from(steps[activeStep].querySelectorAll('input, select, textarea'));
        for (const control of requiredControls) {
            if (!control.checkValidity()) {
                control.reportValidity();
                return false;
            }
        }
        return true;
    };

    form.addEventListener('click', (event) => {
        const next = event.target.closest('[data-quote-next]');
        const back = event.target.closest('[data-quote-back]');

        if (next) {
            event.preventDefault();
            if (validateStep()) showStep(activeStep + 1, true);
        }

        if (back) {
            event.preventDefault();
            showStep(activeStep - 1, true);
        }
    });

    form.addEventListener('submit', (event) => {
        if (!validateStep()) event.preventDefault();
    });

    showStep(0);
}
