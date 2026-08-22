<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Google Analytics Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the Google Analytics configuration for your application.
    | You can set your Google Analytics Measurement ID in your .env file.
    |
    */

    'measurement_id' => env('GOOGLE_ANALYTICS_MEASUREMENT_ID', null),

    'enabled' => env('GOOGLE_ANALYTICS_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Additional Configuration
    |--------------------------------------------------------------------------
    |
    | Additional Google Analytics configuration options
    |
    */

    'debug_mode' => env('GOOGLE_ANALYTICS_DEBUG', false),

    'anonymize_ip' => env('GOOGLE_ANALYTICS_ANONYMIZE_IP', true),

    'send_page_view' => env('GOOGLE_ANALYTICS_SEND_PAGE_VIEW', true),

    /*
    |--------------------------------------------------------------------------
    | Environments
    |--------------------------------------------------------------------------
    |
    | Specify which environments should track analytics
    |
    */

    'environments' => [
        'production',
        'staging',
        'local',
        'development',
        'testing',
    ],
];
