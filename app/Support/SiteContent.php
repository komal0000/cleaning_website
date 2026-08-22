<?php

namespace App\Support;

use App\Models\Setting;

class SiteContent
{
    public const NAVIGATION_ROUTES = [
        'home', 'services', 'about', 'team', 'gallery', 'career', 'testimonials', 'contact',
    ];

    public static function resolve(?Setting $setting): array
    {
        $content = self::merge(self::defaults(), (array) ($setting?->site_content ?? []));

        $content['global']['utility']['phones'] = self::split($setting?->contact_phone)
            ?: $content['global']['utility']['phones'];
        $content['global']['utility']['email'] = filled($setting?->contact_email)
            ? trim(explode('|', $setting->contact_email)[0])
            : $content['global']['utility']['email'];
        $content['global']['footer']['facebook_url'] = $setting?->contact_facebook
            ?: $content['global']['footer']['facebook_url'];

        if (is_array($setting?->statistics) && count($setting->statistics)) {
            $content['home']['statistics'] = array_values(array_filter($setting->statistics, fn ($stat) => filled($stat['title'] ?? null)));
        }

        self::overlayPageSettings($content, $setting);

        $content['global']['navigation'] = array_values(array_filter(
            $content['global']['navigation'],
            fn ($item) => in_array($item['route'] ?? null, self::NAVIGATION_ROUTES, true)
        ));

        return $content;
    }

