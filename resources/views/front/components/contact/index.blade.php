    @php
        $contactContent = data_get($siteContent, 'pages.contact');
        $quoteRegions = data_get($siteContent, 'home.locations', []);
        $mapEmbed = \App\Support\SiteContent::mapEmbedSrc($setting?->contact_map);
        $mapImage = \App\Support\SiteContent::publicUrl($setting?->contact_map_path);
        $serviceRegions = $setting?->contact_service
            ?: implode(', ', data_get($siteContent, 'home.locations', []));
    @endphp
    <section class="page-hero quote-page-hero">
        <div class="site-container page-hero-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">{{ data_get($contactContent, 'eyebrow') }}</span>
                <h1>{{ data_get($contactContent, 'title') }}</h1>
                <p>{{ data_get($contactContent, 'description') }}</p>
            </div>
            <div class="quote-hero-note reveal-on-scroll" data-reveal-delay="100">
                <i data-lucide="clipboard-check" aria-hidden="true"></i>
                <div>
                    <strong>What happens next</strong>
                    <p>Your request is saved with the location, service and timing context your local team needs to review it.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="quote-flow" class="section quote-flow-section">
        <div class="site-container quote-layout">
            <aside class="quote-sidebar reveal-on-scroll">
                <span class="eyebrow">Your quote</span>
                <h2>Small steps.<br>Useful details.</h2>
                <p>Use Back at any point without losing what you entered.</p>

                <div class="quote-progress-meta">
                    <span data-quote-progress-text>Step 1 of 5</span>
                    <div class="quote-progress-track" aria-hidden="true"><span data-quote-progress></span></div>
                </div>

                <div class="quote-help-card">
                    <i data-lucide="message-circle" aria-hidden="true"></i>
                    <div>
                        <strong>Prefer human help?</strong>
                        @if ($setting && $setting->contact_phone)
                            @php($primaryPhone = trim(explode('|', $setting->contact_phone)[0]))
                            <a href="tel:{{ preg_replace('/\s+/', '', $primaryPhone) }}">Call {{ $primaryPhone }}</a>
                        @else
                            <a href="{{ route('contact') }}#contact-details">See contact options</a>
                        @endif
                    </div>
                </div>
            </aside>

            <div class="quote-form-card reveal-on-scroll" data-reveal-delay="100">
                @if (session('success'))
                    <div class="quote-success" role="status">
                        <span><i data-lucide="check" aria-hidden="true"></i></span>
                        <p class="eyebrow">Request received</p>
                        <h2>Thank you. Your clean is one step closer.</h2>
                        <p>{{ session('success') }}</p>
                        <a class="button button-primary" href="{{ route('home') }}">Return home</a>
                    </div>
                @else
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

                    <form action="{{ route('contact.submit') }}" method="POST" data-quote-flow novalidate>
                        @csrf

                        <fieldset class="quote-step" data-quote-step>
                            <legend><span>01 / Location</span>Where is the space?</legend>
                            <p>We use your postcode to route the request to the right service area.</p>

                            <label class="form-field" for="postcode">
                                <span>Postcode <em>Required</em></span>
                                <input id="postcode" name="postcode" type="text" inputmode="numeric" autocomplete="postal-code"
                                    value="{{ old('postcode', request('postcode')) }}" placeholder="e.g. 1010" required maxlength="12">
                                @error('postcode')<small>{{ $message }}</small>@enderror
                            </label>

                            <label class="form-field" for="location">
                                <span>Nearest region <em>Optional</em></span>
                                <select id="location" name="location">
                                    <option value="">Choose a region</option>
                                    @foreach ($quoteRegions as $region)
                                        <option value="{{ $region }}" @selected(old('location', request('location')) === $region)>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <div class="quote-step-actions"><button type="button" class="button button-primary" data-quote-next>Continue <i data-lucide="arrow-right"></i></button></div>
                        </fieldset>

                        <fieldset class="quote-step" data-quote-step hidden>
                            <legend><span>02 / Space</span>What are we cleaning?</legend>
                            <p>Choose the closest fit. You can add context later.</p>

                            <div class="choice-grid">
                                @foreach ([
                                    ['home', 'house', 'Home', 'House, apartment or tenancy'],
                                    ['business', 'building-2', 'Business', 'Office, retail, school or facility'],
                                    ['stay', 'luggage', 'Airbnb / stay', 'Turnover or housekeeping'],
                                    ['other', 'warehouse', 'Other', 'Specialist or another environment'],
                                ] as $choice)
                                    <label class="choice-card">
                                        <input type="radio" name="space_type" value="{{ $choice[0] }}" @checked(old('space_type', request('space')) === $choice[0]) required>
                                        <span><i data-lucide="{{ $choice[1] }}" aria-hidden="true"></i><strong>{{ $choice[2] }}</strong><small>{{ $choice[3] }}</small></span>
                                    </label>
                                @endforeach
                            </div>

                            <div class="quote-step-actions"><button type="button" class="button button-secondary" data-quote-back>Back</button><button type="button" class="button button-primary" data-quote-next>Continue <i data-lucide="arrow-right"></i></button></div>
                        </fieldset>

                        <fieldset class="quote-step" data-quote-step hidden>
                            <legend><span>03 / Service</span>What do you need?</legend>
                            <p>Choose the nearest service and how often you expect to need it.</p>

                            <label class="form-field" for="service">
                                <span>Service <em>Required</em></span>
                                <select id="service" name="service" required>
                                    <option value="">Choose a service</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->title }}" @selected(old('service', request('service')) === $service->title)>{{ $service->title }}</option>
                                    @endforeach
                                    <option value="Other" @selected(old('service', request('service')) === 'Other')>Other / not sure</option>
                                </select>
                                @error('service')<small>{{ $message }}</small>@enderror
                            </label>

                            <label class="form-field" for="frequency">
                                <span>Frequency <em>Optional</em></span>
                                <select id="frequency" name="frequency">
                                    <option value="">Not sure yet</option>
                                    @foreach (['One-off', 'Weekly', 'Fortnightly', 'Monthly', 'Other recurring'] as $frequency)
                                        <option value="{{ $frequency }}" @selected(old('frequency') === $frequency)>{{ $frequency }}</option>
                                    @endforeach
                                </select>
                            </label>

                            <div class="quote-step-actions"><button type="button" class="button button-secondary" data-quote-back>Back</button><button type="button" class="button button-primary" data-quote-next>Continue <i data-lucide="arrow-right"></i></button></div>
                        </fieldset>

                        <fieldset class="quote-step" data-quote-step hidden>
                            <legend><span>04 / Timing</span>When would suit?</legend>
                            <p>A preferred date helps the team understand your timing. It does not confirm a booking.</p>

                            <label class="form-field" for="preferred_timing">
                                <span>Preferred date or timing <em>Required</em></span>
                                <input id="preferred_timing" name="preferred_timing" type="text" value="{{ old('preferred_timing') }}" placeholder="e.g. Friday morning or 20 August" required maxlength="100">
                                @error('preferred_timing')<small>{{ $message }}</small>@enderror
                            </label>

                            <div class="urgency-group">
                                <span>How soon?</span>
                                @foreach (['flexible' => 'Flexible', 'soon' => 'As soon as practical', 'urgent' => 'Urgent request'] as $value => $label)
                                    <label><input type="radio" name="urgency" value="{{ $value }}" @checked(old('urgency', 'flexible') === $value)><span>{{ $label }}</span></label>
                                @endforeach
                            </div>

                            <label class="form-field" for="notes">
                                <span>Access or scope notes <em>Optional</em></span>
                                <textarea id="notes" name="notes" rows="4" maxlength="2000" placeholder="Size, rooms, access, priorities or anything useful to know">{{ old('notes') }}</textarea>
                            </label>

                            <div class="quote-step-actions"><button type="button" class="button button-secondary" data-quote-back>Back</button><button type="button" class="button button-primary" data-quote-next>Continue <i data-lucide="arrow-right"></i></button></div>
                        </fieldset>

                        <fieldset class="quote-step" data-quote-step hidden>
                            <legend><span>05 / Contact</span>How can we reach you?</legend>
                            <p>Add the contact details the team should use for this request.</p>

                            <div class="form-grid-two">
                                <label class="form-field" for="name"><span>Full name <em>Required</em></span><input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" required maxlength="120">@error('name')<small>{{ $message }}</small>@enderror</label>
                                <label class="form-field" for="phone"><span>Mobile number <em>Required</em></span><input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" value="{{ old('phone') }}" required maxlength="30">@error('phone')<small>{{ $message }}</small>@enderror</label>
                            </div>

                            <label class="form-field" for="email"><span>Email address <em>Required</em></span><input id="email" name="email" type="email" inputmode="email" autocomplete="email" value="{{ old('email') }}" required maxlength="255">@error('email')<small>{{ $message }}</small>@enderror</label>

                            <label class="consent-field">
                                <input type="checkbox" name="consent" value="1" @checked(old('consent')) required>
                                <span>I agree that Cleanway may use these details to respond to this quote request.</span>
                            </label>
                            @error('consent')<small class="field-error">{{ $message }}</small>@enderror

                            <div class="quote-step-actions"><button type="button" class="button button-secondary" data-quote-back>Back</button><button type="submit" class="button button-primary">Send my request <i data-lucide="send"></i></button></div>
                        </fieldset>
                    </form>
                @endif
            </div>
        </div>
    </section>

    <section id="contact-details" class="section contact-details-section">
        <div class="site-container contact-details-grid">
            <div class="reveal-on-scroll">
                <span class="eyebrow">Contact Cleanway</span>
                <h2>Prefer a direct conversation?</h2>
                @if (filled($setting?->contact_why_choose_us))
                    <p>{{ trim(strip_tags($setting->contact_why_choose_us)) }}</p>
                @else
                    <p>Use the primary contact details below. Service availability and response timing depend on your location and request.</p>
                @endif
            </div>
            <div class="contact-detail-list reveal-on-scroll" data-reveal-delay="100">
                @if ($setting && $setting->contact_phone)
                    @php($primaryPhone = trim(explode('|', $setting->contact_phone)[0]))
                    <a href="tel:{{ preg_replace('/\s+/', '', $primaryPhone) }}"><i data-lucide="phone"></i><span><small>Phone</small><strong>{{ $primaryPhone }}</strong></span><i data-lucide="arrow-up-right"></i></a>
                @endif
                @if ($setting && $setting->contact_email)
                    @php($primaryEmail = trim(explode('|', $setting->contact_email)[0]))
                    <a href="mailto:{{ $primaryEmail }}"><i data-lucide="mail"></i><span><small>Email</small><strong>{{ $primaryEmail }}</strong></span><i data-lucide="arrow-up-right"></i></a>
                @endif
                @if (filled($setting?->contact_address))
                    <div><i data-lucide="map-pin"></i><span><small>Address</small><strong>{{ $setting->contact_address }}</strong></span></div>
                @endif
                @if (filled($setting?->contact_hours))
                    <div><i data-lucide="clock"></i><span><small>Hours</small><strong>{{ trim(strip_tags($setting->contact_hours)) }}</strong></span></div>
                @endif
                @if (filled($serviceRegions))
                    <div><i data-lucide="map"></i><span><small>Service regions</small><strong>{{ $serviceRegions }}</strong></span></div>
                @endif
            </div>
        </div>
    </section>

    @if ($mapEmbed || $mapImage)
        <section class="contact-map-section" aria-label="Cleanway map">
            <div class="site-container">
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
