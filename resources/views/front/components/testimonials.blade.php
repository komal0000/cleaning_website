    @php($testimonialsContent = data_get($siteContent, 'pages.testimonials'))
    <section class="page-hero reviews-page-hero">
        <div class="site-container page-hero-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">{{ data_get($testimonialsContent, 'eyebrow') }}</span>
                <h1>{{ data_get($testimonialsContent, 'title') }}</h1>
                <p>{{ data_get($testimonialsContent, 'description') }}</p>
            </div>
            <div class="reviews-hero-mark reveal-on-scroll" data-reveal-delay="100" aria-hidden="true">“</div>
        </div>
    </section>

    <section class="section reviews-list-section">
        <div class="site-container">
            @if ($testimonials->isNotEmpty())
                <div class="review-editorial-grid">
                    @foreach ($testimonials as $index => $testimonial)
                        <article class="review-editorial-card reveal-on-scroll {{ $index === 0 ? 'review-featured' : '' }}" data-reveal-delay="{{ ($index % 3) * 70 }}">
                            <i data-lucide="quote" aria-hidden="true"></i>
                            <blockquote>{{ $testimonial->message }}</blockquote>
                            <footer>
                                @if ($testimonial->photo)
                                    <img src="/{{ ltrim($testimonial->photo, '/') }}" alt="" loading="lazy" width="48" height="48">
                                @else
                                    <span aria-hidden="true">{{ mb_substr($testimonial->name, 0, 1) }}</span>
                                @endif
                                <div><strong>{{ $testimonial->name }}</strong>@if ($testimonial->position)<small>{{ $testimonial->position }}</small>@endif</div>
                                @if ($testimonial->service)<em>{{ $testimonial->service }}</em>@endif
                            </footer>
                        </article>
                    @endforeach
                </div>
            @else
                <div class="reviews-empty-state reveal-on-scroll">
                    <i data-lucide="message-square-quote" aria-hidden="true"></i>
                    <h2>No client stories are published yet.</h2>
                    <p>This page is intentionally transparent rather than filling the space with generic or invented testimonials.</p>
                    <a class="button button-primary" href="{{ route('gallery') }}">Explore real project results</a>
                </div>
            @endif
        </div>
    </section>

    @if (data_get($testimonialsContent, 'show_cta', true))
    <section class="section reviews-cta-section">
        <div class="site-container reviews-cta-grid reveal-on-scroll">
            <div>
                <span class="eyebrow eyebrow-light">{{ data_get($testimonialsContent, 'cta_description') }}</span>
                <h2>{{ data_get($testimonialsContent, 'cta_title') }}</h2>
            </div>
            <a class="button button-lime" href="{{ route('contact', ['gotoquote' => 1]) }}">{{ data_get($testimonialsContent, 'cta_button_text') }} <i data-lucide="arrow-right"></i></a>
        </div>
    </section>
    @endif
