    {{-- <div class="bg-blue-700 text-white py-2">
        <div class="container mx-auto px-4 flex justify-between items-center text-sm">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-1">
                    <i data-lucide="phone" class="w-4 h-4"></i>

                </div>
                <div class="flex items-center space-x-1">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                    <a href="mailto:{{ explode('|', $setting->contact_email)[0] }}"
                        class="text-xs sm:text-sm">{{ explode('|', $setting->contact_email)[0] }}</a>
                </div>
                <div class="hidden md:block">
                    <span>Available 24/7 for Emergency Cleaning</span>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="bg-blue-700 text-white py-2">
        <div class="container mx-auto px-4 flex justify-between items-center text-sm">
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone w-4 h-4">
                        <path
                            d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                        </path>
                    </svg>
                    @foreach (explode('|', $setting->contact_phone) as $phone)
                        <a href="tel:{{ $phone }}" class="text-xs sm:text-sm">{{ $phone }}</a>
                        @if (!$loop->last), @endif
                    @endforeach
                </div>
                <div class="flex items-center space-x-1"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-4 h-4">
                        <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                    </svg>
                    <a class="text-xs sm:text-sm" href="mailto:{{ explode('|', $setting->contact_email)[0] }}">{{ explode('|', $setting->contact_email)[0] }}</a>
                </div>
            </div>
            <div class="hidden md:block"><span>Available 24/7 for Emergency Cleaning</span></div>
        </div>
    </div>
