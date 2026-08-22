    <section class="section results-list-section">
        <div class="site-container">
            @if($galleries->count() > 0)
                <div class="results-grid">
                    @foreach($galleries as $index => $gallery)
                        @php
                            $beforeImage = $gallery->firstBeforeImage();
                            $afterImage = $gallery->firstAfterImage();
                        @endphp
                        <article class="result-story-card reveal-on-scroll {{ $index === 0 ? 'result-story-featured' : '' }}" data-reveal-delay="{{ ($index % 2) * 70 }}">
                            <a class="result-comparison" href="{{ route('gallery.detail', $gallery->id) }}" aria-label="View {{ $gallery->title }} project details">
                                <div>
                                    @if($beforeImage)<img src="{{ asset($beforeImage->image_path) }}" alt="Before cleaning: {{ $gallery->title }}" loading="lazy" width="700" height="520">@else<span class="result-image-empty">Before image not published</span>@endif
                                    <small>Before @if($gallery->getBeforeImagesCollection()->count() > 1) · +{{ $gallery->getBeforeImagesCollection()->count() - 1 }}@endif</small>
                                </div>
                                <div>
                                    @if($afterImage)<img src="{{ asset($afterImage->image_path) }}" alt="After cleaning: {{ $gallery->title }}" loading="lazy" width="700" height="520">@else<span class="result-image-empty">After image not published</span>@endif
                                    <small>After @if($gallery->getAfterImagesCollection()->count() > 1) · +{{ $gallery->getAfterImagesCollection()->count() - 1 }}@endif</small>
                                </div>
                                @if($gallery->is_featured)<em>Featured</em>@endif
                            </a>
                            <div class="result-story-copy">
                                <div class="result-story-meta">
                                    @if($gallery->service)<span><i data-lucide="briefcase"></i>{{ $gallery->service->title }}</span>@endif
                                    @if($gallery->location)<span><i data-lucide="map-pin"></i>{{ $gallery->location }}</span>@endif
                                    @if($gallery->completion_date)<span><i data-lucide="calendar"></i>{{ $gallery->completion_date->format('M Y') }}</span>@endif
                                </div>
                                <h2>{{ $gallery->title }}</h2>
                                @if($gallery->description)<p>{{ Str::limit($gallery->description, 170) }}</p>@endif
                                <a class="text-link" href="{{ route('gallery.detail', $gallery->id) }}">See the result <i data-lucide="arrow-up-right"></i></a>
                            </div>
                        </article>
                    @endforeach
                </div>
                @if ($galleries->hasPages())
                    <nav class="results-pagination" aria-label="Results pagination">
                        @if ($galleries->onFirstPage())<span aria-disabled="true">Previous</span>@else<a href="{{ $galleries->previousPageUrl() }}" rel="prev">Previous</a>@endif
                        <strong>Page {{ $galleries->currentPage() }} of {{ $galleries->lastPage() }}</strong>
                        @if ($galleries->hasMorePages())<a href="{{ $galleries->nextPageUrl() }}" rel="next">Next</a>@else<span aria-disabled="true">Next</span>@endif
                    </nav>
                @endif
            @else
                <div class="results-empty reveal-on-scroll">
                    <i data-lucide="images"></i>
                    <h2>No project stories are published for this view.</h2>
                    <p>@if(request()->hasAny(['service', 'featured']))Try clearing the filters to see every available result.@elseCleanway is keeping this page empty until real, approved project photography is ready.@endif</p>
                    @if(request()->hasAny(['service', 'featured']))<a class="button button-primary" href="{{ route('gallery') }}">Clear filters</a>@endif
                </div>
            @endif
        </div>
    </section>
