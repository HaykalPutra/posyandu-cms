@extends('views.layouts.app')

@section('title', 'Beranda - Posyandu Kita')
@section('body-class', 'bg-background text-on-surface font-body-md text-body-md antialiased selection:bg-primary selection:text-on-primary')

@section('content')
@include('views.partials.public-navbar')
@php($meta = $page->meta ?? [])
<main class="max-w-[1200px] mx-auto px-container-padding-mobile md:px-container-padding-desktop pb-stack-lg">
<!-- Hero Section / Carousel -->
@if($carouselSlides->isNotEmpty())
<section class="mt-stack-md md:mt-stack-lg relative rounded-[2rem] overflow-hidden h-[400px] md:h-[500px] shadow-sm" id="hero-carousel">
@foreach($carouselSlides as $index => $slide)
<div class="hero-slide absolute inset-0 flex items-center bg-secondary-container transition-opacity duration-700 {{ $index === 0 ? 'opacity-100 relative' : 'opacity-0' }}" data-slide-index="{{ $index }}">
<div class="absolute inset-0 bg-cover bg-center w-full h-full opacity-60 mix-blend-overlay" style="background-image: url('{{ $slide->imageSrc() ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDiLowNDd4TjW9DOhPiFnFeU_DG3CZhoYAd770ZGJDks7DPC9_lq7tbOjM-doZrxqcSn60B1vY46yIKV5-MqlchThxdXmjuTP8OS4eYoNoUUUclR0Zc3-LbnCS5l4xz3F52I5l2AAMn2y1gF3N0QYxoetc7WOAaJaWIXgdlOUtvVISvMLbv2jvKs74kfznG8GogbsHVf3ki1o5bgdnALA4og_KNDkAGGeFA8NQ8E39kGzMA7_t8MLSTQA' }}')"></div>
<div class="relative z-10 p-8 md:p-16 max-w-2xl bg-gradient-to-r from-surface/90 to-surface/40 backdrop-blur-sm rounded-r-[2rem] h-full flex flex-col justify-center">
<div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full mb-6 w-fit border border-primary/20">
<span class="material-symbols-outlined text-[18px] text-tertiary">favorite</span>
<span class="font-label-md text-label-md text-primary">{{ $meta['badge'] ?? 'Melayani Sepenuh Hati' }}</span>
</div>
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-4">
                    {{ $slide->title ?: $page->title }}
                </h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-8 max-w-lg">
                    {{ $slide->subtitle ?: $page->subtitle }}
                </p>
<div class="flex gap-4">
<a href="{{ $slide->link_url ?: ($meta['primary_cta_url'] ?? '#jadwal') }}" class="bg-primary text-on-primary px-8 py-4 rounded-full font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-all shadow-sm active:scale-95 duration-200 inline-flex items-center">
                        {{ $meta['primary_cta_label'] ?? 'Jadwal Bulan Ini' }}
                    </a>
<a href="{{ $meta['secondary_cta_url'] ?? '#tentang' }}" class="border-2 border-primary text-primary px-8 py-4 rounded-full font-label-md text-label-md hover:bg-primary/5 transition-all active:scale-95 duration-200 inline-flex items-center">
                        {{ $meta['secondary_cta_label'] ?? 'Pelajari Lebih Lanjut' }}
                    </a>
