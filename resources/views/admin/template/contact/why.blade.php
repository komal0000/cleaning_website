 <div class="bg-blue-600 text-white rounded-2xl p-8 mt-12 ">
     <h3 class="text-xl md:text-2xl font-bold mb-4 text-center">Why Choose Us?</h3>
     <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
         @foreach (explode('|', $setting->contact_why_choose_us) as $why)
             <div class="flex items-center space-x-3">
                 <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
                 <span>{{ $why }}</span>
             </div>
         @endforeach
     </div>
 </div>
