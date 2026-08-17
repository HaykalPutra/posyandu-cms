<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CmsPageController extends Controller
{
    private function resolveMetaImageUpload(Request $request, string $field, string $directory, ?string $currentValue = null): ?string
    {
        $mediaId = $this->storeUploadedImage($request, $field, $directory);

        if (! $mediaId) {
            return $currentValue;
        }

        return route('media.show', $mediaId);
    }

    private function defaultMetaForSlug(string $slug): array
    {
        return match ($slug) {
            'beranda' => [
                'badge' => 'Melayani Sepenuh Hati',
                'primary_cta_label' => 'Jadwal Bulan Ini',
                'primary_cta_url' => '#jadwal',
                'secondary_cta_label' => 'Pelajari Lebih Lanjut',
                'secondary_cta_url' => '#tentang',
                'stats' => [
                    ['value' => '150+', 'label' => 'Balita Terdaftar'],
                    ['value' => '12', 'label' => 'Kader Aktif'],
                    ['value' => '2x', 'label' => 'Kunjungan Bulanan'],
                    ['value' => '98%', 'label' => 'Cakupan Imunisasi'],
                ],
                'schedules' => [
                    ['type' => 'Penimbangan', 'date' => '15 Okt', 'location' => 'Balai Warga RW 03', 'time' => '08:00 - 11:00 WIB', 'accent' => 'primary'],
                    ['type' => 'Imunisasi', 'date' => '22 Okt', 'location' => 'Puskesmas Pembantu', 'time' => '09:00 - 12:00 WIB', 'accent' => 'tertiary'],
                ],
            ],
            'berita' => [
                'filter_labels' => ['Semua', 'Nutrisi', 'Imunisasi', 'Kegiatan', 'Kesehatan Ibu'],
                'featured_section_title' => 'Sorotan Utama',
                'list_section_title' => 'Artikel Terkini',
            ],
            'galeri' => [
                'filter_labels' => ['Semua Foto', 'Hari Timbang', 'Edukasi Gizi', 'Imunisasi', 'Senam Lansia'],
                'footer_note' => 'Kelola foto dari CMS Galeri',
            ],
            'dokumentasi' => [
                'gallery_section_title' => 'Dokumentasi Kegiatan',
                'gallery_section_subtitle' => 'Galeri ini mengambil data dari menu Galeri CMS.',
            ],
            'tentang' => [
                'vision_title' => 'Visi Kami',
                'vision_body' => 'Mewujudkan generasi penerus yang sehat, cerdas, dan tangguh melalui pemantauan tumbuh kembang yang terpadu, serta meningkatkan kualitas hidup lansia di lingkungan yang penuh empati dan profesionalisme yang membumi.',
                'mission_title' => 'Misi Kami',
                'mission_items' => [
                    'Menyediakan layanan kesehatan dasar yang inklusif dan berkualitas bagi seluruh lapisan masyarakat.',
                    'Memberdayakan kader Posyandu melalui pelatihan berkelanjutan untuk pelayanan yang lebih humanis.',
                ],
                'history_title' => 'Sejarah Perjalanan',
                'impact_title' => 'Jangkauan & Dampak Komunitas',
                'impact_subtitle' => 'Kehadiran kami dirancang untuk menyentuh setiap sudut lingkungan, memastikan tidak ada keluarga yang terlewat dari jaring pengaman kesehatan dasar.',
                'impact_stats' => [
                    ['value' => '500+', 'label' => 'Balita Terpantau', 'icon' => 'child_care', 'color' => 'tertiary'],
                    ['value' => '120+', 'label' => 'Ibu Hamil Didampingi', 'icon' => 'pregnant_woman', 'color' => 'primary'],
                    ['value' => '300+', 'label' => 'Lansia Aktif', 'icon' => 'elderly', 'color' => 'secondary'],
                    ['value' => '45', 'label' => 'Kader Berdedikasi', 'icon' => 'volunteer_activism', 'color' => 'primary-container'],
                ],
            ],
            'lokasi' => [
                'address' => "Jl. Kesehatan Lingkungan No. 12\nKelurahan Sehat Makmur\nKecamatan Peduli, Jakarta 12345",
                'schedule' => "Setiap Rabu pertama setiap bulan\n08:00 - 12:00 WIB",
                'phone' => '+62 812 3456 7890',
                'maps_url' => 'https://maps.google.com',
                'transport_notes' => [
                    '5 menit jalan kaki dari Halte Busway Sehat.',
                    'Tersedia area parkir untuk motor dan sepeda.',
                ],
            ],
            'struktur' => [
                'supervisor_name' => 'Puskesmas Kecamatan',
                'supervisor_role' => 'Puskesmas Pembina',
                'supervisor_badge' => 'Instansi Pembina',
                'supervisor_image' => '',
                'leader_name' => 'Ibu Siti Aminah',
                'leader_role' => 'Ketua Posyandu',
                'leader_image' => '',
                'midwife_name' => 'Bidan Rini, Amd.Keb',
                'midwife_role' => 'Bidan Desa',
                'midwife_image' => '',
                'cadres_title' => 'Tim Kader Posyandu',
                'cadres' => [
                    ['name' => 'Ibu Wati', 'role' => 'Kader Pendaftaran', 'image' => ''],
                    ['name' => 'Ibu Ningsih', 'role' => 'Kader Penimbangan', 'image' => ''],
                    ['name' => 'Ibu Yuli', 'role' => 'Kader Pencatatan', 'image' => ''],
                    ['name' => 'Ibu Ratna', 'role' => 'Kader Penyuluhan', 'image' => ''],
                ],
            ],
            default => [],
        };
    }

    private function defaultPages(): array
    {
        return [
            'beranda' => [
                'slug' => 'beranda',
                'nav_label' => 'Beranda',
                'title' => 'Posyandu Palem',
                'subtitle' => 'Layanan kesehatan ibu, anak, dan lansia yang dekat, ramah, dan terjadwal.',
                'body' => "Kami melayani pemantauan tumbuh kembang, edukasi gizi, dan kegiatan promotif lainnya.",
                'meta' => $this->defaultMetaForSlug('beranda'),
                'sort_order' => 1,
                'is_published' => true,
            ],
            'berita' => [
                'slug' => 'berita',
                'nav_label' => 'Berita',
                'title' => 'Berita dan Pengumuman',
                'subtitle' => 'Update terbaru seputar kesehatan ibu, anak, dan kegiatan Posyandu.',
                'body' => 'Kelola judul halaman berita dan isi artikel dari CMS.',
                'meta' => $this->defaultMetaForSlug('berita'),
                'sort_order' => 2,
                'is_published' => true,
            ],
            'galeri' => [
                'slug' => 'galeri',
                'nav_label' => 'Galeri',
                'title' => 'Galeri Kegiatan Posyandu',
                'subtitle' => 'Kumpulan momen pelayanan, edukasi, dan kegiatan komunitas.',
                'body' => 'Kelola judul halaman galeri dan semua foto dokumentasi dari CMS.',
                'meta' => $this->defaultMetaForSlug('galeri'),
                'sort_order' => 3,
                'is_published' => true,
            ],
            'dokumentasi' => [
                'slug' => 'dokumentasi',
                'nav_label' => 'Dokumentasi',
                'title' => 'Dokumentasi Kegiatan',
                'subtitle' => 'Rekaman kegiatan bulanan Posyandu.',
                'body' => 'Halaman dokumentasi mengambil foto dari menu galeri.',
                'meta' => $this->defaultMetaForSlug('dokumentasi'),
                'sort_order' => 4,
                'is_published' => true,
            ],
            'struktur' => [
                'slug' => 'struktur',
                'nav_label' => 'Struktur',
                'title' => 'Struktur Organisasi',
                'subtitle' => 'Tim penggerak Posyandu Palem.',
                'body' => 'Edit pengantar halaman struktur dari CMS.',
                'meta' => $this->defaultMetaForSlug('struktur'),
                'sort_order' => 5,
                'is_published' => true,
            ],
            'tentang' => [
                'slug' => 'tentang',
                'nav_label' => 'Tentang',
                'title' => 'Tentang Posyandu Palem',
                'subtitle' => 'Visi dan misi pelayanan masyarakat.',
                'body' => 'Edit deskripsi dan hero halaman tentang dari CMS.',
                'meta' => $this->defaultMetaForSlug('tentang'),
                'sort_order' => 6,
                'is_published' => true,
            ],
            'lokasi' => [
                'slug' => 'lokasi',
                'nav_label' => 'Lokasi',
                'title' => 'Lokasi dan Kontak',
                'subtitle' => 'Informasi alamat dan kontak layanan.',
                'body' => "Alamat: Jl. Palem Sehat No. 10\nKontak: 0812-0000-0000",
                'meta' => $this->defaultMetaForSlug('lokasi'),
                'sort_order' => 7,
                'is_published' => true,
            ],
        ];
    }

    private function syncDefaultPages(): void
    {
        foreach ($this->defaultPages() as $defaultPage) {
            CmsPage::updateOrCreate(
                ['slug' => $defaultPage['slug']],
                $defaultPage
            );
        }
    }

    private function pageSpecificRules(string $slug): array
    {
        return match ($slug) {
            'beranda' => [
                'meta_badge' => ['nullable', 'string', 'max:120'],
                'meta_primary_cta_label' => ['nullable', 'string', 'max:80'],
                'meta_primary_cta_url' => ['nullable', 'string', 'max:255'],
                'meta_secondary_cta_label' => ['nullable', 'string', 'max:80'],
                'meta_secondary_cta_url' => ['nullable', 'string', 'max:255'],
                'meta_stats_values' => ['nullable', 'array'],
                'meta_stats_values.*' => ['nullable', 'string', 'max:30'],
                'meta_stats_labels' => ['nullable', 'array'],
                'meta_stats_labels.*' => ['nullable', 'string', 'max:80'],
                'meta_schedule_types' => ['nullable', 'array'],
                'meta_schedule_types.*' => ['nullable', 'string', 'max:60'],
                'meta_schedule_dates' => ['nullable', 'array'],
                'meta_schedule_dates.*' => ['nullable', 'string', 'max:40'],
                'meta_schedule_locations' => ['nullable', 'array'],
                'meta_schedule_locations.*' => ['nullable', 'string', 'max:120'],
                'meta_schedule_times' => ['nullable', 'array'],
                'meta_schedule_times.*' => ['nullable', 'string', 'max:60'],
                'meta_schedule_accents' => ['nullable', 'array'],
                'meta_schedule_accents.*' => ['nullable', Rule::in(['primary', 'tertiary'])],
            ],
            'berita' => [
                'meta_filter_labels' => ['nullable', 'array'],
                'meta_filter_labels.*' => ['nullable', 'string', 'max:60'],
                'meta_featured_section_title' => ['nullable', 'string', 'max:120'],
                'meta_list_section_title' => ['nullable', 'string', 'max:120'],
            ],
            'galeri' => [
                'meta_filter_labels' => ['nullable', 'array'],
                'meta_filter_labels.*' => ['nullable', 'string', 'max:60'],
                'meta_footer_note' => ['nullable', 'string', 'max:180'],
            ],
            'dokumentasi' => [
                'meta_gallery_section_title' => ['nullable', 'string', 'max:120'],
                'meta_gallery_section_subtitle' => ['nullable', 'string', 'max:255'],
            ],
            'tentang' => [
                'meta_vision_title' => ['nullable', 'string', 'max:120'],
                'meta_vision_body' => ['nullable', 'string'],
                'meta_mission_title' => ['nullable', 'string', 'max:120'],
                'meta_mission_items' => ['nullable', 'array'],
                'meta_mission_items.*' => ['nullable', 'string', 'max:220'],
                'meta_history_title' => ['nullable', 'string', 'max:120'],
                'meta_impact_title' => ['nullable', 'string', 'max:120'],
                'meta_impact_subtitle' => ['nullable', 'string', 'max:255'],
                'meta_impact_values' => ['nullable', 'array'],
                'meta_impact_values.*' => ['nullable', 'string', 'max:30'],
                'meta_impact_labels' => ['nullable', 'array'],
                'meta_impact_labels.*' => ['nullable', 'string', 'max:80'],
                'meta_impact_icons' => ['nullable', 'array'],
                'meta_impact_icons.*' => ['nullable', 'string', 'max:60'],
                'meta_impact_colors' => ['nullable', 'array'],
                'meta_impact_colors.*' => ['nullable', 'string', 'max:60'],
            ],
            'lokasi' => [
                'meta_address' => ['nullable', 'string'],
                'meta_schedule' => ['nullable', 'string'],
                'meta_phone' => ['nullable', 'string', 'max:80'],
                'meta_maps_url' => ['nullable', 'string', 'max:255'],
                'meta_transport_notes' => ['nullable', 'array'],
                'meta_transport_notes.*' => ['nullable', 'string', 'max:180'],
            ],
            'struktur' => [
                'meta_supervisor_name' => ['nullable', 'string', 'max:120'],
                'meta_supervisor_role' => ['nullable', 'string', 'max:120'],
                'meta_supervisor_badge' => ['nullable', 'string', 'max:80'],
                'meta_supervisor_image' => ['nullable', 'string', 'max:2048'],
                'meta_supervisor_image_file' => ['nullable', 'image', 'max:4096'],
                'meta_leader_name' => ['nullable', 'string', 'max:120'],
                'meta_leader_role' => ['nullable', 'string', 'max:120'],
                'meta_leader_image' => ['nullable', 'string', 'max:2048'],
                'meta_leader_image_file' => ['nullable', 'image', 'max:4096'],
                'meta_midwife_name' => ['nullable', 'string', 'max:120'],
                'meta_midwife_role' => ['nullable', 'string', 'max:120'],
                'meta_midwife_image' => ['nullable', 'string', 'max:2048'],
                'meta_midwife_image_file' => ['nullable', 'image', 'max:4096'],
                'meta_cadres_title' => ['nullable', 'string', 'max:120'],
                'meta_cadre_names' => ['nullable', 'array'],
                'meta_cadre_names.*' => ['nullable', 'string', 'max:120'],
                'meta_cadre_roles' => ['nullable', 'array'],
                'meta_cadre_roles.*' => ['nullable', 'string', 'max:120'],
                'meta_cadre_images' => ['nullable', 'array'],
                'meta_cadre_images.*' => ['nullable', 'string', 'max:2048'],
                'meta_cadre_image_files' => ['nullable', 'array'],
                'meta_cadre_image_files.*' => ['nullable', 'image', 'max:4096'],
            ],
            default => [],
        };
    }

    private function buildMetaFromRequest(Request $request, string $slug, array $currentMeta = []): array
    {
        $meta = array_replace_recursive($this->defaultMetaForSlug($slug), $currentMeta);

        return match ($slug) {
            'beranda' => [
                'badge' => $request->input('meta_badge'),
                'primary_cta_label' => $request->input('meta_primary_cta_label'),
                'primary_cta_url' => $request->input('meta_primary_cta_url'),
                'secondary_cta_label' => $request->input('meta_secondary_cta_label'),
                'secondary_cta_url' => $request->input('meta_secondary_cta_url'),
                'stats' => collect($request->input('meta_stats_values', []))
                    ->map(function ($value, $index) use ($request) {
                        return [
                            'value' => $value,
                            'label' => $request->input('meta_stats_labels', [])[$index] ?? '',
                        ];
                    })
                    ->filter(fn (array $item) => filled($item['value']) || filled($item['label']))
                    ->values()
                    ->all(),
                'schedules' => collect($request->input('meta_schedule_types', []))
                    ->map(function ($type, $index) use ($request) {
                        return [
                            'type' => $type,
                            'date' => $request->input('meta_schedule_dates', [])[$index] ?? '',
                            'location' => $request->input('meta_schedule_locations', [])[$index] ?? '',
                            'time' => $request->input('meta_schedule_times', [])[$index] ?? '',
                            'accent' => $request->input('meta_schedule_accents', [])[$index] ?? 'primary',
                        ];
                    })
                    ->filter(fn (array $item) => filled($item['type']) || filled($item['location']))
                    ->values()
                    ->all(),
            ],
            'berita' => [
                'filter_labels' => collect($request->input('meta_filter_labels', []))->filter(fn ($item) => filled($item))->values()->all(),
                'featured_section_title' => $request->input('meta_featured_section_title'),
                'list_section_title' => $request->input('meta_list_section_title'),
            ],
            'galeri' => [
                'filter_labels' => collect($request->input('meta_filter_labels', []))->filter(fn ($item) => filled($item))->values()->all(),
                'footer_note' => $request->input('meta_footer_note'),
            ],
            'dokumentasi' => [
                'gallery_section_title' => $request->input('meta_gallery_section_title'),
                'gallery_section_subtitle' => $request->input('meta_gallery_section_subtitle'),
            ],
            'tentang' => [
                'vision_title' => $request->input('meta_vision_title'),
                'vision_body' => $request->input('meta_vision_body'),
                'mission_title' => $request->input('meta_mission_title'),
                'mission_items' => collect($request->input('meta_mission_items', []))->filter(fn ($item) => filled($item))->values()->all(),
                'history_title' => $request->input('meta_history_title'),
                'impact_title' => $request->input('meta_impact_title'),
                'impact_subtitle' => $request->input('meta_impact_subtitle'),
                'impact_stats' => collect($request->input('meta_impact_values', []))
                    ->map(function ($value, $index) use ($request) {
                        return [
                            'value' => $value,
                            'label' => $request->input('meta_impact_labels', [])[$index] ?? '',
                            'icon' => $request->input('meta_impact_icons', [])[$index] ?? 'favorite',
                            'color' => $request->input('meta_impact_colors', [])[$index] ?? 'primary',
                        ];
                    })
                    ->filter(fn (array $item) => filled($item['value']) || filled($item['label']))
                    ->values()
                    ->all(),
            ],
            'lokasi' => [
                'address' => $request->input('meta_address'),
                'schedule' => $request->input('meta_schedule'),
                'phone' => $request->input('meta_phone'),
                'maps_url' => $request->input('meta_maps_url'),
                'transport_notes' => collect($request->input('meta_transport_notes', []))
                    ->filter(fn ($item) => filled($item))
                    ->values()
                    ->all(),
            ],
            'struktur' => [
                'supervisor_image' => $this->resolveMetaImageUpload($request, 'meta_supervisor_image_file', 'cms/structure', $request->input('meta_supervisor_image')),
                'supervisor_name' => $request->input('meta_supervisor_name'),
                'supervisor_role' => $request->input('meta_supervisor_role'),
                'supervisor_badge' => $request->input('meta_supervisor_badge'),
                'leader_image' => $this->resolveMetaImageUpload($request, 'meta_leader_image_file', 'cms/structure', $request->input('meta_leader_image')),
                'leader_name' => $request->input('meta_leader_name'),
                'leader_role' => $request->input('meta_leader_role'),
                'midwife_image' => $this->resolveMetaImageUpload($request, 'meta_midwife_image_file', 'cms/structure', $request->input('meta_midwife_image')),
                'midwife_name' => $request->input('meta_midwife_name'),
                'midwife_role' => $request->input('meta_midwife_role'),
                'cadres_title' => $request->input('meta_cadres_title'),
                'cadres' => collect($request->input('meta_cadre_names', []))
                    ->map(function ($name, $index) use ($request) {
                        $uploadedFiles = $request->file('meta_cadre_image_files', []);
                        $image = $request->input('meta_cadre_images', [])[$index] ?? '';

                        if (isset($uploadedFiles[$index]) && $uploadedFiles[$index]) {
                            $image = $uploadedFiles[$index]->store('cms/structure', 'public');
                            $image = '/storage/' . $image;
                        }

                        return [
                            'name' => $name,
                            'role' => $request->input('meta_cadre_roles', [])[$index] ?? '',
                            'image' => $image,
                        ];
                    })
                    ->filter(fn (array $item) => filled($item['name']) || filled($item['role']))
                    ->values()
                    ->all(),
            ],
            default => $meta,
        };
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->syncDefaultPages();

        $pages = CmsPage::query()->orderBy('sort_order')->paginate(15);
        $defaultSlugs = array_keys($this->defaultPages());

        return view('views.cms.pages.index', compact('pages', 'defaultSlugs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $presetSlug = request('preset');
        $defaultPages = $this->defaultPages();
        $presetData = $presetSlug && isset($defaultPages[$presetSlug]) ? $defaultPages[$presetSlug] : null;

        return view('views.cms.pages.create', compact('presetData', 'defaultPages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => ['required', 'alpha_dash', 'max:100', 'unique:cms_pages,slug'],
            'nav_label' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'url', 'max:2048'],
            'hero_image_file' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ] + $this->pageSpecificRules((string) $request->input('slug')));

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($uploadedImage = $this->storeUploadedImage($request, 'hero_image_file', 'cms/pages')) {
            $validated['hero_media_asset_id'] = $uploadedImage;
            $validated['hero_image'] = null;
        }

        $validated['meta'] = $this->buildMetaFromRequest($request, $validated['slug']);

        unset($validated['hero_image_file']);

        CmsPage::create($validated);

        return redirect()->route('cms.pages.index')->with('success', 'Halaman CMS berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('cms.pages.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = CmsPage::findOrFail($id);
        return view('views.cms.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = CmsPage::findOrFail($id);

        $validated = $request->validate([
            'slug' => ['required', 'alpha_dash', 'max:100', Rule::unique('cms_pages', 'slug')->ignore($page->id)],
            'nav_label' => ['required', 'string', 'max:120'],
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'hero_image' => ['nullable', 'url', 'max:2048'],
            'hero_image_file' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_published' => ['nullable', 'boolean'],
        ] + $this->pageSpecificRules((string) $request->input('slug', $page->slug)));

        $validated['is_published'] = $request->boolean('is_published');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($uploadedImage = $this->storeUploadedImage($request, 'hero_image_file', 'cms/pages')) {
            $this->deleteDatabaseMedia($page->hero_media_asset_id);
            $validated['hero_media_asset_id'] = $uploadedImage;
            $validated['hero_image'] = null;
        }

        $validated['meta'] = $this->buildMetaFromRequest($request, $validated['slug'], $page->meta ?? []);

        unset($validated['hero_image_file']);

        $page->update($validated);

        return redirect()->route('cms.pages.index')->with('success', 'Halaman CMS berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = CmsPage::findOrFail($id);
        $this->deleteDatabaseMedia($page->hero_media_asset_id);
        $page->delete();
        return redirect()->route('cms.pages.index')->with('success', 'Halaman CMS berhasil dihapus.');
    }
}