</div>
</div>
</div>
@endforeach
@if($carouselSlides->count() > 1)
<div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2" id="hero-carousel-dots">
@foreach($carouselSlides as $index => $slide)
<button type="button" class="hero-dot w-2.5 h-2.5 rounded-full transition-all {{ $index === 0 ? 'bg-primary w-6' : 'bg-surface/70' }}" data-dot-index="{{ $index }}" aria-label="Slide {{ $index + 1 }}"></button>
@endforeach
</div>
@endif
</section>
<script>
(function () {
    const root = document.getElementById('hero-carousel');
    if (!root) return;
    const slides = root.querySelectorAll('.hero-slide');
    const dots = root.querySelectorAll('.hero-dot');
    if (slides.length < 2) return;
    let current = 0;

    function show(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('opacity-100', i === index);
            slide.classList.toggle('opacity-0', i !== index);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-primary', i === index);
            dot.classList.toggle('w-6', i === index);
            dot.classList.toggle('bg-surface/70', i !== index);
        });
        current = index;
    }

    dots.forEach((dot) => {
        dot.addEventListener('click', () => show(parseInt(dot.dataset.dotIndex, 10)));
    });

    setInterval(() => show((current + 1) % slides.length), 6000);
})();
</script>
@else
<!-- Hero Section (fallback, belum ada slide carousel di CMS) -->
<section class="mt-stack-md md:mt-stack-lg relative rounded-[2rem] overflow-hidden bg-secondary-container h-[400px] md:h-[500px] flex items-center shadow-sm">
<div class="absolute inset-0 bg-cover bg-center w-full h-full opacity-60 mix-blend-overlay" style="background-image: url('{{ $page->heroImageSrc() ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuDiLowNDd4TjW9DOhPiFnFeU_DG3CZhoYAd770ZGJDks7DPC9_lq7tbOjM-doZrxqcSn60B1vY46yIKV5-MqlchThxdXmjuTP8OS4eYoNoUUUclR0Zc3-LbnCS5l4xz3F52I5l2AAMn2y1gF3N0QYxoetc7WOAaJaWIXgdlOUtvVISvMLbv2jvKs74kfznG8GogbsHVf3ki1o5bgdnALA4og_KNDkAGGeFA8NQ8E39kGzMA7_t8MLSTQA' }}')"></div>
<div class="relative z-10 p-8 md:p-16 max-w-2xl bg-gradient-to-r from-surface/90 to-surface/40 backdrop-blur-sm rounded-r-[2rem] h-full flex flex-col justify-center">
<div class="inline-flex items-center gap-2 bg-primary/10 text-primary px-4 py-2 rounded-full mb-6 w-fit border border-primary/20">
<span class="material-symbols-outlined text-[18px] text-tertiary">favorite</span>
<span class="font-label-md text-label-md text-primary">{{ $meta['badge'] ?? 'Melayani Sepenuh Hati' }}</span>
</div>
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-4">
                    {{ $page->title }}
                </h1>
<p class="font-body-lg text-body-lg text-on-surface-variant mb-8 max-w-lg">
                    {{ $page->subtitle }}
                </p>
<div class="flex gap-4">
<a href="{{ $meta['primary_cta_url'] ?? '#jadwal' }}" class="bg-primary text-on-primary px-8 py-4 rounded-full font-label-md text-label-md hover:bg-primary-container hover:text-on-primary-container transition-all shadow-sm active:scale-95 duration-200 inline-flex items-center">
                        {{ $meta['primary_cta_label'] ?? 'Jadwal Bulan Ini' }}
                    </a>
<a href="{{ $meta['secondary_cta_url'] ?? '#tentang' }}" class="border-2 border-primary text-primary px-8 py-4 rounded-full font-label-md text-label-md hover:bg-primary/5 transition-all active:scale-95 duration-200 inline-flex items-center">
                        {{ $meta['secondary_cta_label'] ?? 'Pelajari Lebih Lanjut' }}
                    </a>
