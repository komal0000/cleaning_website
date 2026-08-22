 <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
     @if ($setting && $setting->logo_path)
         <img src="{{ asset($setting->logo_path) }}" alt="Cleanway Logo" class="w-full h-full object-cover rounded-full">
     @endif
 </div>
 <span class="text-2xl font-bold text-blue-800">{!! $setting->logo_title?? 'Cleanway Service' !!}</span>
