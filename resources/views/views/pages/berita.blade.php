@extends('views.layouts.app')

@section('title', 'Berita - Posyandu Kita')
@section('body-class', 'bg-background text-on-background font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container')

@push('styles')
<style>
/* Hide scrollbar for category filters */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
</style>
@endpush

@section('content')
@include('views.partials.public-navbar')
@php($meta = $page->meta ?? [])
<main class="max-w-[1200px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-stack-lg min-h-screen flex flex-col gap-stack-lg">
<!-- Header Section with Search & Filter -->
<section class="flex flex-col gap-stack-md bg-secondary-container/20 p-8 rounded-2xl">
<div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-stack-sm">
<div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-2">{{ $page->title }}</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">{{ $page->subtitle }}</p>
</div>
</div>
<!-- Search and Filter Bar -->
<form method="GET" action="{{ route('berita') }}" class="flex flex-col md:flex-row gap-gutter mt-4">
<!-- Search -->
<div class="relative flex-grow">
<span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline">search</span>
<input name="q" value="{{ $search ?? '' }}" class="w-full bg-surface pl-12 pr-4 py-4 rounded-xl border border-outline-variant focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all font-body-md text-body-md text-on-surface placeholder:text-outline-variant shadow-level-1" placeholder="Cari artikel, topik, atau kegiatan..." type="text"/>
</div>
<button type="submit" class="px-6 py-4 bg-primary text-on-primary rounded-xl font-label-md text-label-md shadow-level-1">Cari</button>
@if(!empty($search))
<a href="{{ route('berita') }}" class="px-6 py-4 bg-surface text-on-surface-variant border border-outline-variant rounded-xl font-label-md text-label-md text-center">Reset</a>
@endif
<!-- Categories -->
<div class="flex gap-2 overflow-x-auto pb-2 md:pb-0 hide-scrollbar items-center">
@foreach(($meta['filter_labels'] ?? ['Semua']) as $index => $label)
<button type="button" class="whitespace-nowrap px-6 py-3 {{ $index === 0 ? 'bg-primary text-on-primary shadow-level-1' : 'bg-surface text-primary border border-primary/20 hover:bg-primary-container/10' }} rounded-full font-label-md text-label-md transition-colors flex-shrink-0">{{ $label }}</button>
@endforeach
</div>
</form>
</section>
@if(!empty($search))
<p class="font-body-md text-body-md text-on-surface-variant">Hasil pencarian untuk "{{ $search }}": {{ $listPosts->count() }} artikel ditemukan.</p>
@else
<!-- Featured Article (Bento Grid Style) -->
<h2 class="font-headline-sm text-headline-sm text-on-surface">{{ $meta['featured_section_title'] ?? 'Sorotan Utama' }}</h2>
<section class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
@php($featuredPost = $featuredPosts->first())
@php($secondaryPost = $featuredPosts->skip(1)->first())
@if($featuredPost)
<a href="{{ route('berita.show', $featuredPost) }}" class="lg:col-span-8 bg-surface rounded-2xl shadow-level-1 overflow-hidden group cursor-pointer hover:shadow-level-2 transition-shadow duration-300 block">
<div class="relative h-64 md:h-80 w-full overflow-hidden">
<div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-500" style="background-image: url('{{ $featuredPost->coverImageSrc() ?: 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80' }}')"></div>
<div class="absolute top-4 left-4">
<span class="bg-tertiary text-on-tertiary px-3 py-1 rounded-full font-label-md text-label-md shadow-sm">{{ $featuredPost->category ?: 'Berita Utama' }}</span>
</div>
</div>
<div class="p-6 md:p-8 flex flex-col gap-stack-sm">
<div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
<span class="material-symbols-outlined text-[18px]">calendar_today</span>
<time datetime="{{ optional($featuredPost->published_at)->format('Y-m-d') }}">{{ optional($featuredPost->published_at)->format('d M Y') }}</time>
</div>
<h2 class="font-headline-md text-headline-md text-on-surface group-hover:text-primary transition-colors">{{ $featuredPost->title }}</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant line-clamp-2">{{ $featuredPost->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($featuredPost->body), 180) }}</p>
</div>
</a>
<div class="lg:col-span-4 flex flex-col gap-gutter">
@if($secondaryPost)
<a href="{{ route('berita.show', $secondaryPost) }}" class="flex-1 bg-surface rounded-2xl shadow-level-1 overflow-hidden group cursor-pointer hover:shadow-level-2 transition-shadow duration-300 flex flex-col">
<div class="relative h-48 w-full overflow-hidden">
<div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-500" style="background-image: url('{{ $secondaryPost->coverImageSrc() ?: 'https://images.unsplash.com/photo-1547592180-85f173990554?auto=format&fit=crop&w=1200&q=80' }}')"></div>
<div class="absolute top-4 left-4">
<span class="bg-primary text-on-primary px-3 py-1 rounded-full font-label-md text-label-md shadow-sm">{{ $secondaryPost->category ?: 'Berita' }}</span>
</div>
</div>
<div class="p-6 flex-1 flex flex-col justify-between">
<div>
<div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md mb-2">
<time datetime="{{ optional($secondaryPost->published_at)->format('Y-m-d') }}">{{ optional($secondaryPost->published_at)->format('d M Y') }}</time>
</div>
<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-2">{{ $secondaryPost->title }}</h3>
</div>
</div>
</a>
@endif
</div>
@endif
</section>
@endif
<!-- List of Articles -->
<section class="mt-stack-sm flex flex-col gap-gutter">
<h2 class="font-headline-sm text-headline-sm text-on-surface mb-2">{{ $meta['list_section_title'] ?? 'Artikel Terkini' }}</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter">
@forelse($listPosts as $post)
<a href="{{ route('berita.show', $post) }}" class="bg-surface rounded-2xl shadow-level-1 overflow-hidden group cursor-pointer hover:shadow-level-2 transition-shadow duration-300 flex flex-col">
<div class="relative h-48 w-full overflow-hidden">
<div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-500" style="background-image: url('{{ $post->coverImageSrc() ?: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1200&q=80' }}')"></div>
</div>
<div class="p-6 flex-1 flex flex-col gap-stack-sm">
<div class="flex items-center justify-between">
<span class="text-primary font-label-md text-label-md">{{ $post->category ?: 'Informasi' }}</span>
<span class="text-on-surface-variant text-sm">{{ optional($post->published_at)->format('d M Y') }}</span>
</div>
<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors line-clamp-2">{{ $post->title }}</h3>
<p class="font-body-md text-body-md text-on-surface-variant line-clamp-3 mt-1">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}</p>
</div>
</a>
@empty
<article class="md:col-span-3 bg-surface rounded-2xl border border-outline-variant p-6 text-on-surface-variant">{{ !empty($search) ? 'Tidak ada artikel yang cocok dengan pencarian.' : 'Belum ada artikel berita.' }}</article>
@endforelse
</div>
</section>
</main>
@include('views.partials.public-footer')
@endsection


