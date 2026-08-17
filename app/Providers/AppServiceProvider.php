<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view): void {
            static $sharedSettings = null;

            if ($sharedSettings === null) {
                try {
                    $sharedSettings = SiteSetting::query()->pluck('value', 'key')->toArray();
                } catch (\Throwable) {
                    $sharedSettings = [];
                }
            }

            $defaults = [
                'site_name' => 'Posyandu Kita',
                'site_tagline' => 'Nurturing Professionalism for a Healthier Community. Kami hadir untuk melayani dengan empati dan dedikasi.',
                'contact_address' => 'Jl. Sehat Bersama No. 10, Jakarta Raya',
                'contact_email' => 'halo@posyandukita.id',
                'contact_phone' => '0812-3456-7890',
                'whatsapp_number' => '6281234567890',
                'whatsapp_message' => 'Halo Posyandu Kita, saya ingin bertanya.',
                'footer_copyright' => '© 2024 Posyandu Kita.',
                'logo_media_asset_id' => null,
            ];

            $view->with('siteSettings', array_merge($defaults, $sharedSettings));
        });
    }
}
