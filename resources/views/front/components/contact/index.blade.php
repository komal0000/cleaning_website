@php
    $contactContent = data_get($siteContent, 'pages.contact');
    $mapEmbed = \App\Support\SiteContent::mapEmbedSrc($setting?->contact_map);
    $mapImage = \App\Support\SiteContent::publicUrl($setting?->contact_map_path);
    $serviceRegions = $setting?->contact_service
        ?: implode(', ', data_get($siteContent, 'home.locations', []));
    $phones = array_values(array_filter(array_map('trim', explode('|', (string) $setting?->contact_phone))));
    $emails = array_values(array_filter(array_map('trim', explode('|', (string) $setting?->contact_email))));
@endphp

<section class="page-hero quote-page-hero">
    <div class="site-container page-hero-grid">
        <div class="reveal-on-scroll">
            <span class="eyebrow">{{ data_get($contactContent, 'eyebrow') }}</span>
            <h1>{{ data_get($contactContent, 'title') }}</h1>
            <p>{{ data_get($contactContent, 'description') }}</p>
        </div>
    </div>
</section>

<section id="quote-flow" class="section contact-split-section">
    <div class="site-container">
        <p class="contact-split-lead reveal-on-scroll">Ready for a cleaner space? Request a free, no-obligation quote and the local team will take it from there.</p>

        <div class="contact-split">
            <aside class="contact-info-card reveal-on-scroll">
                <h2>Get in touch</h2>

                <div class="contact-detail-list">
                    @if (count($phones))
                        <div>
                            <i data-lucide="phone" aria-hidden="true"></i>
                            <span>
                                <small>Phone</small>
                                @foreach ($phones as $phone)
                                    <strong><a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a></strong>
                                @endforeach
                            </span>
                        </div>
                    @endif

                    @if (count($emails))
                        <div>
                            <i data-lucide="mail" aria-hidden="true"></i>
                            <span>
                                <small>Email</small>
                                @foreach ($emails as $email)
                                    <strong><a href="mailto:{{ $email }}">{{ $email }}</a></strong>
                                @endforeach
                            </span>
                        </div>
                    @endif

                    @if (filled($setting?->contact_address))
                        <div>
                            <i data-lucide="map-pin" aria-hidden="true"></i>
                            <span>
                                <small>Address</small>
                                <strong>{{ $setting->contact_address }}</strong>
                            </span>
                        </div>
                    @endif

                    @if (filled($serviceRegions))
                        <div>
                            <i data-lucide="map" aria-hidden="true"></i>
                            <span>
                                <small>Service areas</small>
                                <strong>{{ $serviceRegions }}</strong>
                            </span>
                        </div>
                    @endif

                    @if (filled($setting?->contact_hours))
                        <div>
                            <i data-lucide="clock" aria-hidden="true"></i>
                            <span>
                                <small>Hours</small>
                                <strong>{{ trim(strip_tags($setting->contact_hours)) }}</strong>
                            </span>
                        </div>
                    @endif
                </div>
            </aside>

            <div class="contact-quote-card quote-form-card reveal-on-scroll" data-reveal-delay="100">
                @if (session('success'))
                    <div class="quote-success" role="status">
                        <span><i data-lucide="check" aria-hidden="true"></i></span>
                        <p class="eyebrow">Request received</p>
                        <h2>Thank you. Your clean is one step closer.</h2>
                        <p>{{ session('success') }}</p>
                        <a class="button button-primary" href="{{ route('home') }}">Return home</a>
                    </div>
                @else
                    <h2>Request your free quote</h2>

                    @if ($errors->any())
                        <div class="form-error-summary" role="alert" tabindex="-1">
                            <strong>Please check the highlighted details.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @includeIf('front.components.contact.form')
                @endif
            </div>
        </div>
    </div>
</section>

@if ($mapEmbed || $mapImage)
    <section class="contact-map-section" aria-labelledby="contact-map-heading">
        <div class="site-container">
            <div class="section-heading reveal-on-scroll">
                <span class="eyebrow">{{ data_get($contactContent, 'map_eyebrow') }}</span>
                <h2 id="contact-map-heading">{{ data_get($contactContent, 'map_title') }}</h2>
                @if (filled(data_get($contactContent, 'map_description')))
                    <p>{{ data_get($contactContent, 'map_description') }}</p>
                @elseif (filled($setting?->contact_address))
                    <p>{{ $setting->contact_address }}</p>
                @endif
            </div>
            @if ($mapEmbed)
                <iframe
                    src="{{ $mapEmbed }}"
                    title="Cleanway service map"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen>
                </iframe>
            @else
                <img src="{{ $mapImage }}" alt="Map of Cleanway service areas" loading="lazy" width="1200" height="450">
            @endif
        </div>
    </section>
@endif
