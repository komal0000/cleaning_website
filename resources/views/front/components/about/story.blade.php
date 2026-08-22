@php
    $aboutContent = data_get($siteContent, 'pages.about');
    $story = data_get($aboutContent, 'story', []);
    $image = data_get($aboutContent, 'image');
    $imageSrc = filled($image) && str_starts_with((string) $image, 'http')
        ? $image
        : asset($image);
@endphp
<section class="section about-story-section">
        <div class="site-container about-story-grid">
            <figure class="about-story-visual reveal-on-scroll">
                <img class="about-story-photo"
                    src="{{ $imageSrc }}"
                    alt="Cleanway team members preparing a facility for use"
                    width="1024" height="1024" loading="lazy">
                <figcaption>Light in.<br>Clutter out.<br>Confidence back.</figcaption>
            </figure>
            <div class="reveal-on-scroll" data-reveal-delay="100">
                <span class="eyebrow">{{ data_get($story, 'subtitle') ?: 'The Clean Reveal' }}</span>
                <h2>{{ data_get($story, 'title') ?: 'Our Story & Mission' }}</h2>
                @foreach (['paragraph1', 'paragraph2', 'paragraph3'] as $paragraph)
                    @if (filled(data_get($story, $paragraph)))
                        <p>{{ data_get($story, $paragraph) }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
