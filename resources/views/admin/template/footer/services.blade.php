<div>
    <h3 class="text-xl font-bold mb-6">Our Services</h3>
    <ul class="space-y-3">
        @foreach ($services as $service)
            <li><a href="{{ route('services') }}#ser-{{ $service->id }}" class="text-gray-300 hover:text-blue-400 transition-colors">{{ $service->title }}</a></li>
        @endforeach
    </ul>
</div>
