@if (!empty($reviews))
    <div class="google-reviews max-w-6xl mx-auto py-10 px-2 md:px-5">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 p-4 text-center md:text-left" style="background: #F8F8F8;">
            <h3 class="text-2xl font-bold mb-4 md:mb-0">
            Google Reviews
            @if (isset($rating))
                <div class="flex flex-col items-center md:flex-row md:items-center mb-4 md:mb-0">
                <span class="text-lg font-semibold mr-2">{{ number_format($rating, 1) }}</span>
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                    @if ($rating >= $i)
                       <i data-lucide="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                    @elseif ($rating > $i - 1)
                        {{-- Half star --}}
                       <i data-lucide="star-half" class="w-5 h-5 text-yellow-400 fill-current"></i>
                    @else
                        {{-- Empty star --}}
                        <i data-lucide="star" class="w-5 h-5 text-gray-400 fill-current"></i>
                    @endif
                    @endfor
                </div>
                </div>
            @endif
            </h3>

            <a href="https://search.google.com/local/writereview?placeid={{ $placeId }}" target="_blank"
            class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded transition mt-2 md:mt-0">
            Add a Google Review
            </a>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($reviews->take(6) as $review)
                <div class="p-6 rounded-lg flex flex-col h-full" style="background-color: #F8F8F8;">
                    <div class="flex items-center mb-2">
                        <a href="{{ $review['author_url'] ?? '#' }}" target="_blank" class="flex items-center">
                            <img src="{{ $review['profile_photo_url'] ?? '' }}" alt="{{ $review['author_name'] }}"
                                class="w-8 h-8 rounded-full mr-3 border border-gray-300" referrerpolicy="no-referrer"
                                onerror="replaceIcon(this,'{{ $review['author_name'] }}')">
                            <span class="font-bold">{{ $review['author_name'] }}</span>
                        </a>
                        <span class="ml-2 text-yellow-400">&#9733; {{ $review['rating'] }}</span>
                    </div>
                    @if (!empty($review['text']))
                        <p class="text-gray-800 flex-grow">
                            {{ $review['text'] }}
                        </p>
                    @endif
                    <div class="text-xs text-gray-500 mt-2">{{ $review['relative_time_description'] }}</div>
                </div>
            @endforeach
            @if ($reviews->count() > 6)
                <div class="col-span-1 md:col-span-3 flex justify-center">
                    <a href="https://www.google.com/maps/place/?q=place_id:{{ $placeId }}" target="_blank"
                       class="inline-block bg-gray-200 hover:bg-gray-300 text-blue-700 font-semibold px-6 py-2 rounded transition">
                        View All Reviews
                    </a>
                </div>
            @endif
        </div>
    </div>
    <script>
        function replaceIcon(ele,authorName) {
            //replace the icon with a default image if it fails to load
            ele.src = 'https://ui-avatars.com/api/?name=' + encodeURIComponent(authorName) + '&background=random&color=fff';
        }
    </script>
@else
    <div class="text-gray-400">No Google reviews available.</div>
@endif
