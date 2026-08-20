-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2026 at 08:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `posyandu_palem`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `nav_label` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `hero_media_asset_id` bigint(20) UNSIGNED DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `slug`, `nav_label`, `title`, `subtitle`, `body`, `hero_image`, `hero_media_asset_id`, `meta`, `is_published`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'beranda', 'Beranda', 'Posyandu Palem', 'Layanan kesehatan ibu, anak, dan lansia yang dekat, ramah, dan terjadwal.', 'Kami melayani pemantauan tumbuh kembang, edukasi gizi, dan kegiatan promotif lainnya.', 'https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=1400&q=80', NULL, '{\"badge\":\"Melayani Sepenuh Hati\",\"primary_cta_label\":\"Jadwal Bulan Ini\",\"primary_cta_url\":\"#jadwal\",\"secondary_cta_label\":\"Pelajari Lebih Lanjut\",\"secondary_cta_url\":\"#tentang\",\"stats\":[{\"value\":\"150+\",\"label\":\"Balita Terdaftar\"},{\"value\":\"12\",\"label\":\"Kader Aktif\"},{\"value\":\"2x\",\"label\":\"Kunjungan Bulanan\"},{\"value\":\"98%\",\"label\":\"Cakupan Imunisasi\"}],\"schedules\":[{\"type\":\"Penimbangan\",\"date\":\"15 Okt\",\"location\":\"Balai Warga RW 03\",\"time\":\"08:00 - 11:00 WIB\",\"accent\":\"primary\"},{\"type\":\"Imunisasi\",\"date\":\"22 Okt\",\"location\":\"Puskesmas Pembantu\",\"time\":\"09:00 - 12:00 WIB\",\"accent\":\"tertiary\"}]}', 1, 1, '2026-08-12 21:16:54', '2026-08-12 21:57:26'),
(2, 'berita', 'Berita', 'Berita dan Pengumuman', 'Update terbaru seputar kesehatan ibu, anak, dan kegiatan Posyandu.', 'Kelola judul halaman berita dan isi artikel dari CMS.', NULL, NULL, '{\"filter_labels\":[\"Semua\",\"Nutrisi\",\"Imunisasi\",\"Kegiatan\",\"Kesehatan Ibu\"],\"featured_section_title\":\"Sorotan Utama\",\"list_section_title\":\"Artikel Terkini\"}', 1, 2, '2026-08-12 21:16:54', '2026-08-12 21:57:26'),
(3, 'galeri', 'Galeri', 'Galeri Kegiatan Posyandu', 'Kumpulan momen pelayanan, edukasi, dan kegiatan komunitas.', 'Kelola judul halaman galeri dan semua foto dokumentasi dari CMS.', NULL, NULL, '{\"filter_labels\":[\"Semua Foto\",\"Hari Timbang\",\"Edukasi Gizi\",\"Imunisasi\",\"Senam Lansia\"],\"footer_note\":\"Kelola foto dari CMS Galeri\"}', 1, 3, '2026-08-12 21:16:54', '2026-08-12 21:57:26'),
(4, 'dokumentasi', 'Dokumentasi', 'Dokumentasi Kegiatan', 'Rekaman kegiatan bulanan Posyandu.', 'Halaman dokumentasi mengambil foto dari menu galeri.', NULL, NULL, '{\"gallery_section_title\":\"Dokumentasi Kegiatan\",\"gallery_section_subtitle\":\"Galeri ini mengambil data dari menu Galeri CMS.\"}', 1, 4, '2026-08-12 21:16:54', '2026-08-12 21:57:26'),
(5, 'struktur', 'Struktur', 'Struktur Organisasi', 'Tim penggerak Posyandu Palem.', 'Edit pengantar halaman struktur dari CMS.', NULL, NULL, '{\"supervisor_name\":\"Puskesmas Kecamatan\",\"supervisor_role\":\"Puskesmas Pembina\",\"supervisor_badge\":\"Instansi Pembina\",\"supervisor_image\":\"\",\"leader_name\":\"Ibu Siti Aminah\",\"leader_role\":\"Ketua Posyandu\",\"leader_image\":\"\",\"midwife_name\":\"Bidan Rini, Amd.Keb\",\"midwife_role\":\"Bidan Desa\",\"midwife_image\":\"\",\"cadres_title\":\"Tim Kader Posyandu\",\"cadres\":[{\"name\":\"Ibu Wati\",\"role\":\"Kader Pendaftaran\",\"image\":\"\"},{\"name\":\"Ibu Ningsih\",\"role\":\"Kader Penimbangan\",\"image\":\"\"},{\"name\":\"Ibu Yuli\",\"role\":\"Kader Pencatatan\",\"image\":\"\"},{\"name\":\"Ibu Ratna\",\"role\":\"Kader Penyuluhan\",\"image\":\"\"}]}', 1, 5, '2026-08-12 21:16:54', '2026-08-12 21:57:26'),
(6, 'tentang', 'Tentang', 'Tentang Posyandu Palem', 'Visi dan misi pelayanan masyarakat.', 'Edit deskripsi dan hero halaman tentang dari CMS.', NULL, NULL, '{\"vision_title\":\"Visi Kami\",\"vision_body\":\"Mewujudkan generasi penerus yang sehat, cerdas, dan tangguh melalui pemantauan tumbuh kembang yang terpadu, serta meningkatkan kualitas hidup lansia di lingkungan yang penuh empati dan profesionalisme yang membumi.\",\"mission_title\":\"Misi Kami\",\"mission_items\":[\"Menyediakan layanan kesehatan dasar yang inklusif dan berkualitas bagi seluruh lapisan masyarakat.\",\"Memberdayakan kader Posyandu melalui pelatihan berkelanjutan untuk pelayanan yang lebih humanis.\"],\"history_title\":\"Sejarah Perjalanan\",\"impact_title\":\"Jangkauan & Dampak Komunitas\",\"impact_subtitle\":\"Kehadiran kami dirancang untuk menyentuh setiap sudut lingkungan, memastikan tidak ada keluarga yang terlewat dari jaring pengaman kesehatan dasar.\",\"impact_stats\":[{\"value\":\"500+\",\"label\":\"Balita Terpantau\",\"icon\":\"child_care\",\"color\":\"tertiary\"},{\"value\":\"120+\",\"label\":\"Ibu Hamil Didampingi\",\"icon\":\"pregnant_woman\",\"color\":\"primary\"},{\"value\":\"300+\",\"label\":\"Lansia Aktif\",\"icon\":\"elderly\",\"color\":\"secondary\"},{\"value\":\"45\",\"label\":\"Kader Berdedikasi\",\"icon\":\"volunteer_activism\",\"color\":\"primary-container\"}]}', 1, 6, '2026-08-12 21:16:54', '2026-08-12 21:57:26'),
(7, 'lokasi', 'Lokasi', 'Lokasi dan Kontak', 'Informasi alamat dan kontak layanan.', 'Alamat: Jl. Palem Sehat No. 10\nKontak: 0812-0000-0000', NULL, NULL, '{\"address\":\"Jl. Kesehatan Lingkungan No. 12\\nKelurahan Sehat Makmur\\nKecamatan Peduli, Jakarta 12345\",\"schedule\":\"Setiap Rabu pertama setiap bulan\\n08:00 - 12:00 WIB\",\"phone\":\"+62 812 3456 7890\",\"maps_url\":\"https:\\/\\/maps.google.com\",\"transport_notes\":[\"5 menit jalan kaki dari Halte Busway Sehat.\",\"Tersedia area parkir untuk motor dan sepeda.\"]}', 1, 7, '2026-08-12 21:16:54', '2026-08-12 21:57:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_items`
--

CREATE TABLE `gallery_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `image_media_asset_id` bigint(20) UNSIGNED DEFAULT NULL,
  `captured_at` date DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_items`
--

INSERT INTO `gallery_items` (`id`, `title`, `description`, `image_url`, `image_media_asset_id`, `captured_at`, `is_featured`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Kelas Ibu Hamil', 'Sesi edukasi mingguan bersama bidan.', 'https://images.unsplash.com/photo-1551190822-a9333d879b1f?auto=format&fit=crop&w=1200&q=80', NULL, '2026-07-30', 1, 1, '2026-08-12 21:16:55', '2026-08-12 21:27:04'),
(2, 'Pemeriksaan Balita', 'Layanan timbang dan ukur rutin.', 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80', NULL, '2026-08-06', 1, 2, '2026-08-12 21:16:55', '2026-08-12 21:27:04'),
(3, 'Senam Lansia', 'Aktivitas fisik ringan untuk kebugaran warga.', 'https://images.unsplash.com/photo-1518611012118-696072aa579a?auto=format&fit=crop&w=1200&q=80', NULL, '2026-08-09', 0, 3, '2026-08-12 21:16:55', '2026-08-12 21:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media_assets`
--

CREATE TABLE `media_assets` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `disk_name` varchar(255) NOT NULL,
  `original_name` varchar(255) DEFAULT NULL,
  `mime_type` varchar(120) NOT NULL,
  `size` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `binary_data` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_08_13_000812_create_cms_pages_table', 2),
(5, '2026_08_13_000812_create_posts_table', 2),
(6, '2026_08_13_000813_create_gallery_items_table', 2),
(7, '2026_08_13_020000_add_is_admin_to_users_table', 3),
(8, '2026_08_13_030000_add_username_to_users_table', 4),
(9, '2026_08_13_040000_add_meta_to_cms_pages_table', 5),
(10, '2026_08_13_044750_create_site_settings_table', 6),
(11, '2026_08_13_050000_create_media_assets_table', 7),
(12, '2026_08_13_050001_add_media_asset_refs', 7);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `excerpt` text DEFAULT NULL,
  `body` longtext NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `cover_media_asset_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT 1,
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `category`, `excerpt`, `body`, `cover_image`, `cover_media_asset_id`, `is_published`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 'Jadwal Penimbangan Bulan Ini', 'jadwal-penimbangan-bulan-ini', 'Pengumuman', 'Informasi jadwal penimbangan untuk balita dan konsultasi ibu hamil.', 'Penimbangan rutin dilaksanakan pekan kedua dan keempat setiap bulan.', NULL, NULL, 1, '2026-08-06 21:27:04', '2026-08-12 21:16:55', '2026-08-12 21:27:04'),
(2, 'Penyuluhan Gizi Keluarga', 'penyuluhan-gizi-keluarga', 'Edukasi', 'Materi menu bergizi seimbang untuk keluarga.', 'Tim kader membagikan panduan menu sehat dengan bahan lokal terjangkau.', NULL, NULL, 1, '2026-08-09 21:27:04', '2026-08-12 21:16:55', '2026-08-12 21:27:04'),
(3, 'Imunisasi Dasar Lengkap', 'imunisasi-dasar-lengkap', 'Kesehatan Anak', 'Pentingnya imunisasi tepat waktu untuk mencegah penyakit.', 'Pastikan buku KIA dibawa saat pelayanan imunisasi.', NULL, NULL, 1, '2026-08-11 21:27:04', '2026-08-12 21:16:55', '2026-08-12 21:27:04');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('9ducNozJcfqaZwvBqLJdex8AYSlZNlxpvK8OVGJ8', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiV1JJaG10b2hxWkYwQk42SU5iRFlqZmZHbE9rVkNXWmFlaDBycndONCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo3OiJiZXJhbmRhIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1787039242),
('G7FMkmIpEaAqG2e7YcnWyT6pJXGdMp2KRqdpg2Pt', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/151.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWhycVBHSWFxbWE2VTZoVWdvSWpsckc3WmpQQ0h1bmtYZHFSQmlzaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9jbXMvbG9naW4iO3M6NToicm91dGUiO3M6OToiY21zLmxvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1786961969);

-- --------------------------------------------------------

--
-- Table structure for table `site_settings`
--

CREATE TABLE `site_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` longtext DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `site_settings`
--

INSERT INTO `site_settings` (`id`, `key`, `value`, `type`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Posyandu Kita', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05'),
(2, 'site_tagline', 'Nurturing Professionalism for a Healthier Community. Kami hadir untuk melayani dengan empati dan dedikasi.', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05'),
(3, 'contact_address', 'Jl. Sehat Bersama No. 10, Jakarta Raya', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05'),
(4, 'contact_email', 'halo@posyandukita.id', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05'),
(5, 'contact_phone', '0812-3456-7890', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05'),
(6, 'whatsapp_number', '6281234567890', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05'),
(7, 'whatsapp_message', 'Halo Posyandu Kita, saya ingin bertanya.', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05'),
(8, 'footer_copyright', '© 2024 Posyandu Kita.', 'text', '2026-08-12 21:58:05', '2026-08-12 21:58:05');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Posyandu', 'admin', 'admin@posyandu.local', NULL, '$2y$12$VTl9mlNmNxdLsEW8Zjm1fuSFRex7Qm7QhlMNr9xPqnPZqMIw7UfiO', 1, NULL, '2026-08-12 21:16:54', '2026-08-12 21:27:04'),
(2, 'Test User', 'testuser', 'test@example.com', NULL, '$2y$12$s.523Dnx6rFFiBLoils4DODpZmX4hf.q936R/f72uiKC2nBGvCBXK', 0, NULL, '2026-08-12 21:16:54', '2026-08-12 21:16:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cms_pages_slug_unique` (`slug`),
  ADD KEY `cms_pages_hero_media_asset_id_foreign` (`hero_media_asset_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gallery_items_image_media_asset_id_foreign` (`image_media_asset_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media_assets`
--
ALTER TABLE `media_assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`),
  ADD KEY `posts_cover_media_asset_id_foreign` (`cover_media_asset_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `site_settings`
--
ALTER TABLE `site_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `site_settings_key_unique` (`key`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery_items`
--
ALTER TABLE `gallery_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media_assets`
--
ALTER TABLE `media_assets`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `site_settings`
--
ALTER TABLE `site_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD CONSTRAINT `cms_pages_hero_media_asset_id_foreign` FOREIGN KEY (`hero_media_asset_id`) REFERENCES `media_assets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `gallery_items`
--
ALTER TABLE `gallery_items`
  ADD CONSTRAINT `gallery_items_image_media_asset_id_foreign` FOREIGN KEY (`image_media_asset_id`) REFERENCES `media_assets` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_cover_media_asset_id_foreign` FOREIGN KEY (`cover_media_asset_id`) REFERENCES `media_assets` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
