@if ($setting->use_image_in_home)
    @if($setting->home_image_per_line == 1)
        <div class="grid grid-cols-1 gap-8">
            @foreach ($setting->home_image_list as $image)
                <div class="home-media-item">
                    <img src="{{ asset($image) }}" alt="Cleanway cleaning project" class="w-full object-cover" width="960" height="720">
                </div>
            @endforeach
        </div>
    @elseif($setting->home_image_per_line == 2)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach ($setting->home_image_list as $image)
                <div class="home-media-item">
                    <img src="{{ asset($image) }}" alt="Cleanway cleaning project" class="w-full object-cover" loading="lazy" width="960" height="720">
                </div>
            @endforeach
        </div>
    @elseif($setting->home_image_per_line == 3)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach ($setting->home_image_list as $image)
                <div class="home-media-item">
                    <img src="{{ asset($image) }}" alt="Cleanway cleaning project" class="w-full object-cover" loading="lazy" width="960" height="720">
                </div>
            @endforeach
        </div>
    @endif
@else
    @if ($setting->youtube_url && str_contains($setting->youtube_url, 'watch?v='))
        <div class="home-media-item">
            <iframe
                src="{{ str_replace('watch?v=', 'embed/', $setting->youtube_url) }}?modestbranding=1&rel=0"
                title="Cleanway cleaning service video" class="w-full h-96" frameborder="0" loading="lazy"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>
    @endif
@endif
