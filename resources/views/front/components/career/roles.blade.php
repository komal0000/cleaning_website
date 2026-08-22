    <section id="open-roles" class="section roles-section">
        <div class="site-container">
            <div class="section-heading split-heading reveal-on-scroll"><div><span class="eyebrow">Open roles</span><h2>Find your place at Cleanway.</h2></div><p>Only roles currently entered by the business are shown here.</p></div>
            <div class="role-grid">
                @forelse ($careers as $index => $career)
                    <article class="role-card reveal-on-scroll" data-reveal-delay="{{ ($index % 2) * 70 }}">
                        <div><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><i data-lucide="briefcase-business"></i></div>
                        <p><i data-lucide="map-pin"></i>{{ $career->location }} @if ($career->type)<em>{{ $career->type }}</em>@endif</p>
                        <h2>{{ $career->title }}</h2>
                        <div class="role-description">{{ $career->description }}</div>
                        @if ($career->requirement)
                            <ul>@foreach (array_filter(explode('|', $career->requirement)) as $requirement)<li><i data-lucide="check"></i>{{ $requirement }}</li>@endforeach</ul>
                        @endif
                        <footer><small>Applications close {{ \Illuminate\Support\Carbon::parse($career->deadline)->format('j M Y') }}</small><a href="#apply" data-position="{{ $career->title }}">Apply for this role <i data-lucide="arrow-down"></i></a></footer>
                    </article>
                @empty
                    <div class="roles-empty reveal-on-scroll"><i data-lucide="briefcase"></i><h2>No open roles are published right now.</h2><p>Check back later for opportunities with Cleanway.</p></div>
                @endforelse
            </div>
        </div>
    </section>
