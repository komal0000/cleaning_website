@php
    $servicesContent = data_get($siteContent, 'pages.services', []);
    $heroImage = \App\Support\SiteContent::publicUrl(data_get($servicesContent, 'image'));
@endphp
<section class="page-hero services-page-hero">
    <div class="site-container page-hero-grid">
        <div class="reveal-on-scroll">
            <span class="eyebrow">{{ data_get($servicesContent, 'eyebrow') }}</span>
            <h1>{{ data_get($servicesContent, 'title') }}</h1>
            <p>{{ data_get($servicesContent, 'description') }}</p>
            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('contact', ['gotoquote' => 1]) }}">
                    Start my quote
                    <i data-lucide="arrow-right" aria-hidden="true"></i>
                </a>
                <a class="button button-secondary" href="#all-services">Browse the catalogue</a>
            </div>
        </div>
        @if ($heroImage)
            <figure class="service-hero-media reveal-on-scroll" data-reveal-delay="100">
                <img class="service-hero-photo"
                    src="{{ $heroImage }}"
                    alt="{{ data_get($servicesContent, 'image_alt') ?: data_get($servicesContent, 'title') }}"
                    width="1024" height="720">
                <figcaption>Services shaped around real spaces.</figcaption>
            </figure>
        @endif
    </div>
</section>
