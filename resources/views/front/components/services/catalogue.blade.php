    <section id="all-services" class="section service-catalogue-section">
        <div class="site-container">
            <div class="section-heading reveal-on-scroll">
                <span class="eyebrow">All services</span>
                <h2>Choose a starting point. We’ll refine the details together.</h2>
                <p>Each quote keeps the service, location and timing context together so the right local team can respond.</p>
            </div>

            <div class="service-catalogue-grid">
                @forelse ($services as $index => $service)
                    <article class="catalogue-card reveal-on-scroll" data-reveal-delay="{{ ($index % 3) * 60 }}" id="ser-{{ $service->id }}">
                        <div class="catalogue-card-top">
                            <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            @if ($service->logo)
                                <img src="/{{ ltrim($service->logo, '/') }}" alt="" loading="lazy" width="48" height="48">
                            @else
                                <i data-lucide="{{ $service->icon ?: 'spray-can' }}" aria-hidden="true"></i>
                            @endif
                        </div>
                        <h3>{{ $service->title }}</h3>
                        @if ($service->description)
                            <p>{{ $service->description }}</p>
                        @endif
                        @if ($service->features)
                            <ul>
                                @foreach (array_filter(explode('|', $service->features)) as $feature)
                                    <li><i data-lucide="check" aria-hidden="true"></i>{{ $feature }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <a href="{{ route('contact', ['gotoquote' => 1, 'service' => $service->title]) }}">
                            Get a quote for this service
                            <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                        </a>
                    </article>
                @empty
                    <div class="catalogue-empty">
                        <i data-lucide="clipboard-list" aria-hidden="true"></i>
                        <h3>Tell us what needs cleaning.</h3>
                        <p>We’ll use your space, location and timing to help identify the right service.</p>
                        <a class="button button-primary" href="{{ route('contact', ['gotoquote' => 1]) }}">Start my quote</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