    public static function defaults(): array
    {
        return [
            'global' => [
                'utility' => [
                    'phones' => ['0800 253 929', '021 562281', '021 2762020'],
                    'email' => 'sales@cleanway.co.nz',
                    'emergency_message' => 'Available 24/7 for Emergency Cleaning',
                ],
                'navigation' => [
                    ['route' => 'home', 'label' => 'Home', 'visible' => true],
                    ['route' => 'services', 'label' => 'Services', 'visible' => true],
                    ['route' => 'about', 'label' => 'About', 'visible' => true],
                    ['route' => 'team', 'label' => 'Team', 'visible' => true],
                    ['route' => 'gallery', 'label' => 'Gallery', 'visible' => true],
                    ['route' => 'career', 'label' => 'Career', 'visible' => true],
                    ['route' => 'testimonials', 'label' => 'Testimonials', 'visible' => true],
                    ['route' => 'contact', 'label' => 'Contact', 'visible' => true],
                ],
                'quote_cta' => ['label' => 'Get a quote', 'route' => 'contact'],
                'footer' => [
                    'eyebrow' => 'Your space, reset',
                    'title' => 'Ready to walk into better?',
                    'description' => 'Tell us what needs cleaning and your local team will take it from there.',
                    'brand_description' => 'Thoughtful cleaning for homes, workplaces and stays across four New Zealand regions.',
                    'facebook_url' => 'https://www.facebook.com/profile.php?id=100090206349338',
                ],
            ],
            'home' => [
                'eyebrow' => 'Home & commercial cleaning across New Zealand',
                'title' => 'Clean spaces.|Clear minds.',
                'description' => 'Reliable home and commercial cleaning across Auckland, Hamilton, Palmerston North and Christchurch — shaped around your space, schedule and priorities.',
                'hero_image' => 'images/cleanway/home-cleaning-glass-hero.jpg',
                'hero_image_alt' => 'Cleanway team member cleaning a commercial glass surface',
                'hero_caption_label' => 'Cleanway at work',
                'hero_caption' => 'Prepared for the spaces you rely on.',
                'quote' => [
                    'eyebrow' => 'Start with the essentials',
                    'title' => 'Find the right clean in under a minute.',
                    'space_options' => ['Home', 'Business', 'Airbnb / stay', 'Other'],
                    'continue_label' => 'Continue',
                ],
                'statistics' => [
                    ['title' => '5-Star', 'subtitle' => 'Rating'],
                    ['title' => 'Certified', 'subtitle' => 'Professionals'],
                    ['title' => '500+', 'subtitle' => 'Satisfied Customers'],
                    ['title' => '24/7', 'subtitle' => 'Available'],
                ],
                'locations' => ['Auckland', 'Hamilton', 'Palmerston North', 'Christchurch'],
            ],
            'pages' => [
                'services' => [
                    'eyebrow' => 'Services shaped around real spaces',
                    'title' => 'The right clean for the moment.',
                    'description' => 'Start with your space, then choose the level of care you need. We’ll use your quote details to help shape the scope and timing.',
                    'image' => 'images/cleanway/team-facility-cleaning.jpg',
                    'promises' => [],
                    'areas' => [],
                ],
                'about' => [
                    'eyebrow' => 'Calm. Local. Precise. Human.',
                    'title' => 'Why Choose Cleanway Service?',
                    'description' => 'After 15 years of experience, Cleanway’s leadership team formed Cleanway Services in 2021 and built a reputation for exceptional results and customer service.',
                    'image' => 'images/cleanway/team-facility-cleaning.jpg',
                    'story' => [
                        'title' => 'Our Story & Mission',
                        'subtitle' => 'The Clean Reveal',
                        'paragraph1' => 'Founded in 2021, Cleanway Service Limited began with a simple mission: to provide exceptional cleaning services that exceed our clients\' expectations. What started as a small local business has grown into New Zealand\'s trusted cleaning partner.',
                        'paragraph2' => 'Our founder, Bipan Bhandari, recognized the need for reliable, professional cleaning services that prioritized both quality and environmental responsibility. This vision has guided our company\'s growth and continues to drive our commitment to excellence.',
                        'paragraph3' => '',
                    ],
                    'values' => [
                        ['title' => 'Customer First', 'description' => 'Your satisfaction is our top priority in everything we do.', 'icon' => 'heart'],
                        ['title' => 'Excellence', 'description' => 'We strive for perfection in every cleaning task.', 'icon' => 'award'],
                        ['title' => 'Integrity', 'description' => 'Honest, reliable service you can trust.', 'icon' => 'shield'],
                        ['title' => 'Sustainability', 'description' => 'Eco-friendly practices that protect our environment.', 'icon' => 'leaf'],
                    ],
                    'stats' => [],
                    'features' => [],
                ],
                'team' => ['eyebrow' => 'People behind the clean', 'title' => 'Meet Our Team', 'description' => 'We are a team of professionals who are passionate about what we do.'],
                'gallery' => ['eyebrow' => 'Proof over promises', 'title' => 'Real cleaning results, with the context kept intact.', 'description' => 'Every published story keeps the before, after, service and location context together so the transformation stays credible.'],
                'career' => ['eyebrow' => 'Join Cleanway', 'title' => 'Work that leaves every space better.', 'description' => 'Explore roles currently published by Cleanway, then apply with the details that help the team review your interest.'],
                'testimonials' => [
                    'eyebrow' => 'In our clients’ words',
                    'title' => 'Useful proof has context.',
                    'description' => 'Feedback is shown with the client name, role and service information currently available.',
                    'cta_title' => 'Ready to create your own result?',
                    'cta_description' => 'Your space, reset',
                    'cta_button_text' => 'Start my quote',
                    'show_cta' => true,
                ],
                'contact' => ['eyebrow' => 'Talk to Cleanway', 'title' => 'Let’s make the next step simple.', 'description' => 'Tell us what you need and the right local team will take it from there.'],
                '404' => ['title' => 'This page has moved on.', 'description' => 'Let’s get you back to a space that makes sense.'],
            ],
        ];
    }

    private static function merge(array $defaults, array $content): array
    {
        if (array_is_list($defaults) || array_is_list($content)) {
            return $content ?: $defaults;
        }

        foreach ($content as $key => $value) {
            if (! array_key_exists($key, $defaults)) {
                continue;
            }

            $defaults[$key] = is_array($value) && is_array($defaults[$key])
                ? self::merge($defaults[$key], $value)
                : ($value === false || filled($value) ? $value : $defaults[$key]);
        }

        return $defaults;
    }

