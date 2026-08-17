@extends('views.layouts.public')

@section('title', 'Beranda - Posyandu Palem')

@section('content')
<section class="hero section reveal">
    @if(!empty($page->hero_image))
        <img src="{{ $page->hero_image }}" alt="{{ $page->title }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.23;pointer-events:none;">
    @endif
    <span class="chip">Layanan Terdekat Warga</span>
    <h1>{{ $page->title }}</h1>
    <p class="lead">{{ $page->subtitle }}</p>
    <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap;">
        <a class="btn" href="{{ route('berita') }}">Lihat Berita</a>
        <a class="btn" href="{{ route('galeri') }}" style="background:#295d47;">Lihat Galeri</a>
    </div>
</section>

<section class="grid reveal">
    <article class="card" style="grid-column: span 8;">
        <h2 style="font-size:24px;">Tentang Layanan</h2>
        <p style="color:#496352;margin-top:10px;white-space:pre-line;">{{ $page->body }}</p>
    </article>
    <article class="card" style="grid-column: span 4;">
        <h3 style="font-size:20px;">Ringkasan Cepat</h3>
        <ul style="margin:12px 0 0;padding-left:18px;color:#496352;">
            <li>{{ $latestPosts->count() }} berita terbaru tersedia</li>
            <li>{{ $featuredGallery->count() }} dokumentasi unggulan</li>
            <li>Konten bisa dikelola di panel CMS</li>
        </ul>
    </article>
</section>

<section class="reveal" style="margin-top:18px;">
    <h2 style="font-size:28px;margin:8px 0 16px;">Berita Terbaru</h2>
    <div class="grid" style="margin-top:0;">
        @forelse($latestPosts as $post)
            <article class="card" style="grid-column: span 4;">
                <span class="chip">{{ $post->category ?: 'Informasi' }}</span>
                <h3 style="font-size:20px;margin-top:10px;">{{ $post->title }}</h3>
                <p style="color:#4b6556;margin-top:8px;">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}</p>
            </article>
        @empty
            <article class="card" style="grid-column: span 12;">
                Belum ada berita. Tambahkan dari CMS.
            </article>
        @endforelse
    </div>
</section>
@endsection
