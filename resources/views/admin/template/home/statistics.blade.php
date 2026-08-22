@if($setting && $setting->statistics && count($setting->statistics) > 0)
<section class="bg-gradient-to-br from-blue-50 to-cyan-50 py-20">
    <div class="container max-w-6xl mx-auto px-5">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 pt-8">
            @foreach($setting->statistics as $stat)
            <div class="text-center">
                <div class="bg-white rounded-full w-16 h-16 flex items-center justify-center mx-auto mb-3 shadow-md">
                    <i data-lucide="{{ $stat['icon'] === 'certificate' ? 'award' : ($stat['icon'] === 'users' ? 'users' : ($stat['icon'] === 'clock' ? 'clock' : ($stat['icon'] === 'trophy' ? 'trophy' : ($stat['icon'] === 'heart' ? 'heart' : 'star')))) }}" class="w-8 h-8 text-blue-600"></i>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $stat['title'] ?? '' }}</div>
                <div class="text-sm text-gray-600">{{ $stat['subtitle'] ?? '' }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
