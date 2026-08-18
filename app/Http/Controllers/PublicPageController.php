<?php

namespace App\Http\Controllers;

use App\Models\CarouselItem;
use App\Models\CmsPage;
use App\Models\GalleryItem;
use App\Models\HomeStat;
use App\Models\Post;
use App\Models\Schedule;

class PublicPageController extends Controller
{
    private function defaultMetaForSlug(string $slug): array
    {
        return match ($slug) {
            'beranda' => [
                'badge' => 'Melayani Sepenuh Hati',
                'primary_cta_label' => 'Jadwal Bulan Ini',
                'primary_cta_url' => '#jadwal',
                'secondary_cta_label' => 'Pelajari Lebih Lanjut',
                'secondary_cta_url' => '#tentang',
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

    private function enrichPage(?object $page, string $slug): ?object
    {
        if ($page === null) {
            return null;
        }

        $page->meta = array_replace_recursive($this->defaultMetaForSlug($slug), (array) ($page->meta ?? []));

        return $page;
    }

    public function home()
    {
        $page = $this->enrichPage($this->findPageOrFallback('beranda'), 'beranda');
        $latestPosts = Post::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        $carouselSlides = CarouselItem::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $homeStats = HomeStat::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $upcomingSchedules = Schedule::query()
            ->where('is_active', true)
            ->whereDate('schedule_date', '>=', now()->toDateString())
            ->orderBy('schedule_date')
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('views.pages.beranda', compact(
            'page',
            'latestPosts',
            'carouselSlides',
            'homeStats',
            'upcomingSchedules'
        ));
    }

    public function berita()
    {
        $page = $this->enrichPage($this->findPageOrFallback('berita'), 'berita');
        $search = trim((string) request('q', ''));

        if ($search !== '') {
            $results = Post::query()
                ->where('is_published', true)
                ->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('body', 'like', "%{$search}%");
                })
                ->orderByDesc('published_at')
                ->get();

            $featuredPosts = collect();
            $listPosts = $results;

            return view('views.pages.berita', compact('page', 'featuredPosts', 'listPosts', 'search'));
        }

        $featuredPosts = Post::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->take(2)
            ->get();

        $listPosts = Post::query()
            ->where('is_published', true)
            ->orderByDesc('published_at')
            ->skip(2)
            ->take(6)
            ->get();

        return view('views.pages.berita', compact('page', 'featuredPosts', 'listPosts', 'search'));
    }

    public function beritaShow(Post $post)
    {
        abort_unless($post->is_published, 404);

        $page = $this->enrichPage($this->findPageOrFallback('berita'), 'berita');

        $relatedPosts = Post::query()
            ->where('is_published', true)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->take(3)
            ->get();

        return view('views.pages.berita-detail', compact('page', 'post', 'relatedPosts'));
    }


    public function galeri()
    {
        $page = $this->enrichPage($this->findPageOrFallback('galeri'), 'galeri');
        $items = GalleryItem::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->take(18)
            ->get();

        return view('views.pages.galeri', compact('page', 'items'));
    }

    public function page(string $slug)
    {
        $page = $this->enrichPage($this->findPageOrFallback($slug), $slug);

        if ($page === null) {
            abort(404);
        }

        $viewMap = [
            'dokumentasi' => 'views.pages.dokumentasi',
            'struktur' => 'views.pages.struktur',
            'tentang' => 'views.pages.tentang',
            'lokasi' => 'views.pages.lokasi',
        ];

        abort_unless(isset($viewMap[$slug]), 404);

        $data = ['page' => $page];

        if ($slug === 'dokumentasi') {
            $data['galleryItems'] = GalleryItem::query()
                ->orderByDesc('is_featured')
                ->orderBy('sort_order')
                ->take(12)
                ->get();
        }

        return view($viewMap[$slug], $data);
    }

    private function findPageOrFallback(string $slug)
    {
        $page = CmsPage::query()->where('slug', $slug)->first();

        if ($page) {
            return $page;
        }

        $defaults = [
            'beranda' => [
                'title' => 'Posyandu Palem',
                'subtitle' => 'Layanan kesehatan ibu, bayi, balita, dan lansia yang hangat, terjadwal, dan dekat dengan warga.',
                'body' => "Selamat datang di Posyandu Palem.\\nKami fokus pada edukasi gizi, pemantauan tumbuh kembang, dan aktivitas promotif rutin.",
            ],
            'berita' => [
                'title' => 'Berita dan Pengumuman',
                'subtitle' => 'Informasi kegiatan terbaru, jadwal layanan, dan edukasi kesehatan keluarga.',
                'body' => 'Gunakan CMS untuk memperbarui artikel berita kapan saja.',
            ],
            'galeri' => [
                'title' => 'Galeri Kegiatan Posyandu',
                'subtitle' => 'Kumpulan momen pelayanan, edukasi, dan kegiatan komunitas.',
                'body' => 'Gunakan CMS untuk menambah dan mengatur foto galeri.',
            ],
            'dokumentasi' => [
                'title' => 'Dokumentasi Kegiatan',
                'subtitle' => 'Catatan aktivitas Posyandu setiap bulan.',
                'body' => "Halaman ini akan menampilkan ringkasan dokumentasi kegiatan dari CMS.",
            ],
            'struktur' => [
                'title' => 'Struktur Organisasi',
                'subtitle' => 'Kader dan pengurus yang mengelola layanan Posyandu.',
                'body' => "Informasi struktur organisasi dapat diperbarui melalui CMS.",
            ],
            'tentang' => [
                'title' => 'Tentang Posyandu',
                'subtitle' => 'Profil dan semangat pelayanan Posyandu Palem.',
                'body' => "Posyandu Palem berkomitmen memberikan layanan preventif dan promotif berbasis komunitas.",
            ],
            'lokasi' => [
                'title' => 'Lokasi dan Kontak',
                'subtitle' => 'Temukan lokasi pelayanan serta kanal komunikasi kami.',
                'body' => "Alamat: Jl. Palem Sehat No. 10\\nKontak: 0812-0000-0000", 
            ],
        ];

        if (! isset($defaults[$slug])) {
            return null;
        }

        return (object) array_merge(['slug' => $slug, 'hero_image' => null, 'meta' => $this->defaultMetaForSlug($slug)], $defaults[$slug]);
    }
}
