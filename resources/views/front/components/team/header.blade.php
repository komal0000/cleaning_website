@php($teamContent = data_get($siteContent, 'pages.team'))
<section class="page-hero team-page-hero">
        <div class="site-container page-hero-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">{{ data_get($teamContent, 'eyebrow') }}</span>
                <h1>{{ data_get($teamContent, 'title') }}</h1>
                <p>{{ data_get($teamContent, 'description') }}</p>
            </div>
            <div class="team-hero-cards reveal-on-scroll" data-reveal-delay="100" aria-hidden="true">
                <span><i data-lucide="users"></i>Human</span>
                <span><i data-lucide="map-pin"></i>Local</span>
                <span><i data-lucide="clipboard-check"></i>Prepared</span>
            </div>
        </div>
    </section>
