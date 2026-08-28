@php
    $googlePlaceId = 'ChIJ4UrE40VTDW0RAXtKyXd3fV8';
    $googleWriteReviewUrl = 'https://search.google.com/local/writereview?placeid=' . $googlePlaceId;
    $googleMapsUrl = 'https://www.google.com/maps/place/?q=place_id:' . $googlePlaceId;
    $googleReviews = [
        [
            'name' => 'New Zealand Nepal',
            'text' => 'The garden cleaning was very good. The team tidied up leaves, trimmed overgrown areas, and made the garden look fresh and well-kept. A small area near the fence could have used a bit more attention, but overall, I’m very happy with the service.',
        ],
        [
            'name' => 'gurjeet kaur',
            'text' => 'Service is too good with cheaper prices. They gave their 100% as our carpet was full of mould. They move the furniture as well. Love their work really appreciate.',
        ],
        [
            'name' => 'Cecilia Shiu',
            'text' => 'Nishabh is amazing. Their services are very good. Sincerely recommend.',
        ],
        [
            'name' => 'Rohit Pokharel',
            'text' => 'They are so good at what they doing!!',
        ],
    ];
@endphp
<section class="footer-reviews" aria-labelledby="footer-reviews-title">
    <div class="site-container">
        <div class="footer-reviews-header">
            <div>
                <span class="eyebrow">Google</span>
                <h2 id="footer-reviews-title">Google Reviews</h2>
                <p class="footer-reviews-rating">
                    <strong>5.0</strong>
                    <span class="footer-review-stars" aria-hidden="true">
                        @for ($i = 0; $i < 5; $i++)
                            <i data-lucide="star"></i>
                        @endfor
                    </span>
                    <span>11 reviews</span>
                </p>
            </div>
            <div class="footer-reviews-actions">
                <a class="button button-lime" href="{{ $googleWriteReviewUrl }}" target="_blank" rel="noopener noreferrer">
                    Add a Google Review
                    <i data-lucide="square-pen" aria-hidden="true"></i>
                </a>
                <a class="footer-reviews-maps" href="{{ $googleMapsUrl }}" target="_blank" rel="noopener noreferrer">
                    View More
                    <i data-lucide="arrow-up-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>

        <div class="footer-reviews-grid">
            @foreach ($googleReviews as $review)
                <article class="footer-review-card">
                    <span class="footer-review-stars" aria-label="5 out of 5 stars">
                        @for ($i = 0; $i < 5; $i++)
                            <i data-lucide="star"></i>
                        @endfor
                    </span>
                    <blockquote>{{ $review['text'] }}</blockquote>
                    <p>{{ $review['name'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
