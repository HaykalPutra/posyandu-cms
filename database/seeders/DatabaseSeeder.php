<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\GalleryItem;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@posyandu.local'],
            [
                'name' => 'Admin Posyandu',
                'username' => 'admin',
                'password' => 'admin123',
                'is_admin' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'username' => 'testuser', 'password' => 'password', 'is_admin' => false]
        );

        $pages = [
            ['slug' => 'beranda', 'nav_label' => 'Beranda', 'title' => 'Posyandu Palem', 'subtitle' => 'Layanan kesehatan ibu, anak, dan lansia yang dekat, ramah, dan terjadwal.', 'body' => "Kami melayani pemantauan tumbuh kembang, edukasi gizi, dan kegiatan promotif lainnya.", 'hero_image' => 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1400&q=80', 'sort_order' => 1, 'is_published' => true],
            ['slug' => 'berita', 'nav_label' => 'Berita', 'title' => 'Berita dan Pengumuman', 'subtitle' => 'Update terbaru seputar kesehatan ibu, anak, dan kegiatan Posyandu.', 'body' => 'Gunakan menu Berita di CMS untuk menambah, mengedit, dan menghapus artikel.', 'sort_order' => 2, 'is_published' => true],
            ['slug' => 'galeri', 'nav_label' => 'Galeri', 'title' => 'Galeri Kegiatan Posyandu', 'subtitle' => 'Kumpulan momen pelayanan, edukasi, dan kegiatan komunitas.', 'body' => 'Semua foto bisa dikelola dari menu Galeri di CMS.', 'sort_order' => 3, 'is_published' => true],
            ['slug' => 'dokumentasi', 'nav_label' => 'Dokumentasi', 'title' => 'Dokumentasi Kegiatan', 'subtitle' => 'Rekaman kegiatan bulanan Posyandu.', 'body' => "Dokumentasi kegiatan diperbarui rutin oleh tim kader.", 'sort_order' => 4, 'is_published' => true],
            ['slug' => 'struktur', 'nav_label' => 'Struktur', 'title' => 'Struktur Organisasi', 'subtitle' => 'Tim penggerak Posyandu Palem.', 'body' => "Ketua, sekretaris, bendahara, dan kader lapangan bekerja kolaboratif.", 'sort_order' => 5, 'is_published' => true],
            ['slug' => 'tentang', 'nav_label' => 'Tentang', 'title' => 'Tentang Posyandu Palem', 'subtitle' => 'Visi dan misi pelayanan masyarakat.', 'body' => "Visi kami membangun generasi sehat lewat pencegahan, edukasi, dan pendampingan.", 'sort_order' => 6, 'is_published' => true],
            ['slug' => 'lokasi', 'nav_label' => 'Lokasi', 'title' => 'Lokasi dan Kontak', 'subtitle' => 'Informasi alamat dan kontak layanan.', 'body' => "Alamat: Jl. Palem Sehat No. 10\nKontak: 0812-0000-0000", 'sort_order' => 7, 'is_published' => true],
        ];

        foreach ($pages as $page) {
            CmsPage::updateOrCreate(['slug' => $page['slug']], $page);
        }

        $posts = [
            ['title' => 'Jadwal Penimbangan Bulan Ini', 'slug' => 'jadwal-penimbangan-bulan-ini', 'category' => 'Pengumuman', 'excerpt' => 'Informasi jadwal penimbangan untuk balita dan konsultasi ibu hamil.', 'body' => 'Penimbangan rutin dilaksanakan pekan kedua dan keempat setiap bulan.', 'is_published' => true, 'published_at' => now()->subDays(6)],
            ['title' => 'Penyuluhan Gizi Keluarga', 'slug' => 'penyuluhan-gizi-keluarga', 'category' => 'Edukasi', 'excerpt' => 'Materi menu bergizi seimbang untuk keluarga.', 'body' => 'Tim kader membagikan panduan menu sehat dengan bahan lokal terjangkau.', 'is_published' => true, 'published_at' => now()->subDays(3)],
            ['title' => 'Imunisasi Dasar Lengkap', 'slug' => 'imunisasi-dasar-lengkap', 'category' => 'Kesehatan Anak', 'excerpt' => 'Pentingnya imunisasi tepat waktu untuk mencegah penyakit.', 'body' => 'Pastikan buku KIA dibawa saat pelayanan imunisasi.', 'is_published' => true, 'published_at' => now()->subDay()],
        ];

        foreach ($posts as $post) {
            Post::updateOrCreate(['slug' => $post['slug']], $post);
        }

        $gallery = [
            ['title' => 'Kelas Ibu Hamil', 'description' => 'Sesi edukasi mingguan bersama bidan.', 'image_url' => 'https://images.unsplash.com/photo-1551190822-a9333d879b1f?auto=format&fit=crop&w=1200&q=80', 'is_featured' => true, 'sort_order' => 1, 'captured_at' => now()->subWeeks(2)],
            ['title' => 'Pemeriksaan Balita', 'description' => 'Layanan timbang dan ukur rutin.', 'image_url' => 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80', 'is_featured' => true, 'sort_order' => 2, 'captured_at' => now()->subWeeks(1)],
            ['title' => 'Senam Lansia', 'description' => 'Aktivitas fisik ringan untuk kebugaran warga.', 'image_url' => 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=1200&q=80', 'is_featured' => false, 'sort_order' => 3, 'captured_at' => now()->subDays(4)],
        ];

        foreach ($gallery as $item) {
            GalleryItem::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
