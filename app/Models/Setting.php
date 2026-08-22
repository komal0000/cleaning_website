<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'logo_path',
        'banner_image',
        'logo_title',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'home_title',
        'home_subtitle',
        'home_description',
        'youtube_url',
        'contact_email',
        'contact_phone',
        'contact_address',
        'contact_facebook',
        'contact_map',
        'contact_map_path',
        'contact_service',
        'contact_hours',
        'contact_why_choose_us',
        'service_areas',
        'our_promise',
        'team',
        'about',
        'use_image_in_about',
        'about_image_list',
        'statistics',
        'site_content',
        'testimonials',
        'google_analytics_measurement_id',
        'google_analytics_enabled',
        'google_analytics_debug',
        'google_analytics_anonymize_ip',
        'google_analytics_send_page_view',
        'google_analytics_environments',
        'google_map_api_key',
        'google_map_place_id',
        'about_image_per_line',
        'home_image_list',
        'use_image_in_home',
        'home_image_per_line',
        'google_review_url',
    ];

    protected $casts = [
        'statistics' => 'array',
        'site_content' => 'array',
        'testimonials' => 'array',
        'google_analytics_environments' => 'array',
        'google_analytics_enabled' => 'boolean',
        'google_analytics_debug' => 'boolean',
        'google_analytics_anonymize_ip' => 'boolean',
        'google_analytics_send_page_view' => 'boolean',
        'about_image_list' => 'array',
        'use_image_in_about' => 'boolean',
        'about_image_per_line' => 'integer',
        'home_image_list' => 'array',
        'use_image_in_home' => 'boolean',
        'home_image_per_line' => 'integer',
        'google_review_url' => 'string',
    ];
}
