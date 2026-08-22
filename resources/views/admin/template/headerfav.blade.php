@if ($setting && $setting->logo_path)
    <link rel="icon" type="image/x-icon" href="{{ asset($setting->logo_path) }}">
@endif
