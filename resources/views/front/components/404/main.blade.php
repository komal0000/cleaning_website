    @php($notFoundContent = data_get($siteContent, 'pages.404'))
    <section class="not-found-page">
        <div class="site-container not-found-grid">
            <div class="reveal-on-scroll"><span class="eyebrow">404 / Page not found</span><h1>{{ data_get($notFoundContent, 'title') }}</h1><p>{{ data_get($notFoundContent, 'description') }}</p><div class="hero-actions"><a class="button button-primary" href="{{ route('home') }}">Return home <i data-lucide="arrow-right"></i></a><a class="button button-secondary" href="{{ route('services') }}">Explore services</a></div></div>
            <div class="not-found-mark reveal-on-scroll" data-reveal-delay="100" aria-hidden="true">404</div>
        </div>
    </section>
