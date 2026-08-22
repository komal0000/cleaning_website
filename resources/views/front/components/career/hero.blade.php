    @php($careerContent = data_get($siteContent, 'pages.career'))
    <section class="page-hero careers-page-hero">
        <div class="site-container page-hero-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">{{ data_get($careerContent, 'eyebrow') }}</span>
                <h1>{{ data_get($careerContent, 'title') }}</h1>
                <p>{{ data_get($careerContent, 'description') }}</p>
                <div class="hero-actions"><a class="button button-primary" href="#open-roles">View open roles <i data-lucide="arrow-down"></i></a><a class="button button-secondary" href="#apply">Apply now</a></div>
            </div>
            <div class="career-principles reveal-on-scroll" data-reveal-delay="100">
                <span><i data-lucide="shield-check"></i>Safety-minded</span>
                <span><i data-lucide="users"></i>Team-focused</span>
                <span><i data-lucide="clipboard-check"></i>Clear standards</span>
            </div>
        </div>
    </section>
