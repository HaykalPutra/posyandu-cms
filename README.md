# Posyandu Palem — Website & CMS

Website profil Posyandu (Beranda, Berita, Galeri, Dokumentasi, Struktur, Tentang, Lokasi) dengan panel admin (CMS) berbasis Laravel untuk mengelola seluruh konten tanpa perlu edit kode.

## Kebutuhan Sistem

- PHP 8.2+
- Composer
- Node.js 18+ dan npm
- MySQL (atau database lain yang didukung Laravel)

## Instalasi Awal

```bash
composer install
npm install
copy .env.example .env        # di Windows PowerShell: Copy-Item .env.example .env
php artisan key:generate
```

Edit `.env` dan sesuaikan koneksi database:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=posyandu_palem
DB_USERNAME=root
DB_PASSWORD=
```

Buat database `posyandu_palem` di MySQL, lalu jalankan migrasi dan seeder:

```bash
php artisan migrate --seed
```

Wajib dijalankan supaya upload gambar (foto berita, galeri, logo) bisa tampil di browser:

```bash
php artisan storage:link
```

Build asset front-end (Tailwind CSS via Vite, wajib dilakukan minimal sekali dan setiap kali CSS/JS diubah):

```bash
npm run build
```

Untuk mode pengembangan dengan hot-reload:

```bash
npm run dev
```

Jalankan server lokal:

```bash
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Login Admin (CMS)

- URL: `http://127.0.0.1:8000/cms/login`
- ID Admin default: `admin`
- Password default: `admin123`

**Segera ganti password default ini setelah login pertama kali** lewat menu **Profil** di CMS. Kalau lupa password, gunakan tautan "Lupa password?" di halaman login (link reset dikirim ke email admin yang terdaftar; saat `MAIL_MAILER=log`, link tersebut bisa dilihat di `storage/logs/laravel.log`).

## Struktur CMS

- **Halaman** — kelola judul, subjudul, isi teks, dan gambar hero untuk tiap halaman (Beranda, Berita, Galeri, Dokumentasi, Struktur, Tentang, Lokasi).
- **Berita** — kelola artikel berita beserta foto cover, kategori, dan status publish.
- **Galeri** — kelola foto dokumentasi kegiatan.
- **Pengaturan Situs** — nama situs, kontak, nomor WhatsApp, dan footer.
- **Profil** — ubah ID admin dan password.

## Deploy ke Produksi (Wajib Diperhatikan)

Sebelum go-live, pastikan `.env` di server produksi diset:

```
APP_ENV=production
APP_DEBUG=false
```

`APP_DEBUG=true` di production membocorkan stack trace, path server, dan query SQL ke publik saat terjadi error — jangan sampai kepasang di server live.

Langkah build produksi:

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Catatan Keamanan

- Rate limiting sudah aktif di login CMS (`throttle:5,1`) dan permintaan reset password (`throttle:3,1`), untuk mencegah brute-force.
- Halaman error 404/403 sudah kustom (lihat `resources/views/errors/`).
- Upload gambar divalidasi sebagai tipe `image` dengan batas ukuran maksimum.

