@php
    $utility = data_get($siteContent, 'global.utility', []);
    $navigation = collect(data_get($siteContent, 'global.navigation', []))->filter(fn ($item) => $item['visible'] ?? true);
    $quoteCta = data_get($siteContent, 'global.quote_cta', []);
@endphp

<div class="utility-bar">
    <div class="site-container utility-bar-inner">
        <div class="utility-contacts">
            <span><i data-lucide="phone" aria-hidden="true"></i>
                @foreach (data_get($utility, 'phones', []) as $phone)
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a>@if (! $loop->last)<b aria-hidden="true">,</b>@endif
                @endforeach
            </span>
            <a href="mailto:{{ data_get($utility, 'email') }}"><i data-lucide="mail" aria-hidden="true"></i>{{ data_get($utility, 'email') }}</a>
        </div>
        <p>{{ data_get($utility, 'emergency_message') }}</p>
    </div>
</div>

<header class="site-header" data-site-header>
    <nav class="site-container main-nav" aria-label="Primary navigation">
        <a href="{{ route('home') }}" class="site-brand" aria-label="Cleanway Service Limited home">
            @if (View::exists('front.components.header.logo'))
                @include('front.components.header.logo')
            @else
                <span class="brand-fallback-mark" aria-hidden="true">CW</span>
                <span class="brand-fallback-type">Cleanway <small>Service Limited</small></span>
            @endif
        </a>

        <button class="menu-toggle" id="mobile-menu-toggle" type="button" aria-expanded="false"
            aria-controls="mobile-menu" aria-label="Open navigation menu">
            <i data-lucide="menu" class="menu-open-icon" aria-hidden="true"></i>
            <i data-lucide="x" class="menu-close-icon" aria-hidden="true"></i>
        </button>

        <div class="desktop-nav">
            @foreach ($navigation as $item)
                <a href="{{ route($item['route']) }}" @class(['is-active' => request()->routeIs($item['route'].'*')])>{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('contact', ['gotoquote' => 1]) }}" class="nav-cta">
                {{ data_get($quoteCta, 'label', 'Get a quote') }}
                <i data-lucide="arrow-up-right" aria-hidden="true"></i>
            </a>
        </div>

        <div class="mobile-menu" id="mobile-menu" hidden>
            @foreach ($navigation as $item)
                <a href="{{ route($item['route']) }}" @class(['is-active' => request()->routeIs($item['route'].'*')])>{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('contact', ['gotoquote' => 1]) }}" class="nav-cta">{{ data_get($quoteCta, 'label', 'Get a quote') }}</a>
        </div>
    </nav>
</header>
