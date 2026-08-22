    <section class="section about-story-section">
        <div class="site-container about-story-grid">
            <figure class="about-story-visual reveal-on-scroll">
                <img class="about-story-photo"
                    src="{{ asset('images/cleanway/team-facility-cleaning.jpg') }}"
                    alt="Cleanway team members preparing a facility for use"
                    width="1024" height="1024" loading="lazy">
                <figcaption>Light in.<br>Clutter out.<br>Confidence back.</figcaption>
            </figure>
            <div class="reveal-on-scroll" data-reveal-delay="100">
                <span class="eyebrow">The Clean Reveal</span>
                <h2>{{ $aboutData['story']['title'] ?? 'We design the service around the moment the space changes.' }}</h2>
                @if (!empty($aboutData['story']['paragraph1']))
                    <p>{{ $aboutData['story']['paragraph1'] }}</p>
                @else
                    <p>The best clean is not about visual theatre. It is the quiet relief of opening a door to a space that feels ordered, cared for and ready to use.</p>
                @endif
                @if (!empty($aboutData['story']['paragraph2']))
                    <p>{{ $aboutData['story']['paragraph2'] }}</p>
                @else
                    <p>That is why our digital experience begins with the outcome, then asks only for the details needed to plan the work well.</p>
                @endif
            </div>
        </div>
    </section>
