<div class="text-center mb-16">
    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
        {{ $testimonialData['main_title'] ?? 'What Our Clients' }}
        <span class="text-blue-600 block">{{ $testimonialData['main_title_highlight'] ?? 'Say About Us' }}</span>
    </h2>
    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
        {{ $testimonialData['subtitle'] ?? "Don't just take our word for it. Here's what our satisfied customers across New Zealand have to say about our cleaning services." }}
    </p>
</div>
