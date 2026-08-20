@extends('views.layouts.app')

@section('title', 'Galeri - Posyandu Kita')
@section('body-class', 'bg-background text-on-background min-h-screen flex flex-col font-body-md text-body-md antialiased')

@push('styles')
<style>
.masonry-grid {
            column-count: 1;
            column-gap: 24px;
        }
        @media (min-width: 768px) {
            .masonry-grid { column-count: 2; }
        }
        @media (min-width: 1024px) {
            .masonry-grid { column-count: 3; }
        }
        .masonry-item {
            break-inside: avoid;
            margin-bottom: 24px;
        }
</style>
@endpush

@section('content')
@include('views.partials.public-navbar')
@php($meta = $page->meta ?? [])
<main class="flex-grow w-full max-w-[1200px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-stack-lg">
<!-- Header Section -->
<div class="mb-stack-lg text-center md:text-left">
<h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-on-surface mb-stack-sm">
                {{ $page->title }}
            </h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                {{ $page->subtitle }}
            </p>
</div>
<!-- Filter Chips -->
<div class="flex flex-wrap gap-base mb-stack-lg justify-center md:justify-start">
@foreach(($meta['filter_labels'] ?? ['Semua Foto']) as $index => $label)
<button class="px-4 py-2 rounded-full {{ $index === 0 ? 'bg-primary text-on-primary shadow-[0_4px_12px_rgba(0,104,93,0.15)]' : 'bg-surface-container text-on-surface hover:bg-primary-container hover:text-on-primary-container' }} transition-transform font-label-md text-label-md">{{ $label }}</button>
@endforeach
</div>
<div class="masonry-grid">
@forelse($items as $item)
<div class="masonry-item relative group cursor-pointer overflow-hidden rounded-xl shadow-[0_4px_12px_rgba(0,104,93,0.05)] bg-surface-container-lowest">
<img class="w-full h-auto object-cover transition-transform duration-500 group-hover:scale-105" src="{{ $item->imageSrc() }}" alt="{{ $item->title }}"/>
<div class="absolute inset-0 bg-inverse-surface/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
<span class="material-symbols-outlined text-on-primary" style="font-size: 48px;">zoom_in</span>
</div>
<div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-inverse-surface/80 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
<p class="text-on-primary font-headline-sm text-headline-sm">{{ $item->title }}</p>
<p class="text-surface-container-low font-body-md text-body-md">{{ optional($item->captured_at)->format('F Y') }}</p>
</div>
</div>
@empty
<div class="masonry-item bg-surface-container-lowest rounded-xl border border-surface-variant p-6 text-on-surface-variant">Belum ada foto galeri.</div>
@endforelse
</div>
<!-- Load More -->
<div class="mt-stack-lg flex justify-center">
<span class="border-2 border-primary/30 text-primary px-8 py-3 rounded-full font-label-md text-label-md bg-surface">{{ $meta['footer_note'] ?? '-' }}</span>
</div>
</main>
@include('views.partials.public-footer')
@endsection


