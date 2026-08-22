 <div>
    <h3 class="text-xl font-bold mb-6">Contact Info</h3>
    <div class="space-y-4">
        <div class="flex items-start space-x-3">
            <i data-lucide="phone" class="w-5 h-5 text-blue-400 mt-1"></i>
            <div>
                @foreach (explode('|', $setting->contact_phone) as $phone)
                    <a href="tel:{{ $phone }}" class="text-gray-300">{{ $phone }}</a><br>
                @endforeach
            </div>
        </div>
        <div class="flex items-start space-x-3">
            <i data-lucide="mail" class="w-5 h-5 text-blue-400 mt-1"></i>
            <div>
                @foreach (explode('|', $setting->contact_email) as $email)

                    <a href="mailto:{{$email}}"
                    class="text-gray-300">{{$email}}</a><br>
                @endforeach
            </div>
        </div>
        <div class="flex items-start space-x-3">
            <i data-lucide="map-pin" class="w-5 h-5 text-blue-400 mt-1"></i>
            <div>
                <p class="text-gray-300">
                    {{$setting->contact_address}}
                </p>
            </div>
        </div>
        <div class="flex items-start space-x-3">
            <i data-lucide="map-pin" class="w-5 h-5 text-blue-400 mt-1"></i>
            <div>
                <p class="text-gray-300 font-medium">Areas of Service:</p>
                <p class="text-gray-300">{{ $setting->contact_service }}</p>
            </div>
        </div>
        <div class="flex items-start space-x-3">
            <i data-lucide="clock" class="w-5 h-5 text-blue-400 mt-1"></i>
            <div>
                <p class="text-gray-300 font-medium">Hours:</p>
                <p class="text-gray-300">{!! $setting->contact_hours ?? '' !!}</p>
            </div>
        </div>
    </div>
</div>
