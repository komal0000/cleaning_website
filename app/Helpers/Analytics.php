<?php

namespace App\Helpers;

class Analytics
{
    /**
     * Check if Google Analytics is enabled
     */
    public static function isEnabled(): bool
    {
        return config('analytics.enabled', false)
            && config('analytics.measurement_id')
            && in_array(app()->environment(), config('analytics.environments', []));
    }

    /**
     * Get the measurement ID
     */
    public static function getMeasurementId(): ?string
    {
        return config('analytics.measurement_id');
    }

    /**
     * Generate a Google Analytics event tracking script
     */
    public static function trackEvent(string $eventName, array $parameters = []): string
    {
        if (!self::isEnabled()) {
            return '';
        }

        $parametersJson = json_encode($parameters);

        return "<script>
            if (typeof gtag === 'function') {
                gtag('event', '{$eventName}', {$parametersJson});
            }
        </script>";
    }

    /**
     * Generate a page view tracking script
     */
    public static function trackPageView(string $pageTitle = '', string $pagePath = ''): string
    {
        if (!self::isEnabled()) {
            return '';
        }

        $parameters = array_filter([
            'page_title' => $pageTitle,
            'page_path' => $pagePath,
        ]);

        $parametersJson = json_encode($parameters);

        return "<script>
            if (typeof gtag === 'function') {
                gtag('event', 'page_view', {$parametersJson});
            }
        </script>";
    }

    /**
     * Track form submission
     */
    public static function trackFormSubmission(string $formName, array $parameters = []): string
    {
        $defaultParameters = [
            'form_name' => $formName,
            'event_category' => 'form',
            'event_label' => $formName
        ];

        $parameters = array_merge($defaultParameters, $parameters);

        return self::trackEvent('form_submit', $parameters);
    }

    /**
     * Track contact form submission
     */
    public static function trackContactForm(array $parameters = []): string
    {
        return self::trackFormSubmission('contact_form', $parameters);
    }

    /**
     * Track button click
     */
    public static function trackButtonClick(string $buttonName, array $parameters = []): string
    {
        $defaultParameters = [
            'button_name' => $buttonName,
            'event_category' => 'button',
            'event_label' => $buttonName
        ];

        $parameters = array_merge($defaultParameters, $parameters);

        return self::trackEvent('click', $parameters);
    }
}
