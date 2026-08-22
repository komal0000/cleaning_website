    <section class="section service-paths-section">
        <div class="site-container">
            <div class="section-heading split-heading reveal-on-scroll">
                <div>
                    <span class="eyebrow">Start with who the clean is for</span>
                    <h2>Four clearer ways into the service catalogue.</h2>
                </div>
                <p>You should not need to decode a long list before you know whether a service is relevant.</p>
            </div>

            <div class="service-path-grid">
                <article id="for-home" class="service-path-card reveal-on-scroll">
                    <span>01</span><i data-lucide="house" aria-hidden="true"></i>
                    <h3>For your home</h3>
                    <p>Regular house cleaning, deep cleaning, move in/out, windows and carpet.</p>
                    <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'home']) }}">Start a home quote <i data-lucide="arrow-right"></i></a>
                </article>
                <article id="for-business" class="service-path-card service-path-dark reveal-on-scroll" data-reveal-delay="70">
                    <span>02</span><i data-lucide="building-2" aria-hidden="true"></i>
                    <h3>For your business</h3>
                    <p>Office, retail, school, supermarket, showroom and planned facility cleaning.</p>
                    <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'business']) }}">Plan a business clean <i data-lucide="arrow-right"></i></a>
                </article>
                <article class="service-path-card reveal-on-scroll" data-reveal-delay="140">
                    <span>03</span><i data-lucide="luggage" aria-hidden="true"></i>
                    <h3>For stays &amp; turnovers</h3>
                    <p>Airbnb and housekeeping support for changeovers and guest-ready spaces.</p>
                    <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'stay']) }}">Plan a turnover <i data-lucide="arrow-right"></i></a>
                </article>
                <article class="service-path-card service-path-aqua reveal-on-scroll" data-reveal-delay="210">
                    <span>04</span><i data-lucide="factory" aria-hidden="true"></i>
                    <h3>Specialist environments</h3>
                    <p>Industrial and higher-complexity spaces that need a clearly agreed scope.</p>
                    <a class="text-link" href="{{ route('contact', ['gotoquote' => 1, 'space' => 'other']) }}">Discuss the site <i data-lucide="arrow-right"></i></a>
                </article>
            </div>
        </div>
    </section>
