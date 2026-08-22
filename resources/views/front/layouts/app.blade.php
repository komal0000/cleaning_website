<!DOCTYPE html>
<html lang="en-NZ">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @includeIf('front.components.header.fav')

    <title>@yield('title', 'Cleanway Service Limited')</title>
    <meta name="description" content="@yield('description', 'Reliable home and commercial cleaning across Auckland, Hamilton, Palmerston North and Christchurch.')">

    @hasSection('meta')
        @yield('meta')
    @else
        @includeIf('front.components.header.meta')
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ config('app.version') }}">
    @stack('styles')

    @if(config('analytics.enabled') && config('analytics.measurement_id') && in_array(app()->environment(), config('analytics.environments', [])))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('analytics.measurement_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('analytics.measurement_id') }}', {
                @if(config('analytics.anonymize_ip')) 'anonymize_ip': true, @endif
                @if(config('analytics.debug_mode')) 'debug_mode': true, @endif
                @if(!config('analytics.send_page_view')) 'send_page_view': false, @endif
            });
        </script>
    @endif
</head>

<body class="site-body">
    <a class="skip-link" href="#main-content">Skip to main content</a>

    @includeIf('front.components.header')

    <main id="main-content">
        @yield('content')
    </main>

    @includeIf('front.components.footer')

    <nav class="mobile-action-bar" aria-label="Quick contact actions">
        <a href="{{ route('contact') }}">
            <i data-lucide="message-circle" aria-hidden="true"></i>
            <span>Contact</span>
        </a>
        <a class="mobile-action-primary" href="{{ route('contact', ['gotoquote' => 1]) }}">
            <i data-lucide="clipboard-check" aria-hidden="true"></i>
            <span>Get a quote</span>
        </a>
    </nav>

    <script src="{{ asset('js/app.js') }}?v={{ config('app.version') }}"></script>
    @stack('scripts')
</body>

</html>
