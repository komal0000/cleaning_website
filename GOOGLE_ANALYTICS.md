# Google Analytics Configuration

This application includes a configurable Google Analytics integration that reads from environment variables.

## Setup

1. **Environment Configuration**
   
   Add the following variables to your `.env` file:

   ```env
   # Google Analytics Configuration
   GOOGLE_ANALYTICS_MEASUREMENT_ID=G-XXXXXXXXXX
   GOOGLE_ANALYTICS_ENABLED=true
   GOOGLE_ANALYTICS_DEBUG=false
   GOOGLE_ANALYTICS_ANONYMIZE_IP=true
   GOOGLE_ANALYTICS_SEND_PAGE_VIEW=true
   ```

2. **Replace the Measurement ID**
   
   Replace `G-XXXXXXXXXX` with your actual Google Analytics 4 Measurement ID from your Google Analytics account.

3. **Environment Control**
   
   By default, analytics will only load in `production` and `staging` environments. You can modify this in `config/analytics.php`.

## Configuration Options

- `GOOGLE_ANALYTICS_ENABLED`: Enable/disable analytics (true/false)
- `GOOGLE_ANALYTICS_MEASUREMENT_ID`: Your GA4 Measurement ID
- `GOOGLE_ANALYTICS_DEBUG`: Enable debug mode for testing (true/false)
- `GOOGLE_ANALYTICS_ANONYMIZE_IP`: Anonymize IP addresses (true/false)
- `GOOGLE_ANALYTICS_SEND_PAGE_VIEW`: Automatically send page views (true/false)

## Usage

### Basic Setup
The analytics script will automatically load on both frontend and admin pages when enabled.

### Custom Event Tracking
You can use the provided helper methods in your Blade templates:

```blade
@analytics
<script>
    gtag('event', 'custom_event', {
        'custom_parameter': 'value'
    });
</script>
@endanalytics
```

### Using Helper Methods
```blade
{!! \App\Helpers\Analytics::trackEvent('button_click', ['button_name' => 'cta_button']) !!}

{!! \App\Helpers\Analytics::trackContactForm(['form_type' => 'contact']) !!}

{!! \App\Helpers\Analytics::trackButtonClick('download_button', ['file_type' => 'pdf']) !!}
```

### Using Blade Directives
```blade
@trackEvent('page_view', ['page_name' => 'about'])

@trackContactForm(['source' => 'header'])

@trackButtonClick('signup_button', ['location' => 'sidebar'])
```

## Security & Privacy

- IP anonymization is enabled by default
- Analytics only loads in specified environments (production, staging)
- All configuration is environment-based for security

## Troubleshooting

1. **Analytics not loading**: Check that `GOOGLE_ANALYTICS_ENABLED=true` and you're in a tracked environment
2. **Events not tracking**: Ensure your Measurement ID is correct and analytics is enabled
3. **Debug mode**: Set `GOOGLE_ANALYTICS_DEBUG=true` to enable debug logging

## Files Modified

- `config/analytics.php` - Main configuration file
- `app/Helpers/Analytics.php` - Helper methods for tracking
- `app/Providers/AppServiceProvider.php` - Blade directives
- `resources/views/front/layouts/app.blade.php` - Frontend integration
- `resources/views/admin/layouts/app.blade.php` - Admin integration
- `.env.example` - Environment configuration example
