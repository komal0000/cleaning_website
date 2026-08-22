    @php($galleryContent = data_get($siteContent, 'pages.gallery'))
    <section class="page-hero results-page-hero">
        <div class="site-container page-hero-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">{{ data_get($galleryContent, 'eyebrow') }}</span>
                <h1>{{ data_get($galleryContent, 'title') }}</h1>
                <p>{{ data_get($galleryContent, 'description') }}</p>
            </div>
            <form class="results-filter reveal-on-scroll" data-reveal-delay="100" method="GET" action="{{ route('gallery') }}">
                <strong>Filter project stories</strong>
                <label for="gallery-service"><span>Service</span><select name="service" id="gallery-service"><option value="">All services</option>@foreach($services as $service)<option value="{{ $service->id }}" @selected((string) request('service') === (string) $service->id)>{{ $service->title }}</option>@endforeach</select></label>
                <label for="featured"><span>Collection</span><select name="featured" id="featured"><option value="">All projects</option><option value="1" @selected(request('featured') === '1')>Featured projects</option></select></label>
                <button class="button button-primary" type="submit">Apply filters <i data-lucide="sliders-horizontal"></i></button>
                @if(request()->hasAny(['service', 'featured']))<a href="{{ route('gallery') }}">Clear filters</a>@endif
            </form>
        </div>
    </section>
