    @php
        $beforeImages = $gallery->getBeforeImagesCollection();
        $afterImages = $gallery->getAfterImagesCollection();
        $firstBefore = $beforeImages->first();
        $firstAfter = $afterImages->first();
    @endphp

    <section class="result-detail-hero">
        <div class="site-container">
            <a class="result-back-link" href="{{ route('gallery') }}"><i data-lucide="arrow-left"></i> Back to results</a>
            <div class="result-detail-heading reveal-on-scroll">
                <div>
                    <span class="eyebrow">Project story</span>
                    <h1>{{ $gallery->title }}</h1>
                </div>
                <dl>
                    @if($gallery->service)<div><dt>Service</dt><dd>{{ $gallery->service->title }}</dd></div>@endif
                    @if($gallery->location)<div><dt>Location</dt><dd>{{ $gallery->location }}</dd></div>@endif
                    @if($gallery->completion_date)<div><dt>Completed</dt><dd>{{ $gallery->completion_date->format('F Y') }}</dd></div>@endif
                    <div><dt>Media</dt><dd>{{ $gallery->images->count() }} photos</dd></div>
                </dl>
            </div>

            <div class="result-detail-comparison reveal-on-scroll" data-reveal-delay="100">
                <div>@if($firstBefore)<img src="{{ asset($firstBefore->image_path) }}" alt="Before cleaning: {{ $firstBefore->caption ?: $gallery->title }}" width="960" height="720">@else<span>Before image not published</span>@endif<small>Before</small></div>
                <div>@if($firstAfter)<img src="{{ asset($firstAfter->image_path) }}" alt="After cleaning: {{ $firstAfter->caption ?: $gallery->title }}" width="960" height="720">@else<span>After image not published</span>@endif<small>After</small></div>
            </div>
        </div>
    </section>

    @if($gallery->description)
        <section class="section result-detail-story"><div class="site-container result-detail-story-grid"><span class="eyebrow">The project</span><div class="reveal-on-scroll"><h2>The result, in context.</h2><p>{{ $gallery->description }}</p></div></div></section>
    @endif

    @if($beforeImages->count() > 1 || $afterImages->count() > 1)
        <section class="section result-media-section">
            <div class="site-container">
                <div class="section-heading reveal-on-scroll"><span class="eyebrow">Project photography</span><h2>More from the transformation.</h2></div>
                <div class="result-media-grid">
                    @foreach($beforeImages->skip(1) as $image)<a class="reveal-on-scroll" href="{{ asset($image->image_path) }}" target="_blank" rel="noopener"><img src="{{ asset($image->image_path) }}" alt="Before cleaning: {{ $image->caption ?: $gallery->title }}" loading="lazy" width="720" height="540"><span>Before</span>@if($image->caption)<p>{{ $image->caption }}</p>@endif</a>@endforeach
                    @foreach($afterImages->skip(1) as $image)<a class="reveal-on-scroll" href="{{ asset($image->image_path) }}" target="_blank" rel="noopener"><img src="{{ asset($image->image_path) }}" alt="After cleaning: {{ $image->caption ?: $gallery->title }}" loading="lazy" width="720" height="540"><span>After</span>@if($image->caption)<p>{{ $image->caption }}</p>@endif</a>@endforeach
                </div>
            </div>
        </section>
    @endif

    @if($gallery->videos->isNotEmpty())
        <section class="section result-video-section"><div class="site-container"><div class="section-heading reveal-on-scroll"><span class="eyebrow eyebrow-light">Video</span><h2>See the space in motion.</h2></div><div class="result-video-grid">@foreach($gallery->videos as $video)<article class="reveal-on-scroll">@if($video->embed_url)<iframe src="{{ $video->embed_url }}" title="{{ $video->caption ?: $gallery->title }} video" loading="lazy" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>@else<a href="{{ $video->video_url }}" target="_blank" rel="noopener">Open project video <i data-lucide="arrow-up-right"></i></a>@endif @if($video->caption)<p>{{ $video->caption }}</p>@endif</article>@endforeach</div></div></section>
    @endif

    <section class="section results-cta-section"><div class="site-container reviews-cta-grid reveal-on-scroll"><div><span class="eyebrow eyebrow-light">Your space, reset</span><h2>Plan a result of your own.</h2></div><a class="button button-lime" href="{{ route('contact', ['gotoquote' => 1, 'service' => $gallery->service?->title]) }}">Start my quote <i data-lucide="arrow-right"></i></a></div></section>
