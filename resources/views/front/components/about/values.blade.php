@php($values = data_get($siteContent, 'pages.about.values', []))
@if (count($values))
<section class="section about-values-section">
        <div class="site-container">
            <div class="section-heading split-heading reveal-on-scroll">
                <div><span class="eyebrow eyebrow-light">How we want the service to feel</span><h2>Premium because it is considered.</h2></div>
                <p>Clear language, useful proof and thoughtful communication matter more than exaggerated claims.</p>
            </div>
                        <div class="value-grid">
                            @foreach ($values as $index => $value)
                                <article class="value-card reveal-on-scroll" data-reveal-delay="{{ $index * 60 }}">
                        <span>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span><i data-lucide="{{ $value['icon'] ?? 'heart' }}"></i><h3>{{ $value['title'] ?? '' }}</h3><p>{{ $value['description'] ?? '' }}</p>
                    </article>
                            @endforeach
                            </div>
        @php($features = data_get($siteContent, 'pages.about.features', []))
        @if (count($features))
            <div class="value-grid" style="margin-top: 2.5rem;">
                @foreach ($features as $index => $feature)
                    <article class="value-card reveal-on-scroll" data-reveal-delay="{{ $index * 40 }}">
                        <i data-lucide="{{ $feature['icon'] ?? 'check-circle' }}"></i>
                        <h3>{{ $feature['title'] ?? '' }}</h3>
                    </article>
                @endforeach
            </div>
        @endif
        </div>
    </section>
@endif
