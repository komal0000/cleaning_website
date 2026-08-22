<section class="home-hero">
    <div class="hero-glow" aria-hidden="true"></div>
    <div class="site-container hero-grid">
        <div class="hero-copy reveal-on-scroll">
            <span class="eyebrow">Home &amp; commercial cleaning across New Zealand</span>
            <h1>Clean spaces.<br><span>Clear minds.</span></h1>
            <p>Reliable home and commercial cleaning across Auckland, Hamilton, Palmerston North and Christchurch — shaped around your space, schedule and priorities.</p>

            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('contact', ['gotoquote' => 1]) }}">
                    Get my free quote
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
                <a class="button button-secondary" href="{{ route('gallery') }}">
                    See our work
                    <i data-lucide="images" aria-hidden="true"></i>
                </a>
            </div>

            @php
                $heroStats = ($setting && is_countable($setting->statistics ?? null) && count($setting->statistics))
                    ? $setting->statistics
                    : [
                        ['title' => '4', 'subtitle' => 'service regions', 'icon' => 'map-pin'],
                        ['title' => 'Home', 'subtitle' => 'everyday &amp; deep cleans', 'icon' => 'house'],
                        ['title' => 'Business', 'subtitle' => 'planned site cleaning', 'icon' => 'building-2'],
                    ];
            @endphp
            <dl class="hero-facts" aria-label="Cleanway at a glance">
                @foreach ($heroStats as $stat)
                    <div><dt>{{ $stat['title'] ?? '' }}</dt><dd>{{ $stat['subtitle'] ?? '' }}</dd></div>
                @endforeach
            </dl>
        </div>

        <div class="hero-visual reveal-on-scroll" data-reveal-delay="120">
                <figure class="clean-reveal-scene cleanway-photo-frame">
                    <img class="cleanway-hero-photo"
                        src="{{ asset('images/cleanway/home-cleaning-glass-hero.jpg') }}"
                        alt="Cleanway team member cleaning a commercial glass surface"
                        width="1536" height="1024" fetchpriority="high">
                    <figcaption class="scene-caption">
                        <span>Cleanway at work</span>
                        <strong>Prepared for the spaces you rely on.</strong>
                    </figcaption>
                </figure>
        </div>
    </div>

    <div class="site-container quote-starter-wrap reveal-on-scroll" data-reveal-delay="180">
        <form class="quote-starter" action="{{ route('contact') }}" method="GET" data-quote-starter>
            <div class="quote-starter-heading">
                <span>Start with the essentials</span>
                <strong>Find the right clean in under a minute.</strong>
            </div>
            <label>
                <span>Postcode</span>
                <input type="text" name="postcode" inputmode="numeric" autocomplete="postal-code" placeholder="e.g. 1010" required>
            </label>
            <label>
                <span>Your space</span>
                <select name="space" required>
                    <option value="">Choose one</option>
                    <option value="home">Home</option>
                    <option value="business">Business</option>
                    <option value="stay">Airbnb / stay</option>
                    <option value="other">Other</option>
                </select>
            </label>
            @php
                $quoteOptions = (isset($services) && $services->count() > 0)
                    ? $services->pluck('title')->push('Other')->all()
                    : ['Regular cleaning', 'Deep cleaning', 'Move in / out cleaning', 'Commercial cleaning', 'Carpet cleaning', 'Window cleaning', 'Other'];
            @endphp
            <label>
                <span>Service need</span>
                <select name="service" required>
                    <option value="">Choose a service</option>
                    @foreach ($quoteOptions as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                    @endforeach
                </select>
            </label>
            <input type="hidden" name="gotoquote" value="1">
            <button class="button button-primary" type="submit">
                Continue
                <i data-lucide="arrow-right" aria-hidden="true"></i>
            </button>
        </form>
    </div>
</section>

<section class="section audience-section">
    <div class="site-container">
        <div class="section-heading split-heading reveal-on-scroll">
            <div>
                <span class="eyebrow">Choose your path</span>
                <h2>Cleaning built around how you use the space.</h2>
            </div>
            <p>Start with the outcome you need. We’ll help shape the scope, frequency and details from there.</p>
        </div>

        <div class="audience-grid">
            <a class="audience-card audience-home reveal-on-scroll" href="{{ route('services') }}#for-home">
                <span class="audience-number">01</span>
                <i data-lucide="house" aria-hidden="true"></i>
                <div>
                    <h3>For your home</h3>
                    <p>Regular upkeep, deep cleans, moving, windows and carpet.</p>
                    <span class="text-link">Explore home cleaning <i data-lucide="arrow-right" aria-hidden="true"></i></span>
                </div>
            </a>
            <a class="audience-card audience-business reveal-on-scroll" data-reveal-delay="100" href="{{ route('services') }}#for-business">
                <span class="audience-number">02</span>
                <i data-lucide="building-2" aria-hidden="true"></i>
                <div>
                    <h3>For your business</h3>
                    <p>Offices, retail, schools, showrooms and planned facility cleaning.</p>
                    <span class="text-link">Explore business cleaning <i data-lucide="arrow-right" aria-hidden="true"></i></span>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="section services-preview">
    <div class="site-container">
        <div class="section-heading reveal-on-scroll">
            <span class="eyebrow">Popular ways we help</span>
            <h2>One team. The right clean for the moment.</h2>
            <p>Clear pathways make it easier to find the service that fits your space.</p>
        </div>

        <div class="service-bento">
            @php
                $knownLucideIcons = ['house','home','building-2','building2','key-round','scan-search','waves','luggage','sparkles','shield-check','leaf','clock','building','warehouse','factory','users','map-pin','clipboard-check','check-circle','star','calendar','heart','award','user-check','dollar-sign','wind','spray-can','briefcase-business','sliders-horizontal','quote'];
                $previewCardType = function ($index) {
                    return ($index === 0 || $index === 5) ? 'service-card-wide' : '';
                };
                $previewServices = (isset($services) && $services->count() > 0)
                    ? $services->take(6)
                    : collect([
                        ['title' => 'Regular home cleaning', 'description' => 'Repeat care shaped around your rooms and routine.', 'icon' => 'house'],
                        ['title' => 'Commercial cleaning', 'description' => 'Site-specific cleaning for offices, retail and shared workplaces.', 'icon' => 'building-2'],
                        ['title' => 'Move in / out', 'description' => 'A focused reset for handovers, new homes and end-of-tenancy.', 'icon' => 'key-round'],
                        ['title' => 'Deep cleaning', 'description' => 'Detailed attention for spaces that need more than everyday upkeep.', 'icon' => 'scan-search'],
                        ['title' => 'Carpet cleaning', 'description' => 'Targeted care for high-use floors and soft surfaces.', 'icon' => 'waves'],
                        ['title' => 'Airbnb turnovers', 'description' => 'Guest-ready cleaning for stays, changeovers and hosting routines.', 'icon' => 'luggage'],
                    ]);
            @endphp
            @foreach ($previewServices as $index => $service)
                @php
                    $rawIcon = is_object($service) ? ($service->icon ?? '') : ($service['icon'] ?? '');
                    $rawIcon = $rawIcon === 'building2' ? 'building-2' : $rawIcon;
                    $icon = in_array($rawIcon, $knownLucideIcons, true) ? $rawIcon : 'spray-can';
                    $psTitle = is_object($service) ? $service->title : ($service['title'] ?? '');
                    $psDesc = is_object($service) ? ($service->description ?? '') : ($service['description'] ?? '');
                    $psQuote = $psTitle;
                @endphp
                <a class="service-preview-card {{ $previewCardType($index) }} reveal-on-scroll" data-reveal-delay="{{ ($index % 3) * 70 }}"
                    href="{{ route('contact', ['gotoquote' => 1, 'service' => $psQuote]) }}">
                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <i data-lucide="{{ $icon }}" aria-hidden="true"></i>
                    <div>
                        <h3>{{ $psTitle }}</h3>
                        <p>{{ $psDesc }}</p>
                    </div>
                    <i class="service-arrow" data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            @endforeach
        </div>
        <div class="section-action reveal-on-scroll">
            <a class="button button-secondary" href="{{ route('services') }}">View all services <i data-lucide="arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<section class="section standard-section">
    <div class="site-container standard-grid">
        <div class="standard-intro reveal-on-scroll">
            <span class="eyebrow eyebrow-light">The Cleanway Standard</span>
            <h2>A clear process from first conversation to final check.</h2>
            <p>Good service should remove uncertainty as well as mess. Every clean starts with a shared understanding of the space and the result.</p>
            <a class="text-link text-link-light" href="{{ route('about') }}">How Cleanway works <i data-lucide="arrow-right" aria-hidden="true"></i></a>
        </div>

        <ol class="standard-steps" data-process-steps>
            <li class="reveal-on-scroll"><span>01</span><div><h3>Plan</h3><p>Understand your space, priorities and access.</p></div></li>
            <li class="reveal-on-scroll"><span>02</span><div><h3>Prepare</h3><p>Confirm the scope, timing and practical details.</p></div></li>
            <li class="reveal-on-scroll"><span>03</span><div><h3>Clean</h3><p>Deliver the agreed service with care and focus.</p></div></li>
            <li class="reveal-on-scroll"><span>04</span><div><h3>Verify</h3><p>Check the result and close the loop clearly.</p></div></li>
        </ol>
    </div>
</section>

<section class="section reveal-story-section">
    <div class="site-container reveal-story-grid">
        <div class="reveal-story-visual reveal-on-scroll">
            <div class="reveal-story-half reveal-story-before"><span>Before</span></div>
            <div class="reveal-story-half reveal-story-after"><span>After</span></div>
            <div class="reveal-divider" aria-hidden="true"><span><i data-lucide="move-horizontal"></i></span></div>
        </div>
        <div class="reveal-story-copy reveal-on-scroll" data-reveal-delay="100">
            <span class="eyebrow">Proof over promises</span>
            <h2>The result should be easy to see — and easy to understand.</h2>
            <p>Our Results space is designed for real Cleanway projects with the service, location and outcome kept together. No generic stock stories and no invented claims.</p>
            <ul class="check-list">
                <li><i data-lucide="check" aria-hidden="true"></i> Real project photography</li>
                <li><i data-lucide="check" aria-hidden="true"></i> Clear service and location context</li>
                <li><i data-lucide="check" aria-hidden="true"></i> Before and after views that stay honest</li>
            </ul>
            <a class="button button-primary" href="{{ route('gallery') }}">Explore results <i data-lucide="arrow-right" aria-hidden="true"></i></a>
        </div>
    </div>
</section>

<section class="section locations-section">
    <div class="site-container locations-grid">
        <div class="locations-copy reveal-on-scroll">
            <span class="eyebrow">Local by design</span>
            <h2>One Cleanway standard, delivered by local teams.</h2>
            <p>Choose your region to start a quote that reaches the right local team.</p>
            <a class="button button-secondary" href="{{ route('contact') }}">Check your postcode <i data-lucide="map-pin" aria-hidden="true"></i></a>
        </div>
        <div class="region-list reveal-on-scroll" data-reveal-delay="100">
            @php
                $configuredRegions = ($setting && $setting->service_areas)
                    ? array_values(array_filter(array_column((array) json_decode($setting->service_areas, true) ?: [], 'name')))
                    : [];
                $siteRegions = $configuredRegions ?: ['Auckland', 'Hamilton', 'Palmerston North', 'Christchurch'];
            @endphp
            @foreach ($siteRegions as $index => $region)
                <a href="{{ route('contact', ['gotoquote' => 1, 'location' => $region]) }}">
                    <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <strong>{{ $region }}</strong>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            @endforeach
        </div>
    </div>
</section>
