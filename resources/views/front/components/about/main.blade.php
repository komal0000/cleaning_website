@php($aboutContent = data_get($siteContent, 'pages.about'))
<section class="page-hero about-page-hero">
        <div class="site-container page-hero-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">{{ data_get($aboutContent, 'eyebrow') }}</span>
                <h1>{{ data_get($aboutContent, 'title') }}</h1>
                <p>{{ data_get($aboutContent, 'description') }}</p>
                <div class="hero-actions">
                    <a class="button button-primary" href="{{ route('contact', ['gotoquote' => 1]) }}">Meet the standard <i data-lucide="arrow-right"></i></a>
                    <a class="button button-secondary" href="{{ route('team') }}">Meet the team</a>
                </div>
            </div>
            <div class="about-manifesto reveal-on-scroll" data-reveal-delay="100">
                @if (count(data_get($aboutContent, 'stats', [])) > 0)
                    <span>At a glance</span>
                    @foreach (data_get($aboutContent, 'stats', []) as $stat)
                        <p><strong>{{ $stat['number'] ?? '' }}</strong> {{ $stat['label'] ?? '' }}</p>
                    @endforeach
                @else
                    <span>Our promise in plain language</span>
                    <blockquote>“Clean spaces.<br>Clear minds.”</blockquote>
                    <p>A simple idea that works for a lived-in home, a busy workplace and every space in between.</p>
                @endif
            </div>
        </div>
    </section>
