@extends('views.layouts.cms')

@section('title', 'Dashboard CMS')

@section('content')
<section class="grid stats">
    <article class="panel"><strong>Halaman</strong><div style="font-size:34px;margin-top:8px;">{{ $stats['pages'] }}</div></article>
    <article class="panel"><strong>Berita</strong><div style="font-size:34px;margin-top:8px;">{{ $stats['posts'] }}</div></article>
    <article class="panel"><strong>Galeri</strong><div style="font-size:34px;margin-top:8px;">{{ $stats['gallery'] }}</div></article>
    <article class="panel"><strong>Berita Publish</strong><div style="font-size:34px;margin-top:8px;">{{ $stats['published_posts'] }}</div></article>
</section>

<section class="panel" style="margin-top:16px;">
    <h2 style="margin:0 0 12px;">Aksi Cepat Admin</h2>
    <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr));">
        <a class="btn btn-main" href="{{ route('cms.pages.index') }}">Ubah Teks Per Halaman</a>
        <a class="btn btn-main" href="{{ route('cms.posts.index') }}">Kelola Berita + Foto Cover</a>
        <a class="btn btn-main" href="{{ route('cms.gallery.index') }}">Kelola Foto Galeri</a>
        <a class="btn btn-main" href="{{ route('cms.settings.edit') }}">Pengaturan Situs Global</a>
        <a class="btn btn-ghost" href="{{ route('beranda') }}">Lihat Website</a>
    </div>
    <p style="margin:12px 0 0;color:#607285;">
        Tips: menu Halaman dipakai untuk konten per page seperti Beranda, Dokumentasi, Struktur, Tentang, dan Lokasi.
    </p>
</section>

<section class="panel" style="margin-top:16px;">
    <h2 style="margin:0 0 12px;">Berita Terakhir Diubah</h2>
    <table class="table">
        <thead><tr><th>Judul</th><th>Kategori</th><th>Update</th></tr></thead>
        <tbody>
        @forelse($recentPosts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category ?: '-' }}</td>
                <td>{{ $post->updated_at->format('d M Y H:i') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Belum ada berita.</td></tr>
        @endforelse
        </tbody>
    </table>
</section>
@endsection
