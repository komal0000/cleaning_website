@php
    $footerContent = data_get($siteContent, 'global.footer', []);
    $footerNavigation = collect(data_get($siteContent, 'global.navigation', []))->filter(fn ($item) => $item['visible'] ?? true);
@endphp
@includeIf('front.components.footer-google-reviews')

<footer class="site-footer">
    <div class="site-container">
        <section class="footer-cta" aria-labelledby="footer-cta-title">
            <div>
                <span class="eyebrow eyebrow-light">{{ data_get($footerContent, 'eyebrow') }}</span>
                <h2 id="footer-cta-title">{{ data_get($footerContent, 'title') }}</h2>
                <p>{{ data_get($footerContent, 'description') }}</p>
            </div>
            <div class="footer-cta-actions">
                <a class="button button-lime" href="{{ route('contact', ['gotoquote' => 1]) }}">
                    Start my quote
                    <i data-lucide="arrow-right" aria-hidden="true"></i>
                </a>
                <a class="button button-ghost-light" href="{{ route('contact') }}">Contact Cleanway</a>
            </div>
        </section>

        <div class="footer-grid">
            <div class="footer-brand-block">
                <a href="{{ route('home') }}" class="site-brand site-brand-footer" aria-label="Cleanway Service Limited home">
                    @if (View::exists('front.components.header.logo'))
                        @includeIf('front.components.header.logo')
                    @else
                        <span class="brand-fallback-mark" aria-hidden="true">CW</span>
                        <span class="brand-fallback-type">Cleanway <small>Service Limited</small></span>
                    @endif
                </a>
                <p>{{ data_get($footerContent, 'brand_description') }}</p>
                <a class="footer-social" href="{{ data_get($footerContent, 'facebook_url', 'https://www.facebook.com/profile.php?id=100090206349338') }}"
                    target="_blank" rel="noopener noreferrer" aria-label="Cleanway on Facebook">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.99 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.772-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12Z" /></svg>
                </a>
            </div>

            <div>
                <h3>Explore</h3>
                <ul>
                    @foreach ($footerNavigation->take(5) as $item)
                        <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h3>Company</h3>
                <ul>
                    @foreach ($footerNavigation->skip(5) as $item)
                        <li><a href="{{ route($item['route']) }}">{{ $item['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('employee.login') }}">Employee login</a></li>
                </ul>
            </div>

            <div class="footer-regions">
                <h3>Service regions</h3>
                <ul>
                    @php
                        $footerRegions = data_get($siteContent, 'home.locations', []);
                    @endphp
                    @foreach ($footerRegions as $footerRegion)
                        <li>{{ $footerRegion }}</li>
                    @endforeach
                </ul>
                <a href="{{ route('contact') }}">Check your postcode <i data-lucide="arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Cleanway Service Limited.</p>
            <p>Clean spaces. Clear minds.</p>
        </div>
    </div>
</footer>
