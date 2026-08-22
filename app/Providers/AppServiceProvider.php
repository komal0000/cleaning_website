<?php

namespace App\Providers;

use App\Models\Setting;
use App\Support\SiteContent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share the site settings with every front-end view so static sections can
        // read contact info, service areas and other backend-managed content.
        View::composer('front.*', function ($view) {
            try {
                $setting = Setting::first();
                $view->with('setting', $setting);
                $view->with('siteContent', SiteContent::resolve($setting));
            } catch (\Throwable $e) {
                $view->with('setting', null);
                $view->with('siteContent', SiteContent::defaults());
            }
        });

        // Google Analytics Blade Directives
        Blade::directive('analytics', function ($expression) {
            return "<?php if(\App\Helpers\Analytics::isEnabled()): ?>";
        });

        Blade::directive('endanalytics', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('trackEvent', function ($expression) {
            return "<?php echo \App\Helpers\Analytics::trackEvent($expression); ?>";
        });

        Blade::directive('trackFormSubmission', function ($expression) {
            return "<?php echo \App\Helpers\Analytics::trackFormSubmission($expression); ?>";
        });

        Blade::directive('trackContactForm', function ($expression) {
            return "<?php echo \App\Helpers\Analytics::trackContactForm($expression ?: []); ?>";
        });

        Blade::directive('trackButtonClick', function ($expression) {
            return "<?php echo \App\Helpers\Analytics::trackButtonClick($expression); ?>";
        });
    }
}
