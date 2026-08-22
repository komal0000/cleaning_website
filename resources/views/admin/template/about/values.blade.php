    <section class="section about-values-section">
        <div class="site-container">
            <div class="section-heading split-heading reveal-on-scroll">
                <div><span class="eyebrow eyebrow-light">How we want the service to feel</span><h2>Premium because it is considered.</h2></div>
                <p>Clear language, useful proof and thoughtful communication matter more than exaggerated claims.</p>
            </div>
            @php
                $aboutValues = (!empty($aboutData['values']) && is_array($aboutData['values']))
                    ? $aboutData['values']
                    : [
                        ['title' => 'Calm', 'description' => 'We reduce friction and keep the next step easy to understand.', 'icon' => 'wind'],
                        ['title' => 'Local', 'description' => 'Requests stay connected to the region and space they come from.', 'icon' => 'map-pin'],
                        ['title' => 'Precise', 'description' => 'Scope, timing and practical details are made visible early.', 'icon' => 'scan-search'],
                        ['title' => 'Human', 'description' => 'Real people and real work carry the story — never invented proof.', 'icon' => 'users'],
                    ];
                $knownLucideIcons = ['house','home','building-2','building2','key-round','scan-search','waves','luggage','sparkles','shield-check','shield','leaf','clock','building','warehouse','factory','users','map-pin','clipboard-check','check-circle','star','calendar','heart','award','user-check','dollar-sign','wind','spray-can','briefcase-business','sliders-horizontal','quote'];
            @endphp
            <div class="value-grid">
                @foreach ($aboutValues as $index => $value)
                    @php
                        $rawIcon = $value['icon'] ?? '';
                        $rawIcon = $rawIcon === 'building2' ? 'building-2' : $rawIcon;
                        $icon = in_array($rawIcon, $knownLucideIcons, true) ? $rawIcon : 'sparkles';
                    @endphp
                    <article class="value-card reveal-on-scroll" data-reveal-delay="{{ $index * 60 }}">
                        <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><i data-lucide="{{ $icon }}"></i><h3>{{ $value['title'] ?? '' }}</h3><p>{{ $value['description'] ?? '' }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
