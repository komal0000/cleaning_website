    <section class="page-hero about-page-hero">
        <div class="site-container page-hero-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">Calm. Local. Precise. Human.</span>
                <h1>{{ $aboutData['hero_title'] ?? 'Care is a system, not a slogan.' }}</h1>
                <p>{{ $aboutData['hero_subtitle'] ?? 'Cleanway exists to return clarity, confidence and time to homes and workplaces — with a service that is straightforward from the first conversation.' }}</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('contact', ['gotoquote' => 1]) }}">Meet the standard <i data-lucide="arrow-right"></i></a>
                    <a class="button button-secondary" href="{{ route('team') }}">Meet the team</a>
                </div>
            </div>
            <div class="about-manifesto reveal-on-scroll" data-reveal-delay="100">
                <span>Our promise in plain language</span>
                <blockquote>“Clean spaces.<br>Clear minds.”</blockquote>
                <p>A simple idea that works for a lived-in home, a busy workplace and every space in between.</p>
            </div>
        </div>
    </section>
