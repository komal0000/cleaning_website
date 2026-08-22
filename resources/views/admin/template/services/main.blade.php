@foreach ($services as $service )
<div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2 border border-blue-100" id="ser-{{ $service->id }}">
    @if($service->logo)
        <img src="/{{ $service->logo}}" alt="{{ $service->title }} Logo" class="w-12 h-12 object-contain rounded-full bg-white shadow-md ">
    @else
        <div class="w-16 h-16 rounded-full flex items-center justify-center mb-6 @if($service->logo) bg-white shadow-md @else bg-blue-600 @endif">
            <i data-lucide="{{ $service->icon ?? 'home' }}" class="w-8 h-8 text-white"></i>
        </div>
        @endif
    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{$service->title}}</h3>

    <p class="text-gray-600 mb-6 leading-relaxed">{{$service->description}}</p>
    <ul class="space-y-2">

        @foreach(explode('|', $service->features) as $feature)
        <li class="flex items-center text-sm text-gray-700">
            <div class="w-2 h-2 bg-teal-500 rounded-full mr-3"></div>
            {{ $feature }}
        </li>
        @endforeach
    </ul>
    <a href="{{ route('contact', ['gotoquote' => 1, 'service' => $service->title]) }}" class="mt-6 w-full bg-blue-600 text-white py-3 rounded-full hover:bg-blue-700 transition-colors font-medium block text-center">
        Get Quote
    </a>
</div>
@endforeach
