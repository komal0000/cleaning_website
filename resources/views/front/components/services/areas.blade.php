@php
    $serviceAreas = data_get($siteContent, 'pages.services.areas', []);
@endphp
@if (count($serviceAreas))
<section class="section service-paths-section" id="service-areas">
    <div class="site-container">
        <div class="section-heading split-heading reveal-on-scroll">
            <div>
                <span class="eyebrow">Where we work</span>
                <h2>Local teams across the regions we currently serve.</h2>
            </div>
            <p>These areas are published from the services settings, including the description for each region.</p>
        </div>

        <div class="service-path-grid">
            @foreach ($serviceAreas as $index => $area)
                @php
                    $modifiers = ['', 'service-path-dark', '', 'service-path-aqua'];
                    $cardClass = trim('service-path-card '.$modifiers[$index % 4]);
                @endphp
                <article class="{{ $cardClass }} reveal-on-scroll" data-reveal-delay="{{ ($index % 4) * 70 }}">
                    <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <i data-lucide="map-pin" aria-hidden="true"></i>
                    <h3>{{ $area['name'] }}</h3>
                    @if (filled($area['description'] ?? null))
                        <p>{{ $area['description'] }}</p>
                    @endif
                    <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'location' => $area['name']]) }}">
                        Start a {{ $area['name'] }} quote
                        <i data-lucide="arrow-right"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="section service-paths-section">
    <div class="site-container">
        <div class="section-heading split-heading reveal-on-scroll">
            <div>
                <span class="eyebrow">Start with who the clean is for</span>
                <h2>Four clearer ways into the service catalogue.</h2>
            </div>
            <p>You should not need to decode a long list before you know whether a service is relevant.</p>
        </div>

        <div class="service-path-grid">
            <article id="for-home" class="service-path-card reveal-on-scroll">
                <span>01</span><i data-lucide="house" aria-hidden="true"></i>
                <h3>For your home</h3>
                <p>Regular house cleaning, deep cleaning, move in/out, windows and carpet.</p>
                <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'home']) }}">Start a home quote <i data-lucide="arrow-right"></i></a>
            </article>
            <article id="for-business" class="service-path-card service-path-dark reveal-on-scroll" data-reveal-delay="70">
                <span>02</span><i data-lucide="building-2" aria-hidden="true"></i>
                <h3>For your business</h3>
                <p>Office, retail, school, supermarket, showroom and planned facility cleaning.</p>
                <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'business']) }}">Plan a business clean <i data-lucide="arrow-right"></i></a>
            </article>
            <article class="service-path-card reveal-on-scroll" data-reveal-delay="140">
                <span>03</span><i data-lucide="luggage" aria-hidden="true"></i>
                <h3>For stays &amp; turnovers</h3>
                <p>Airbnb and housekeeping support for changeovers and guest-ready spaces.</p>
                <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'stay']) }}">Plan a turnover <i data-lucide="arrow-right"></i></a>
            </article>
            <article class="service-path-card service-path-aqua reveal-on-scroll" data-reveal-delay="210">
                <span>04</span><i data-lucide="factory" aria-hidden="true"></i>
                <h3>Specialist environments</h3>
                <p>Industrial and higher-complexity spaces that need a clearly agreed scope.</p>
                <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'other']) }}">Discuss the site <i data-lucide="arrow-right"></i></a>
            </article>
        </div>
    </div>
</section>
