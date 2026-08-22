<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();

        return view('admin.settings.index', compact('settings'));
    }

    public function meta()
    {
        $setting = Setting::first(); // Assuming only one row

        return view('admin.settings.edit', compact('setting'));
    }

    public function updateMeta(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|max:2048',
            'logo_title' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        $setting = Setting::first();
        $data = [];

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['logo_path'] = 'uploads/'.$filename;
        }

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $filename = time().'_banner_'.$file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['banner_image'] = 'uploads/'.$filename;
        }

        $data['logo_title'] = $request->logo_title;
        $data['meta_title'] = $request->meta_title;
        $data['meta_description'] = $request->meta_description;
        $data['meta_keywords'] = $request->meta_keywords;

        if ($setting) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }
        $this->render();

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function contact(Request $request)
    {
        if ($request->getMethod() == 'GET') {
            $setting = Setting::first(); // Assuming only one row

            return view('admin.settings.contacts', compact('setting'));

        } else {
            $setting = Setting::first();
            if (! $setting) {
                $setting = new Setting;
            }
            $setting->contact_email = $request->contact_email;
            $setting->contact_phone = $request->contact_phone;
            $setting->contact_address = $request->contact_address;
            $setting->contact_facebook = $request->contact_facebook;
            $setting->contact_service = $request->contact_service;
            $setting->contact_hours = $request->contact_hours;
            $setting->contact_why_choose_us = $request->contact_why_choose_us;
            $setting->contact_map = $request->contact_map;
            $setting->contact_map_path = $request->contact_map_path;

            $setting->save();

            $services = DB::table('services')->orderBy('position')->get();

            $this->render();

            return redirect()->back()->with('success', 'Contact settings updated successfully.');
        }
    }

    public function homeSettings(Request $request)
    {
        $setting = Setting::first();
        if (! $setting) {
            $setting = new Setting;
        }

        $useImageInHome = $setting->use_image_in_home ?? false;
        $homeImageList = $setting->home_image_list ?? [];
        $homeImagePerLine = $setting->home_image_per_line ?? 1;

        return view('admin.settings.home', compact('setting', 'useImageInHome', 'homeImageList', 'homeImagePerLine'));
    }

    /**
     * Update home settings
     */
    public function updateHomeSettings(Request $request)
    {
        $request->validate([
            'home_title' => 'nullable|string|max:255',
            'home_subtitle' => 'nullable|string|max:255',
            'home_description' => 'nullable|string|max:1000',
            'youtube_url' => 'nullable|url|max:500',
            'statistics' => 'nullable|array',
        ]);

        $setting = Setting::first();

        if (! $setting) {
            $setting = new Setting;
        }

        $setting->home_title = $request->home_title;
        $setting->home_subtitle = $request->home_subtitle;
        $setting->home_description = $request->home_description;
        $setting->youtube_url = $request->youtube_url;

        // Handle statistics data
        if ($request->has('statistics')) {
            $setting->statistics = $request->statistics;
        }

        $setting->use_image_in_home = $request->has('use_image_in_home');
        $setting->home_image_list = $request->input('home_image_list', []);
        $setting->home_image_per_line = $request->input('home_image_per_line', 1);

        $setting->save();

        return redirect()->route('admin.settings.home')
            ->with('success', 'Home settings updated successfully!');
    }

    public function render()
    {
        // Public templates resolve their content from settings at request time.
    }

    public function team(Request $request)
    {
        $setting = Setting::first();
        if ($request->getMethod() == 'GET') {
            if ($setting && $setting->team && $setting->team != '') {
                $aboutSetting = json_decode($setting->team, true);
            } else {

                $aboutSetting = [
                    'title1' => 'Meet Our Professional Team',
                    'subtitle1' => 'We are a team of professionals who are passionate about what we do.',
                    'title2' => 'Welcome to Cleanway Service Limited',
                    'subtitle2' => 'At Cleanway Service Limited, we are dedicated to providing top-tier cleaning services that cater to both residential and commercial clients. Our experienced team ensures that every space we service is left spotless, hygienic, and welcoming.',
                    'service_area' => 'Proudly serving Auckland & Christchurch with comprehensive cleaning solutions',
                    'expert_team' => 'Trained professionals committed to excellence in every cleaning project',
                ];
            }

            return view('admin.settings.team', compact('aboutSetting'));
        } else {
            if (! $setting) {
                $setting = new Setting;
            }
            $setting->team = json_encode($request->all());
            $setting->save();

            return redirect()->back()->with('success', 'Team settings updated successfully.');

        }

    }

    public function servicesSettings(Request $request)
    {
        $setting = Setting::first();

        if ($request->getMethod() == 'GET') {
            // Default service areas data
            $defaultServiceAreas = [
                [
                    'name' => 'Auckland',
                    'description' => 'Complete residential & commercial cleaning',
                ],
                [
                    'name' => 'Hamilton',
                    'description' => 'Professional cleaning services',
                ],
                [
                    'name' => 'Palmerston North',
                    'description' => 'Reliable cleaning solutions',
                ],
                [
                    'name' => 'Christchurch',
                    'description' => 'Quality cleaning services',
                ],
            ];

            // Default promise data
            $defaultPromise = [
                [
                    'title' => '100% Satisfaction Guarantee',
                    'description' => 'If you\'re not completely satisfied, we\'ll make it right',
                    'icon' => 'check-circle',
                ],
                [
                    'title' => 'Fully Insured & Bonded',
                    'description' => 'Complete protection for your property and peace of mind',
                    'icon' => 'shield',
                ],
                [
                    'title' => 'Eco-Friendly Products',
                    'description' => 'Safe for your family, pets, and the environment',
                    'icon' => 'leaf',
                ],
                [
                    'title' => 'Flexible Scheduling',
                    'description' => 'Services available when it\'s convenient for you',
                    'icon' => 'clock',
                ],
            ];

            $serviceAreas = $setting && $setting->service_areas ? json_decode($setting->service_areas, true) : $defaultServiceAreas;
            $ourPromise = $setting && $setting->our_promise ? json_decode($setting->our_promise, true) : $defaultPromise;

            return view('admin.settings.services', compact('serviceAreas', 'ourPromise'));
        } else {
            if (! $setting) {
                $setting = new Setting;
            }

            $setting->service_areas = json_encode($request->service_areas);
            $setting->our_promise = json_encode($request->our_promise);
            $setting->save();

            return redirect()->back()->with('success', 'Services settings updated successfully.');
        }
    }

    public function aboutSettings(Request $request)
    {
        $setting = Setting::first();

        if ($request->getMethod() == 'GET') {
            // Default about page data based on the image
            $defaultAboutData = [
                'hero_title' => 'Why Choose Cleanway Service?',
                'hero_subtitle' => 'With over 15 years of experience in the cleaning industry, we\'ve built our reputation on delivering exceptional results and outstanding customer service.',
                'stats' => [
                    [
                        'number' => '15+',
                        'label' => 'Years Experience',
                        'icon' => 'calendar',
                    ],
                    [
                        'number' => '1000+',
                        'label' => 'Satisfied Clients',
                        'icon' => 'users',
                    ],
                    [
                        'number' => '50+',
                        'label' => 'Expert Cleaners',
                        'icon' => 'user-check',
                    ],
                    [
                        'number' => '24/7',
                        'label' => 'Support Available',
                        'icon' => 'clock',
                    ],
                ],
                'features' => [
                    [
                        'title' => 'Fully Licensed & Insured',
                        'icon' => 'shield',
                    ],
                    [
                        'title' => 'Background-Checked Staff',
                        'icon' => 'user-check',
                    ],
                    [
                        'title' => 'Eco-Friendly Products',
                        'icon' => 'leaf',
                    ],
                    [
                        'title' => 'Satisfaction Guarantee',
                        'icon' => 'check-circle',
                    ],
                    [
                        'title' => 'Flexible Scheduling',
                        'icon' => 'calendar',
                    ],
                    [
                        'title' => 'Competitive Pricing',
                        'icon' => 'dollar-sign',
                    ],
                ],
                'values' => [
                    [
                        'title' => 'Customer First',
                        'description' => 'Your satisfaction is our top priority in everything we do.',
                        'icon' => 'heart',
                    ],
                    [
                        'title' => 'Excellence',
                        'description' => 'We strive for perfection in every cleaning task.',
                        'icon' => 'award',
                    ],
                    [
                        'title' => 'Integrity',
                        'description' => 'Honest, reliable service you can trust.',
                        'icon' => 'shield',
                    ],
                    [
                        'title' => 'Sustainability',
                        'description' => 'Eco-friendly practices that protect our environment.',
                        'icon' => 'leaf',
                    ],
                ],
                'story' => [
                    'title' => 'Our Story & Mission',
                    'subtitle' => 'Founded in 2009, Cleanway Service Limited began with a simple mission',
                    'paragraph1' => 'Founded in 2009, Cleanway Service Limited began with a simple mission: to provide exceptional cleaning services that exceed our clients\' expectations. What started as a small local business has grown into New Zealand\'s trusted cleaning partner.',
                    'paragraph2' => 'Our founder, Bipan Bhandari, recognized the need for reliable, professional cleaning services that prioritized both quality and environmental responsibility. This vision has guided our company\'s growth and continues to drive our commitment to excellence.',
                    'paragraph3' => 'Today, we serve residential and commercial clients across Auckland, Hamilton, Palmerston North, and Christchurch, maintaining the same personal touch and attention to detail that built our reputation.',
                ],
            ];

            $aboutData = $setting && $setting->about ? json_decode($setting->about, true) : $defaultAboutData;
            $useImageInAbout = $setting->use_image_in_about ?? false;
            $aboutImageList = $setting->about_image_list ?? [];
            $aboutImagePerLine = $setting->about_image_per_line ?? 1;

            return view('admin.settings.about', compact('aboutData', 'useImageInAbout', 'aboutImageList', 'aboutImagePerLine'));
        } else {
            // Handle POST request to update settings
            if (! $setting) {
                $setting = new Setting;
            }

            $setting->about = json_encode($request->except(['_token', 'use_image_in_about', 'about_image_list', 'about_image_per_line']));
            $setting->use_image_in_about = $request->has('use_image_in_about');
            $setting->about_image_list = $request->input('about_image_list', []);
            $setting->about_image_per_line = $request->input('about_image_per_line', 1);
            $setting->save();

            return redirect()->back()->with('success', 'About page settings updated successfully.');
        }
    }

    /**
     * Show testimonial settings page
     */
    public function testimonialSettings()
    {
        $setting = Setting::first();

        // Initialize default testimonial settings if not exists
        if (! $setting || ! $setting->testimonials) {
            $defaultTestimonials = [
                'main_title' => 'What Our Clients',
                'main_title_highlight' => 'Say About Us',
                'subtitle' => "Don't just take our word for it. Here's what our satisfied customers across New Zealand have to say about our cleaning services.",
                'cta_title' => 'Join Over 1000+ Happy Customers',
                'cta_description' => 'Experience the difference professional cleaning can make. Get your free quote today!',
                'cta_button_text' => 'Get Your Free Quote',
                'show_cta' => true,
            ];

            if (! $setting) {
                $setting = new Setting;
            }

            if (! $setting->testimonials) {
                $setting->testimonials = $defaultTestimonials;
                $setting->save();
            }
        }

        return view('admin.settings.testimonials', compact('setting'));
    }

    /**
     * Update testimonial settings
     */
    public function updateTestimonialSettings(Request $request)
    {
        $request->validate([
            'main_title' => 'required|string|max:255',
            'main_title_highlight' => 'required|string|max:255',
            'subtitle' => 'required|string|max:1000',
            'cta_title' => 'required|string|max:255',
            'cta_description' => 'required|string|max:500',
            'cta_button_text' => 'required|string|max:100',
            'show_cta' => 'boolean',
        ]);

        $setting = Setting::first();
        if (! $setting) {
            $setting = new Setting;
        }

        $testimonialData = [
            'main_title' => $request->main_title,
            'main_title_highlight' => $request->main_title_highlight,
            'subtitle' => $request->subtitle,
            'cta_title' => $request->cta_title,
            'cta_description' => $request->cta_description,
            'cta_button_text' => $request->cta_button_text,
            'show_cta' => $request->has('show_cta'),
        ];

        $setting->testimonials = $testimonialData;
        $setting->save();

        return redirect()->route('admin.settings.testimonials')
            ->with('success', 'Testimonial page settings updated successfully!');
    }

    /**
     * Show change password page
     */
    public function changePassword()
    {
        return view('admin.settings.change-password');
    }

    /**
     * Update user password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            ],
            'new_password_confirmation' => 'required',
        ], [
            'new_password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number and one special character.',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Check if new password is different from current password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'New password must be different from current password.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Log the password change for security
        Log::info('Password changed for user: '.$user->email.' at '.now());

        return redirect()->route('admin.settings.change-password')
            ->with('success', 'Password updated successfully! Please use your new password for future logins.');
    }

    /**
     * Show Google Analytics settings page
     */
    public function analyticsSettings()
    {
        $setting = Setting::first();

        return view('admin.settings.analytics', compact('setting'));
    }

    /**
     * Update Google Analytics settings
     */
    public function updateAnalyticsSettings(Request $request)
    {
        $request->validate([
            'google_analytics_measurement_id' => 'nullable|string|max:255',
            'google_analytics_enabled' => 'boolean',
            'google_analytics_debug' => 'boolean',
            'google_analytics_anonymize_ip' => 'boolean',
            'google_analytics_send_page_view' => 'boolean',
            'google_analytics_environments' => 'nullable|array',
        ]);

        $setting = Setting::first();
        if (! $setting) {
            $setting = new Setting;
        }

        // Update database settings
        $setting->google_analytics_measurement_id = $request->google_analytics_measurement_id;
        $setting->google_analytics_enabled = $request->has('google_analytics_enabled');
        $setting->google_analytics_debug = $request->has('google_analytics_debug');
        $setting->google_analytics_anonymize_ip = $request->has('google_analytics_anonymize_ip');
        $setting->google_analytics_send_page_view = $request->has('google_analytics_send_page_view');
        $setting->google_analytics_environments = $request->google_analytics_environments ?? [];

        $setting->save();

        // Update .env file with Google Analytics settings
        $this->updateEnvFile([
            'GOOGLE_ANALYTICS_MEASUREMENT_ID' => $request->google_analytics_measurement_id ?? '',
            'GOOGLE_ANALYTICS_ENABLED' => $request->has('google_analytics_enabled') ? 'true' : 'false',
            'GOOGLE_ANALYTICS_DEBUG' => $request->has('google_analytics_debug') ? 'true' : 'false',
            'GOOGLE_ANALYTICS_ANONYMIZE_IP' => $request->has('google_analytics_anonymize_ip') ? 'true' : 'false',
            'GOOGLE_ANALYTICS_SEND_PAGE_VIEW' => $request->has('google_analytics_send_page_view') ? 'true' : 'false',
            'GOOGLE_ANALYTICS_ENVIRONMENTS' => implode(',', $request->google_analytics_environments ?? []),
        ]);

        // Run artisan optimize to clear caches
        try {
            Artisan::call('optimize');
        } catch (\Exception $e) {
            Log::warning('Failed to run artisan optimize after updating analytics settings: '.$e->getMessage());
        }

        return redirect()->route('admin.settings.analytics')
            ->with('success', 'Google Analytics settings updated successfully!');
    }

    /**
     * Update .env file with new values
     */
    private function updateEnvFile(array $data)
    {
        $envPath = base_path('.env');

        if (! file_exists($envPath)) {
            return false;
        }

        $envContent = file_get_contents($envPath);

        foreach ($data as $key => $value) {
            $pattern = "/^{$key}=.*$/m";
            $replacement = "{$key}={$value}";

            if (preg_match($pattern, $envContent)) {
                // Key exists, update it
                $envContent = preg_replace($pattern, $replacement, $envContent);
            } else {
                // Key doesn't exist, append it
                $envContent .= "\n{$replacement}";
            }
        }

        file_put_contents($envPath, $envContent);

        return true;
    }

    /**
     * Save Google Map API key and Place ID from request
     */
    public function saveGoogleMapSettings(\Illuminate\Http\Request $request)
    {
        $setting = Setting::first() ?? new Setting;
        $setting->google_map_api_key = $request->input('google_map_api_key');
        $setting->google_map_place_id = $request->input('google_map_place_id');
        $setting->google_review_url = $request->input('google_review_url');
        $setting->save();
        Artisan::call('googlemap:save-reviews'); // Save Google Map reviews

        return redirect()->back()->with('success', 'Google Map settings updated successfully.');
    }

    /**
     * View Google Map API key, Place ID, and Review URL
     */
    public function viewGoogleMapSettings()
    {
        $setting = Setting::first() ?? new Setting;

        return view('admin.settings.googlemap', compact('setting'));
    }

    /**
     * Handle AJAX image upload for About section
     */
    public function uploadAboutImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'about_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $url = asset('uploads/'.$filename);

            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'No image uploaded.']);
    }

    /**
     * Handle AJAX image upload for Home section
     */
    public function uploadHomeImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'home_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $url = asset('uploads/'.$filename);

            return response()->json(['success' => true, 'url' => $url]);
        }

        return response()->json(['success' => false, 'message' => 'No image uploaded.']);
    }
}
