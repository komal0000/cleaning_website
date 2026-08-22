<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Admin\SettingController;

class SaveGoogleMapReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'googlemap:save-reviews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate review view';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $setting = Setting::first();
        if (!$setting) {
            $this->error('No settings found in the database.');
            return 1;
        }
        // Fetch Google Map API key and Place ID from settings
        $apiKey = $setting->google_map_api_key;
        $placeId = $setting->google_map_place_id;
        if (!$apiKey || !$placeId) {
            $this->error('Google Map API key or Place ID is not set in the settings.');
            return 1;
        }
        // Fetch reviews from Google Maps API
        $url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$placeId}&fields=reviews,rating,user_ratings_total&key={$apiKey}";
        // dd($url);
        $response = @file_get_contents($url);
        if (!$response) {
            $this->error('Failed to fetch reviews from Google Maps API.');
            return 1;
        }
        $data = json_decode($response, true);
        $all_reviews = $data['result']['reviews'] ?? [];
        $rating = $data['result']['rating'] ?? null;
        $userRatingsTotal = $data['result']['user_ratings_total'] ?? null;
        $googleReviewUrl = $setting->google_review_url ?? null;
        // dd($data);
        //save json to storage
        $jsonPath = storage_path('app/google_reviews.json');
        File::put($jsonPath, json_encode($data, JSON_PRETTY_PRINT));
        $this->info('Google reviews JSON saved at: ' . $jsonPath);



        // Order reviews by rating (descending), then by presence of text (reviews with text come first)
        $reviews = collect($all_reviews)->sort(function ($a, $b) {
            // First, compare by rating (descending)
            if ($a['rating'] !== $b['rating']) {
            return $b['rating'] <=> $a['rating'];
            }
            // Then, reviews with text come before those without
            $aHasText = !empty(trim($a['text'] ?? ''));
            $bHasText = !empty(trim($b['text'] ?? ''));
            return $bHasText <=> $aHasText;
        })->values();
        // Generate Blade view for reviews
        $viewContent = view('admin.template.footer.google_review', compact('reviews', 'rating', 'userRatingsTotal', 'googleReviewUrl','placeId'))->render();
        $outputPath = resource_path('views/front/components/footer/google_review.blade.php');
        File::put($outputPath, $viewContent);

        $testimonialTemplete = view('admin.template.testimonials', compact('reviews', 'rating', 'userRatingsTotal', 'googleReviewUrl','placeId'))->render();
        $outputTestimonialPath = resource_path('views/front/components/testimonials/list.blade.php');
        File::put($outputTestimonialPath, $testimonialTemplete);
        $this->info('Google reviews view generated at: ' . $outputPath);
        $this->info('Google testimonials view generated at: ' . $outputTestimonialPath);

        return 0;
    }
}
