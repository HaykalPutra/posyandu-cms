<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    private function defaults(): array
    {
        return [
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
    }

    private function ensureDefaults(): void
    {
        foreach ($this->defaults() as $key => $value) {
            SiteSetting::firstOrCreate(['key' => $key], ['value' => $value, 'type' => 'text']);
        }
    }

    public function edit()
    {
        $this->ensureDefaults();

        $settings = SiteSetting::query()->pluck('value', 'key')->toArray();

        return view('views.cms.settings.edit', [
            'settings' => array_merge($this->defaults(), $settings),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'site_tagline' => ['nullable', 'string', 'max:255'],
            'contact_address' => ['nullable', 'string'],
            'contact_email' => ['nullable', 'email', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:80'],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'whatsapp_message' => ['nullable', 'string', 'max:255'],
            'footer_copyright' => ['nullable', 'string', 'max:120'],
            'logo_file' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($logoId = $this->storeUploadedImage($request, 'logo_file', 'cms/logo')) {
            $validated['logo_media_asset_id'] = $logoId;
        }

        foreach ($validated as $key => $value) {
            if ($key === 'logo_file') {
                continue;
            }

            SiteSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'text']
            );
        }

        return redirect()->route('cms.settings.edit')->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