</div>
</div>
</section>
@endif
<!-- Bento Grid Layout for Stats and Schedule -->
<section class="mt-stack-lg grid grid-cols-1 md:grid-cols-12 gap-gutter">
<!-- Welcome & Mission (Spans 8 cols) -->
<div class="md:col-span-8 bg-surface-container-lowest rounded-2xl p-8 shadow-[0_4px_12px_rgba(0,104,93,0.05)] border border-surface-variant">
<div class="flex items-start gap-4 mb-6">
<div class="bg-secondary-container text-primary p-3 rounded-xl">
<span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">volunteer_activism</span>
</div>
<div>
<h2 class="font-headline-md text-headline-md text-on-surface mb-2">{{ $page->title }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant whitespace-pre-line">{{ $page->body }}</p>
</div>
</div>
<!-- Stats Grid inside Welcome -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-8 border-t border-surface-variant/50">
@forelse($homeStats as $index => $stat)
<div class="text-center p-4 bg-surface rounded-xl">
<div class="font-headline-lg text-headline-lg {{ $index % 2 === 0 ? 'text-primary' : 'text-tertiary' }} mb-1">{{ $stat->value }}</div>
<div class="font-label-md text-label-md text-on-surface-variant">{{ $stat->label }}</div>
</div>
@empty
<div class="md:col-span-4 text-center p-4 text-on-surface-variant text-sm">Statistik belum diisi di CMS.</div>
@endforelse
</div>
</div>
<!-- Schedule Sidebar (Spans 4 cols) -->
<div class="md:col-span-4 bg-surface-container-high rounded-2xl p-6 shadow-sm flex flex-col">
<div class="flex items-center justify-between mb-6">
<h3 class="font-headline-sm text-headline-sm text-on-surface">Jadwal Mendatang</h3>
<span class="material-symbols-outlined text-primary">calendar_month</span>
</div>
<div class="space-y-4 flex-grow" id="jadwal">
@forelse($upcomingSchedules as $schedule)
<div class="bg-surface-container-lowest p-4 rounded-xl shadow-[0_2px_8px_rgba(0,104,93,0.03)] border-l-4 {{ $schedule->accent === 'tertiary' ? 'border-tertiary' : 'border-primary' }}">
<div class="flex justify-between items-start mb-2">
<span class="font-label-md text-label-md {{ $schedule->accent === 'tertiary' ? 'text-tertiary bg-tertiary/10' : 'text-primary bg-primary/10' }} px-2 py-1 rounded">{{ $schedule->category }}</span>
<span class="font-label-md text-label-md text-on-surface-variant">{{ $schedule->schedule_date->translatedFormat('d M') }}</span>
</div>
<p class="font-body-md text-body-md text-on-surface">{{ $schedule->location }}</p>
<p class="font-body-md text-body-md text-on-surface-variant text-sm mt-1">{{ $schedule->timeRangeLabel() }}</p>
</div>
@empty
<p class="font-body-md text-body-md text-on-surface-variant text-sm">Belum ada jadwal mendatang. Tambahkan lewat CMS.</p>
@endforelse
</div>
<button class="w-full mt-6 text-primary font-label-md text-label-md py-3 hover:bg-primary/5 rounded-xl transition-colors border border-primary/20">
                    Lihat Kalender Penuh
                </button>
</div>
</section>
<!-- News Preview Section -->
<section class="mt-stack-lg">
<div class="flex justify-between items-end mb-8">
<div>
<h2 class="font-headline-md text-headline-md text-on-surface mb-2">Berita &amp; Pengumuman</h2>
<p class="font-body-md text-body-md text-on-surface-variant">Informasi terbaru seputar kegiatan kesehatan di lingkungan kita.</p>
</div>
<a class="hidden md:flex items-center gap-1 text-primary font-label-md text-label-md hover:underline" href="#">
                    Semua Berita <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
</a>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
@forelse($latestPosts as $post)
<a href="{{ route('berita.show', $post) }}" class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-[0_4px_12px_rgba(0,104,93,0.05)] border border-surface-variant group hover:shadow-[0_12px_24px_rgba(0,104,93,0.08)] transition-all duration-300 block">
<div class="h-48 bg-surface-container overflow-hidden {{ $post->coverImageSrc() ? '' : 'flex items-center justify-center bg-gradient-to-br from-primary-container to-primary' }}">
@if($post->coverImageSrc())
<img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $post->coverImageSrc() }}" alt="{{ $post->title }}"/>
@else
<span class="material-symbols-outlined text-white text-6xl opacity-80" style="font-variation-settings: 'FILL' 1;">article</span>
@endif
</div>
<div class="p-6">
<div class="flex items-center gap-2 mb-3">
<span class="bg-secondary-container text-on-secondary-container px-2 py-1 rounded text-xs font-semibold">{{ $post->category ?: 'Berita' }}</span>
<span class="text-on-surface-variant text-sm font-label-md">{{ optional($post->published_at)->format('d M Y') }}</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-on-surface mb-3 group-hover:text-primary transition-colors">{{ $post->title }}</h3>
<p class="font-body-md text-body-md text-on-surface-variant line-clamp-2 mb-4">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 110) }}</p>
</div>
</a>
@empty
<article class="md:col-span-3 bg-surface-container-lowest rounded-2xl border border-surface-variant p-6 text-on-surface-variant">Belum ada berita dipublikasikan.</article>
@endforelse
</div>
<div class="mt-6 text-center md:hidden">
<a class="inline-flex items-center gap-2 bg-primary/10 text-primary px-6 py-3 rounded-full font-label-md text-label-md" href="#">
                    Lihat Semua Berita
                </a>
</div>
</section>
</main>
@include('views.partials.public-footer')
@endsection


