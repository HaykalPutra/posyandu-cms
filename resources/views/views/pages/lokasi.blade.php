@extends('views.layouts.app')

@section('title', 'Lokasi - Posyandu Kita')
@section('body-class', 'bg-background text-on-surface font-body-md min-h-screen flex flex-col')

@push('styles')
<style>
.shadow-soft {
            box-shadow: 0 4px 12px rgba(0, 104, 93, 0.05);
        }
</style>
@endpush

@section('content')
@include('views.partials.public-navbar')
@php($meta = $page->meta ?? [])
<main class="flex-grow px-container-padding-mobile md:px-container-padding-desktop py-stack-lg max-w-[1200px] mx-auto w-full">
<div class="mb-stack-lg text-center md:text-left">
<h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-primary mb-stack-sm">{{ $page->title }}</h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl">
                {{ $page->subtitle }}
            </p>
</div>
<div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter">
<!-- Map Card -->
<div class="lg:col-span-8 bg-surface-container-lowest rounded-xl shadow-soft overflow-hidden h-[400px] lg:h-[600px] relative">
<img class="w-full h-full object-cover" src="{{ $page->heroImageSrc() ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBIYIhqPneUQGdH4PFmzKpYguXx0pBMu_xAG-JSExB8bi_Nm0Ux_A9X4atHuqUY7mCyEDnw-b-U1A4BLI2eamac4G8SrtoF8BHIY_yl-JYDhlSE6MykxWpZN0mlditbAFOR_cn0EXF7t8VT-zhMIQMfDtJh6AsUfYoU_2Gzfb7HZk2XXuLiZoC7ChI9rJJ5ldwuagQo7ACGtkHx6mx5yZkyY0Iu6fECIcMqu7nn3fwSRLa3Ht7PyuX6uQ' }}" alt="{{ $page->title }}"/>
<!-- Overlay Gradient for better integration -->
<div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest/40 to-transparent pointer-events-none"></div>
</div>
<!-- Details Card -->
<div class="lg:col-span-4 flex flex-col gap-stack-md">
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-soft flex flex-col gap-stack-md relative overflow-hidden">
<!-- Decorative background element -->
<div class="absolute top-0 right-0 w-32 h-32 bg-secondary-container rounded-full -mr-16 -mt-16 opacity-50"></div>
<div>
<div class="flex items-center gap-2 mb-2 text-primary">
<span class="material-symbols-outlined" data-icon="location_on" data-weight="fill" style="font-variation-settings: 'FILL' 1;">location_on</span>
<h2 class="font-headline-md text-headline-md">Alamat</h2>
</div>
<p class="font-body-md text-body-md text-on-surface-variant relative z-10 whitespace-pre-line">{{ $meta['address'] ?? $page->body }}</p>
</div>
<div class="h-px bg-outline-variant/30 w-full"></div>
<div>
<div class="flex items-center gap-2 mb-2 text-primary">
<span class="material-symbols-outlined" data-icon="schedule" data-weight="fill" style="font-variation-settings: 'FILL' 1;">schedule</span>
<h2 class="font-headline-md text-headline-md">Jadwal Operasional</h2>
</div>
<p class="font-body-md text-body-md text-on-surface-variant bg-surface-container rounded-lg p-3 inline-block whitespace-pre-line">{{ $meta['schedule'] ?? "Setiap Rabu pertama setiap bulan\n08:00 - 12:00 WIB" }}</p>
</div>
<div class="h-px bg-outline-variant/30 w-full"></div>
<div>
<div class="flex items-center gap-2 mb-2 text-primary">
<span class="material-symbols-outlined" data-icon="call" data-weight="fill" style="font-variation-settings: 'FILL' 1;">call</span>
<h2 class="font-headline-md text-headline-md">Kontak</h2>
</div>
<p class="font-body-md text-body-md text-on-surface-variant font-semibold">{{ $meta['phone'] ?? '+62 812 3456 7890' }}</p>
</div>
<a href="{{ $meta['maps_url'] ?? 'https://maps.google.com' }}" target="_blank" rel="noopener noreferrer" class="mt-4 w-full bg-primary text-on-primary font-label-md text-label-md h-12 rounded-full hover:bg-primary-container transition-all flex items-center justify-center gap-2 shadow-soft hover:shadow-md active:scale-95 duration-200">
<span class="material-symbols-outlined text-sm" data-icon="map">map</span>
                        Buka di Google Maps
                    </a>
</div>
<!-- Extra Info Card (Transportation) -->
<div class="bg-surface-container rounded-xl p-6 shadow-soft">
<div class="flex items-center gap-2 mb-3 text-secondary">
<span class="material-symbols-outlined" data-icon="directions_bus" data-weight="fill" style="font-variation-settings: 'FILL' 1;">directions_bus</span>
<h3 class="font-headline-sm text-headline-sm">Akses Transportasi</h3>
</div>
<ul class="font-body-md text-body-md text-on-surface-variant list-disc list-inside space-y-1">
@foreach(($meta['transport_notes'] ?? ['5 menit jalan kaki dari Halte Busway Sehat.', 'Tersedia area parkir untuk motor dan sepeda.']) as $note)
<li>{{ $note }}</li>
@endforeach
</ul>
</div>
</div>
</div>
</main>
@include('views.partials.public-footer')
@endsection


