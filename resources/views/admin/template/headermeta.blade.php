<meta name="description" content="{{ $setting->meta_description ?? 'Professional cleaning services available 24/7. Contact us for residential and commercial cleaning solutions.' }}">
@if ($setting && $setting->meta_keywords)
    <meta name="keywords" content="{{ $setting->meta_keywords }}">
@endif

<!-- Social Media Meta Tags -->
@if ($setting && $setting->banner_image)
    <meta property="og:image" content="{{ asset($setting->banner_image) }}">
    <meta name="twitter:image" content="{{ asset($setting->banner_image) }}">
@endif
<meta property="og:title" content="{{ $setting->meta_title ?? 'Cleanway Service Limited - Professional Cleaning Services' }}">
<meta property="og:description" content="{{ $setting->meta_description ?? 'Professional cleaning services available 24/7. Contact us for residential and commercial cleaning solutions.' }}">
<meta property="og:type" content="website">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $setting->meta_title ?? 'Cleanway Service Limited - Professional Cleaning Services' }}">
<meta name="twitter:description" content="{{ $setting->meta_description ?? 'Professional cleaning services available 24/7. Contact us for residential and commercial cleaning solutions.' }}">
