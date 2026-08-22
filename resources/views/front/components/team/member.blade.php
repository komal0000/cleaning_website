    <section class="section team-list-section">
        <div class="site-container">
            <div class="section-heading split-heading reveal-on-scroll">
                <div><span class="eyebrow">The Cleanway team</span><h2>Approachable people. Clear roles.</h2></div>
                <p>Real profiles help visitors understand who is behind the service without relying on generic staff imagery.</p>
            </div>

            <div class="team-grid">
                @forelse ($members as $index => $member)
                    <article class="team-profile-card reveal-on-scroll" data-reveal-delay="{{ ($index % 3) * 70 }}">
                        <div class="team-profile-image">
                            @if ($member->photo)
                                <img src="/{{ ltrim($member->photo, '/') }}" alt="{{ $member->name }}, {{ $member->position }}" loading="lazy" width="480" height="600">
                            @else
                                <span aria-hidden="true">{{ collect(explode(' ', $member->name))->map(fn ($part) => mb_substr($part, 0, 1))->take(2)->implode('') }}</span>
                            @endif
                            <small>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</small>
                        </div>
                        <div class="team-profile-copy">
                            <p>{{ $member->position }}</p>
                            <h3>{{ $member->name }}</h3>
                            @if ($member->experienced)
                                <ul>
                                    @foreach (array_filter(explode('|', $member->experienced)) as $experience)
                                        <li>{{ $experience }}</li>
                                    @endforeach
                                </ul>
                            @endif
                            @if ($member->bio)
                                <div>{{ $member->bio }}</div>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="team-empty-state reveal-on-scroll">
                        <i data-lucide="users" aria-hidden="true"></i>
                        <h2>Team profiles are being prepared.</h2>
                        <p>Only real, approved Cleanway profiles will be published here.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section team-culture-section">
        <div class="site-container team-culture-grid">
            <div class="reveal-on-scroll"><span class="eyebrow eyebrow-light">Work with Cleanway</span><h2>Interested in joining the team?</h2><p>See the roles currently published by Cleanway and use the mobile-friendly application form.</p></div>
            <a class="button button-lime" href="{{ route('career') }}">View current roles <i data-lucide="arrow-right"></i></a>
        </div>
    </section>
