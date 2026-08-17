@extends('views.layouts.app')

@section('title', 'Dokumentasi Kegiatan - Posyandu Kita')
@section('body-class', 'bg-background text-on-background antialiased selection:bg-primary-container selection:text-on-primary-container')

@section('content')
@include('views.partials.public-navbar')
@php($meta = $page->meta ?? [])
<main class="max-w-[1200px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-stack-lg">
<header class="mb-stack-lg text-center">
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-stack-sm">
                {{ $page->title }}
            </h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                {{ $page->subtitle }}
            </p>
</header>
@if(!empty($page->body))
<section class="mb-stack-lg bg-surface-container rounded-xl p-6 text-on-surface-variant whitespace-pre-line">{{ $page->body }}</section>
@endif
<section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
@if(!empty($meta['gallery_section_subtitle']))
<div class="lg:col-span-3 text-on-surface-variant">{{ $meta['gallery_section_subtitle'] }}</div>
@endif
@forelse($galleryItems as $item)
<article class="rounded-xl overflow-hidden shadow-sm bg-surface">
<img class="w-full h-64 object-cover" src="{{ $item->imageSrc() }}" alt="{{ $item->title }}"/>
<div class="p-5">
<h2 class="font-headline-sm text-headline-sm text-primary mb-2">{{ $item->title }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant mb-2">{{ $item->description }}</p>
<span class="font-label-md text-label-md text-on-surface-variant">{{ optional($item->captured_at)->format('d M Y') }}</span>
</div>
</article>
@empty
<div class="rounded-xl border border-outline-variant bg-surface p-6 text-on-surface-variant">Belum ada dokumentasi galeri.</div>
@endforelse
</section>
</main>
@include('views.partials.public-footer')
@endsection


