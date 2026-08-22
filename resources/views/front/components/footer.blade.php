@php
    $footerContent = data_get($siteContent, 'global.footer', []);
    $footerNavigation = collect(data_get($siteContent, 'global.navigation', []))->filter(fn ($item) => $item['visible'] ?? true);
@endphp
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
                        @include('front.components.header.logo')
                    @else
                        <span class="brand-fallback-mark" aria-hidden="true">CW</span>
                        <span class="brand-fallback-type">Cleanway <small>Service Limited</small></span>
                    @endif
                </a>
                <p>{{ data_get($footerContent, 'brand_description') }}</p>
                <a class="footer-social" href="{{ data_get($footerContent, 'facebook_url') }}"
                    target="_blank" rel="noopener noreferrer" aria-label="Cleanway on Facebook">
                    <i data-lucide="facebook" aria-hidden="true"></i>
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
