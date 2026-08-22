@if ($testimonialData['show_cta'] ?? true)
    <div class="text-center mt-16">
        <div class="bg-blue-600 text-white rounded-2xl p-8 max-w-4xl mx-auto">
            <h3 class="text-3xl font-bold mb-4">{{ $testimonialData['cta_title'] ?? 'Join Over 1000+ Happy Customers' }}
            </h3>
            <p class="text-xl mb-6 opacity-90">
                {{ $testimonialData['cta_description'] ?? 'Experience the difference professional cleaning can make. Get your free quote today!' }}
            </p>
            <a href="{{ route('contact', ['gotoquote' => 1]) }}"
                class="bg-white text-blue-600 px-8 py-4 rounded-full font-semibold hover:bg-gray-100 transition-colors text-lg inline-block">
                {{ $testimonialData['cta_button_text'] ?? 'Get Your Free Quote' }}
            </a>
        </div>
    </div>
@endif