    private static function overlayPageSettings(array &$content, ?Setting $setting): void
    {
        if (! $setting) {
            return;
        }

        if (filled($setting->home_title)) {
            $content['home']['title'] = trim(strip_tags($setting->home_title));
        }

        if (filled($setting->home_subtitle)) {
            $content['home']['subtitle'] = trim($setting->home_subtitle);
        }

        if (filled($setting->home_description)) {
            $content['home']['description'] = $setting->home_description;
        }

        $areas = self::normalizedServiceAreas($setting->service_areas);
        if ($areas) {
            $content['home']['locations'] = array_column($areas, 'name');
            $content['pages']['services']['areas'] = $areas;
        }

        $promises = self::jsonColumn($setting->our_promise);
        if ($promises) {
            $content['pages']['services']['promises'] = array_values($promises);
        }

        $about = self::jsonColumn($setting->about);
        if ($about) {
            if (filled($about['hero_title'] ?? null)) {
                $content['pages']['about']['title'] = $about['hero_title'];
            }
            if (filled($about['hero_subtitle'] ?? null)) {
                $content['pages']['about']['description'] = $about['hero_subtitle'];
            }
            if (isset($about['story']) && is_array($about['story'])) {
                $content['pages']['about']['story'] = array_merge(
                    $content['pages']['about']['story'] ?? [],
                    $about['story']
                );
            }
            foreach (['values', 'stats', 'features'] as $listKey) {
                if (isset($about[$listKey]) && is_array($about[$listKey])) {
                    $content['pages']['about'][$listKey] = array_values($about[$listKey]);
                }
            }
        }

        if ($setting->use_image_in_about && is_array($setting->about_image_list) && filled($setting->about_image_list[0] ?? null)) {
            $content['pages']['about']['image'] = ltrim((string) $setting->about_image_list[0], '/');
        }

        $team = self::jsonColumn($setting->team);
        if ($team) {
            if (filled($team['title1'] ?? null)) {
                $content['pages']['team']['title'] = $team['title1'];
            }
            if (filled($team['subtitle1'] ?? null)) {
                $content['pages']['team']['description'] = $team['subtitle1'];
            }
        }

        $testimonials = is_array($setting->testimonials) ? $setting->testimonials : self::jsonColumn($setting->testimonials);
        if ($testimonials) {
            $title = trim(($testimonials['main_title'] ?? '').' '.($testimonials['main_title_highlight'] ?? ''));
            if (filled($title)) {
                $content['pages']['testimonials']['title'] = $title;
            }
            if (filled($testimonials['subtitle'] ?? null)) {
                $content['pages']['testimonials']['description'] = $testimonials['subtitle'];
            }
            foreach (['cta_title', 'cta_description', 'cta_button_text'] as $key) {
                if (filled($testimonials[$key] ?? null)) {
                    $content['pages']['testimonials'][$key] = $testimonials[$key];
                }
            }
            if (array_key_exists('show_cta', $testimonials)) {
                $content['pages']['testimonials']['show_cta'] = (bool) $testimonials['show_cta'];
            }
        }
    }

    public static function publicUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        $path = trim($path);

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }

    public static function youtubeEmbedUrl(?string $url): ?string
    {
        if (! filled($url)) {
            return null;
        }

        $url = trim($url);

        if (preg_match('#(?:youtube\.com/embed/|youtube-nocookie\.com/embed/)([A-Za-z0-9_-]+)#i', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        if (preg_match('#(?:youtu\.be/|youtube\.com/(?:shorts/|live/))([A-Za-z0-9_-]+)#i', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

        if (filled($query['v'] ?? null)) {
            return 'https://www.youtube.com/embed/'.preg_replace('/[^A-Za-z0-9_-]/', '', (string) $query['v']);
        }

        return null;
    }

    public static function mapEmbedSrc(?string $value): ?string
    {
        if (! filled($value)) {
            return null;
        }

        $value = trim($value);

        if (preg_match('/src=["\']([^"\']+)["\']/i', $value, $matches)) {
            $value = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5);
        }

        if (! preg_match('#^https?://#i', $value)) {
            return null;
        }

        return $value;
    }

    private static function normalizedServiceAreas(mixed $value): array
    {
        $areas = [];

        foreach (self::jsonColumn($value) as $area) {
            $name = is_array($area) ? trim((string) ($area['name'] ?? '')) : trim((string) $area);

            if ($name === '') {
                continue;
            }

            $areas[] = [
                'name' => $name,
                'description' => is_array($area) ? trim((string) ($area['description'] ?? '')) : '',
            ];
        }

        return $areas;
    }

    private static function jsonColumn(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    private static function split(?string $value): array
    {
        return array_values(array_filter(array_map('trim', explode('|', (string) $value))));
    }
}
