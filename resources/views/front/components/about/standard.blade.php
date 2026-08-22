    <section class="section about-standard-section">
        <div class="site-container">
            <div class="section-heading reveal-on-scroll"><span class="eyebrow">The Cleanway Standard</span><h2>Four steps that keep expectations clear.</h2></div>
            <ol class="about-standard-list">
                @foreach ([
                    ['Plan', 'Understand the space, priorities, location and access.'],
                    ['Prepare', 'Confirm the agreed scope, timing and useful details.'],
                    ['Clean', 'Deliver the planned service with focused attention.'],
                    ['Verify', 'Check the result and close the loop clearly.'],
                ] as $index => $step)
                    <li class="reveal-on-scroll" data-reveal-delay="{{ $index * 60 }}"><span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span><div><h3>{{ $step[0] }}</h3><p>{{ $step[1] }}</p></div></li>
                @endforeach
            </ol>
        </div>
    </section>
