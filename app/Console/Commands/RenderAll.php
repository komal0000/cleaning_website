<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RenderAll extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'render:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Public components render dynamically; no Blade files were generated.');

        return self::SUCCESS;

        $services = \App\Models\Service::all();
        $teams = \App\Models\Team::all();
        $galleries = \App\Models\Gallery::all();
        $testimonials = \App\Models\Testi::all();
        $careers = \App\Models\Career::all();

        $setting = \App\Models\Setting::first();

        file_put_contents(resource_path('views/front/components/career/main.blade.php'), view('admin.template.careers', compact('careers'))->render());

        file_put_contents(resource_path('views/front/components/contact/form.blade.php'), view('admin.template.contact.form', compact('services'))->render());

        file_put_contents(resource_path('views/front/components/footer/services.blade.php'), view('admin.template.footer.services', compact('services'))->render());

        // start setting
        // header
        file_put_contents(resource_path('views/front/components/header/title.blade.php'), view('admin.template.headertitle', compact('setting'))->render());
        file_put_contents(resource_path('views/front/components/header/top.blade.php'), view('admin.template.headertop', compact('setting'))->render());
        file_put_contents(resource_path('views/front/components/header/logo.blade.php'), view('admin.template.headerlogo', compact('setting'))->render());
        file_put_contents(resource_path('views/front/components/header/meta.blade.php'), view('admin.template.headermeta', compact('setting'))->render());
        // home
        file_put_contents(resource_path('views/front/components/home/header.blade.php'), view('admin.template.home.header', compact('setting'))->render());
        file_put_contents(resource_path('views/front/components/home/youtube.blade.php'), view('admin.template.home.youtube', compact('setting'))->render());
        // home hero (new design)
        file_put_contents(resource_path('views/front/components/hero.blade.php'), view('admin.template.home.hero', compact('setting', 'services'))->render());
        // about page (new design)
        $aboutData = $setting && $setting->about ? json_decode($setting->about, true) : [];
        file_put_contents(resource_path('views/front/components/about/main.blade.php'), view('admin.template.about.main', compact('aboutData', 'setting'))->render());
        file_put_contents(resource_path('views/front/components/about/story.blade.php'), view('admin.template.about.story', compact('aboutData', 'setting'))->render());
        file_put_contents(resource_path('views/front/components/about/values.blade.php'), view('admin.template.about.values', compact('aboutData', 'setting'))->render());
        // team
        $teamSetting = [
            'title1' => 'Meet Our Professional Team',
            'subtitle1' => 'We are a team of professionals who are passionate about what we do.',
            'title2' => 'Welcome to Cleanway Service Limited',
            'subtitle2' => 'At Cleanway Service Limited, we are dedicated to providing top-tier cleaning services that cater to both residential and commercial clients. Our experienced team ensures that every space we service is left spotless, hygienic, and welcoming.',
            'service_area' => 'Proudly serving Auckland & Christchurch with comprehensive cleaning solutions',
            'expert_team' => 'Trained professionals committed to excellence in every cleaning project',
        ];
        if ($setting && $setting->team && $setting->team != '') {
            $teamSetting = json_decode($setting->team, true);
        }
        file_put_contents(resource_path('views/front/components/team/header.blade.php'), view('admin.template.team.header', (['aboutSetting' => $teamSetting]))->render());
        // contact page is live/dynamic — reads settings at request time, so nothing is baked here
        // serviceareas

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

        file_put_contents(
            resource_path('views/front/components/services/areas.blade.php'),
            view('admin.template.services.areas', compact('serviceAreas'))->render()
        );

        file_put_contents(
            resource_path('views/front/components/services/promise.blade.php'),
            view('admin.template.services.promise', compact('ourPromise'))->render()
        );

    }
}
