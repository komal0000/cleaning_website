@php
    $homeContent = data_get($siteContent, 'home', []);
    $quoteContent = data_get($homeContent, 'quote', []);
    $titleLines = explode('|', (string) data_get($homeContent, 'title'));
    $headline = $titleLines[0] ?? '';
    $highlight = data_get($homeContent, 'subtitle') ?: ($titleLines[1] ?? null);
    $serviceOptions = isset($services) && $services->isNotEmpty()
        ? $services->pluck('title')->push('Other')->all()
        : ['Regular cleaning', 'Deep cleaning', 'Move in / out cleaning', 'Commercial cleaning', 'Carpet cleaning', 'Window cleaning', 'Other'];
@endphp
<section class="home-hero">
    <div class="hero-glow" aria-hidden="true"></div>
    <div class="site-container hero-grid">
        <div class="hero-copy reveal-on-scroll">
            <span class="eyebrow">{{ data_get($homeContent, 'eyebrow') }}</span>
            <h1>{{ $headline }}@if ($highlight)<br><span>{{ $highlight }}</span>@endif</h1>
            <p>{{ data_get($homeContent, 'description') }}</p>
            @if (false)
            <p>Reliable home and commercial cleaning across Auckland, Hamilton, Palmerston North and Christchurch — shaped around your space, schedule and priorities.</p>

            @endif
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

            <dl class="hero-facts" aria-label="Cleanway at a glance">
                @foreach (data_get($homeContent, 'statistics', []) as $stat)
                    <div class="hero-fact"><dt>{{ $stat['title'] ?? '' }}</dt><dd>{{ $stat['subtitle'] ?? '' }}</dd></div>
                @endforeach
            </dl>
        </div>

        <div class="hero-visual reveal-on-scroll" data-reveal-delay="120">
                <figure class="clean-reveal-scene cleanway-photo-frame">
                    <img class="cleanway-hero-photo"
                        src="{{ asset(data_get($homeContent, 'hero_image')) }}"
                        alt="{{ data_get($homeContent, 'hero_image_alt') }}"
                        width="1536" height="1024" fetchpriority="high">
                    <figcaption class="scene-caption">
                        <span>{{ data_get($homeContent, 'hero_caption_label') }}</span>
                        <strong>{{ data_get($homeContent, 'hero_caption') }}</strong>
                    </figcaption>
                </figure>
        </div>
    </div>

    <div class="site-container quote-starter-wrap">
        <form class="quote-starter reveal-on-scroll" action="{{ route('contact') }}" method="GET" data-quote-starter data-reveal-delay="180">
            <div class="quote-starter-heading">
                <span>{{ data_get($quoteContent, 'eyebrow') }}</span>
                <strong>{{ data_get($quoteContent, 'title') }}</strong>
            </div>
            <label>
                <span>Your space</span>
                <select name="space" required>
                    <option value="">Choose one</option>
                    @foreach (data_get($quoteContent, 'space_options', []) as $spaceOption)
                        <option value="{{ \Illuminate\Support\Str::slug($spaceOption) }}">{{ $spaceOption }}</option>
                    @endforeach
                </select>
            </label>
                        <label>
                <span>Service need</span>
                <select name="service" required>
                    <option value="">Choose a service</option>
                    @foreach ($serviceOptions as $serviceOption)
                        <option value="{{ $serviceOption }}">{{ $serviceOption }}</option>
                    @endforeach
                                    </select>
            </label>
            <input type="hidden" name="gotoquote" value="1">
            <button class="button button-primary" type="submit">
                {{ data_get($quoteContent, 'continue_label') }}
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
            @forelse (($services ?? collect())->take(6) as $index => $service)
                <a class="service-preview-card {{ $index === 0 || $index === 5 ? 'service-card-wide' : '' }} reveal-on-scroll"
                    data-reveal-delay="{{ ($index % 3) * 70 }}"
                    href="{{ route('contact', ['gotoquote' => 1, 'service' => $service->title]) }}">
                    <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <i data-lucide="{{ $service->icon ?: 'sparkles' }}" aria-hidden="true"></i>
                    <div>
                        <h3>{{ $service->title }}</h3>
                        @if ($service->description)
                            <p>{{ $service->description }}</p>
                        @endif
                    </div>
                    <i class="service-arrow" data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            @empty
                <p>Services will appear here once they are published in the admin.</p>
            @endforelse
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
            @foreach (data_get($homeContent, 'locations', []) as $index => $location)
                <a href="{{ route('contact', ['gotoquote' => 1, 'location' => $location]) }}">
                    <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    <strong>{{ $location }}</strong>
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            @endforeach
                    </div>
    </div>
</section>
