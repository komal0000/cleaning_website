@php
    $selectedService = old('service', request('service'));
@endphp

<form action="{{ route('contact.submit') }}" method="POST" id="quote-form" novalidate>
    @csrf

    <input type="hidden" name="location" value="{{ old('location', request('location')) }}">
    <input type="hidden" name="space_type" value="{{ old('space_type', request('space')) }}">
    <input type="hidden" name="postcode" value="{{ old('postcode', request('postcode')) }}">

    <div class="form-grid-two">
        <label class="form-field" for="name">
            <span>Full name <em>Required</em></span>
            <input id="name" name="name" type="text" autocomplete="name" value="{{ old('name') }}" placeholder="Enter your full name" required maxlength="120">
            @error('name')<small>{{ $message }}</small>@enderror
        </label>
        <label class="form-field" for="email">
            <span>Email address <em>Required</em></span>
            <input id="email" name="email" type="email" inputmode="email" autocomplete="email" value="{{ old('email') }}" placeholder="Enter your email address" required maxlength="255">
            @error('email')<small>{{ $message }}</small>@enderror
        </label>
    </div>

    <div class="form-grid-two">
        <label class="form-field" for="phone">
            <span>Phone number <em>Optional</em></span>
            <input id="phone" name="phone" type="tel" inputmode="tel" autocomplete="tel" value="{{ old('phone') }}" placeholder="Enter your phone number" maxlength="30">
            @error('phone')<small>{{ $message }}</small>@enderror
        </label>
        <label class="form-field" for="service">
            <span>Service needed <em>Required</em></span>
            <select id="service" name="service" required>
                <option value="">Select a service</option>
                @foreach ($services as $service)
                    <option value="{{ $service->title }}" @selected($selectedService === $service->title)>{{ $service->title }}</option>
                @endforeach
                <option value="Other" @selected($selectedService === 'Other')>Other</option>
            </select>
            @error('service')<small>{{ $message }}</small>@enderror
        </label>
    </div>

    <label class="form-field" for="message">
        <span>Additional details <em>Optional</em></span>
        <textarea id="message" name="message" rows="5" maxlength="2000" placeholder="Tell us about the space, timing or anything useful to know">{{ old('message') }}</textarea>
        @error('message')<small>{{ $message }}</small>@enderror
    </label>

    <label class="consent-field">
        <input type="checkbox" name="consent" value="1" @checked(old('consent')) required>
        <span>I agree that Cleanway may use these details to respond to this quote request.</span>
    </label>
    @error('consent')<small class="field-error">{{ $message }}</small>@enderror

    <button class="button button-primary contact-quote-submit" type="submit">
        Get my free quote
        <i data-lucide="send" aria-hidden="true"></i>
    </button>
</form>
