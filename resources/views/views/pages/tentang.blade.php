@extends('views.layouts.app')

@section('title', 'Tentang Kami - Posyandu Kita')
@section('body-class', 'bg-background text-on-background antialiased selection:bg-primary-container selection:text-on-primary-container min-h-screen flex flex-col font-body-md')

@push('styles')
<style>
.shadow-soft { box-shadow: 0 4px 12px rgba(0, 104, 93, 0.05); }
</style>
@endpush

@section('content')
@include('views.partials.public-navbar')
@php($meta = $page->meta ?? [])
<main class="flex-grow flex flex-col items-center w-full max-w-[1200px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-stack-lg gap-stack-lg">
<!-- Hero Section -->
<section class="w-full text-center space-y-stack-md py-stack-lg max-w-3xl mx-auto">
<h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-primary">{{ $page->title }}</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant">{{ $page->subtitle }}</p>
</section>
<!-- Vision & Mission Bento Grid -->
<section class="w-full grid grid-cols-1 md:grid-cols-2 gap-gutter">
<!-- Visi Card -->
<div class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-soft flex flex-col gap-4 border border-surface-dim/50">
<div class="flex items-center gap-3 text-tertiary">
<span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">visibility</span>
<h2 class="font-headline-md text-headline-md">{{ $meta['vision_title'] ?? 'Visi Kami' }}</h2>
</div>
<p class="font-body-md text-body-md text-on-surface whitespace-pre-line">{{ $meta['vision_body'] ?? '' }}</p>
</div>
<!-- Misi Card -->
<div class="bg-surface-container-lowest rounded-xl p-6 md:p-8 shadow-soft flex flex-col gap-4 border border-surface-dim/50">
<div class="flex items-center gap-3 text-primary">
<span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">flag</span>
<h2 class="font-headline-md text-headline-md">{{ $meta['mission_title'] ?? 'Misi Kami' }}</h2>
</div>
<ul class="font-body-md text-body-md text-on-surface space-y-3 list-none pl-0">
@foreach(($meta['mission_items'] ?? []) as $mission)
<li class="flex items-start gap-2">
<span class="material-symbols-outlined text-primary mt-1 text-sm" style="font-variation-settings: 'FILL' 1;">check_circle</span>
<span>{{ $mission }}</span>
</li>
@endforeach
</ul>
</div>
</section>
<!-- History Section with Image -->
<section class="w-full bg-secondary-container/30 rounded-xl overflow-hidden shadow-soft my-stack-lg">
<div class="grid grid-cols-1 md:grid-cols-2 items-center">
<div class="p-6 md:p-10 space-y-stack-sm">
<h2 class="font-headline-md text-headline-md text-on-secondary-container">{{ $meta['history_title'] ?? 'Sejarah Perjalanan' }}</h2>
<div class="w-16 h-1 bg-tertiary rounded-full mb-4"></div>
<p class="font-body-md text-body-md text-on-surface whitespace-pre-line">{{ $page->body }}</p>
</div>
<div class="h-64 md:h-full min-h-[300px]">
<img class="w-full h-full object-cover" src="{{ $page->heroImageSrc() ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCNS88nxH2prvNnaoFDg7VzpIgUoaR4Ey_hgZeTJnEsj1UFebZvnI19ecoAZTof9Vp6T5NKlioZfHvpr-NihWxdfXJQ3R7v-Q1Y8cnaRtyxpV89Ifh6rWmpkUfJ8xgcr7f3QRgbU9ko2wUzHI6ei3SqCGHNddag9hgLanJYrltA2k3o5UGHjlHSNJ9YirfvdDn6NCS7zCq54kXJit5w4D2afD-GKBR8TLUvJEpmGQEqA5E3fH7fUF8Sfg' }}" alt="{{ $page->title }}"/>
</div>
</div>
</section>
<!-- Impact & Coverage Section -->
<section class="w-full text-center space-y-stack-md pt-stack-md">
<h2 class="font-headline-md text-headline-md text-primary">{{ $meta['impact_title'] ?? 'Jangkauan & Dampak Komunitas' }}</h2>
<p class="font-body-md text-body-md text-on-surface-variant max-w-2xl mx-auto">{{ $meta['impact_subtitle'] ?? '' }}</p>
<div class="grid grid-cols-2 md:grid-cols-4 gap-gutter mt-8">
@foreach(($meta['impact_stats'] ?? []) as $stat)
<div class="flex flex-col items-center p-6 bg-surface-container-lowest rounded-xl shadow-soft border border-surface-dim/30 hover:border-primary-fixed-dim transition-colors">
<span class="material-symbols-outlined text-5xl text-{{ $stat['color'] ?? 'primary' }} mb-3">{{ $stat['icon'] ?? 'favorite' }}</span>
<span class="font-headline-sm text-headline-sm text-on-surface">{{ $stat['value'] ?? '' }}</span>
<span class="font-label-md text-label-md text-on-surface-variant">{{ $stat['label'] ?? '' }}</span>
</div>
@endforeach
</div>
</section>
</main>
@include('views.partials.public-footer')
@endsection


