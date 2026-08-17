@extends('views.layouts.app')

@section('title', 'Struktur Organisasi - Posyandu Kita')
@section('body-class', 'bg-background text-on-background antialiased min-h-screen flex flex-col')

@section('content')
@include('views.partials.public-navbar')
@php($meta = $page->meta ?? [])
<main class="flex-grow w-full max-w-[1200px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-stack-lg flex flex-col gap-stack-lg">
<!-- Header Section -->
<header class="text-center max-w-2xl mx-auto mb-stack-md">
<h1 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-primary mb-stack-sm">
                {{ $page->title }}
            </h1>
<p class="font-body-md text-body-md text-on-surface-variant">
                {{ $page->subtitle }}
            </p>
</header>
@if(!empty($page->body))
<section class="bg-surface-container rounded-xl p-6 text-on-surface-variant whitespace-pre-line">{{ $page->body }}</section>
@endif
<!-- Org Chart Container (Bento/Card Style) -->
<div class="relative w-full flex flex-col items-center gap-stack-lg">
<!-- Level 1: Puskesmas Pembina -->
<div class="w-full flex justify-center relative z-10">
<div class="bg-surface-container-lowest rounded-xl p-6 flex flex-col items-center gap-stack-sm w-[300px] relative border border-secondary-container hover:-translate-y-1 transition-transform duration-300" style="box-shadow: 0 4px 12px rgba(0, 107, 95, 0.05);">
<div class="w-24 h-24 rounded-full overflow-hidden border-4 border-surface-container">
<img class="w-full h-full object-cover" src="{{ $meta['supervisor_image'] ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuACJIk-z5VGJDg03H1QV0xGtZat_QL7LhL5wFHlKCWKHYNj0vQSbL5qHbi_mEuESrojNcGPklRtRHBTtA2b-LJpi9Y8nBsCqoJMlzzuUrR3cs3kyxqGzKIG3mtNzOxlpd89Jb1PCN5woO2C6kLwtvEh_RQYzA-ruOhoAxLEcVpod3HJbKv-F4kvWpVktZxViDLfv5O2veJ8opGRqe-ZaFvoblEv6thY5ydeVv5UGgJAvmkYLuq0hlHbmQ' }}" alt="{{ $meta['supervisor_name'] ?? 'Pembina' }}"/>
</div>
<div class="text-center">
<h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $meta['supervisor_name'] ?? 'Puskesmas Kecamatan' }}</h3>
<p class="font-label-md text-label-md text-primary mt-1">{{ $meta['supervisor_role'] ?? 'Puskesmas Pembina' }}</p>
</div>
<span class="bg-surface-container-high text-primary px-3 py-1 rounded-full font-label-md text-[12px] absolute -top-3">{{ $meta['supervisor_badge'] ?? 'Instansi Pembina' }}</span>
</div>
</div>
<!-- Connector Line (Visual only, hidden on mobile for simplicity, or simplified) -->
<div class="hidden md:block absolute w-0.5 h-16 bg-secondary-container left-1/2 -ml-[1px] top-[140px] z-0"></div>
<!-- Level 2: Ketua Posyandu & Bidan Desa -->
<div class="w-full flex flex-col md:flex-row justify-center gap-gutter relative z-10">
<!-- Connector Horizontal (Desktop) -->
<div class="hidden md:block absolute h-0.5 w-[320px] bg-secondary-container left-1/2 -ml-[160px] -top-8 z-0"></div>
<div class="hidden md:block absolute w-0.5 h-8 bg-secondary-container left-1/2 -ml-[160px] -top-8 z-0"></div>
<div class="hidden md:block absolute w-0.5 h-8 bg-secondary-container right-1/2 -mr-[160px] -top-8 z-0"></div>
<div class="bg-surface-container-lowest rounded-xl p-6 flex flex-col items-center gap-stack-sm w-full md:w-[300px] relative border border-secondary-container hover:-translate-y-1 transition-transform duration-300" style="box-shadow: 0 4px 12px rgba(0, 107, 95, 0.05);">
<div class="w-20 h-20 rounded-full overflow-hidden border-4 border-surface-container">
<img class="w-full h-full object-cover" src="{{ $meta['leader_image'] ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAyV7hYByU3lE-3n6bBnWsXMlmSuqPkGfXq1cspKIaEnXudKPYqRGJLpPXwv9CYNsUdmDmRtD96N7n4xQQ43TLenMwjKvGXW9ol6GmDto5NBnFmzv3GNeiJ5w93A0y30yLQDjKzcnv1bLDIpiiCn6EWze0x-Ha1iMMr8VhD6rAHsvUPFrZAm9Tu4IoPrupzIrNyz0hHkRoV4BaJ6hSYdLMiYzzbI004S_kR-YwegE-sj57nYZuQ8OXoqg' }}" alt="{{ $meta['leader_name'] ?? 'Ketua Posyandu' }}"/>
</div>
<div class="text-center">
<h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $meta['leader_name'] ?? 'Ibu Siti Aminah' }}</h3>
<p class="font-label-md text-label-md text-primary mt-1">{{ $meta['leader_role'] ?? 'Ketua Posyandu' }}</p>
</div>
</div>
<div class="bg-surface-container-lowest rounded-xl p-6 flex flex-col items-center gap-stack-sm w-full md:w-[300px] relative border border-secondary-container hover:-translate-y-1 transition-transform duration-300" style="box-shadow: 0 4px 12px rgba(0, 107, 95, 0.05);">
<div class="w-20 h-20 rounded-full overflow-hidden border-4 border-surface-container">
<img class="w-full h-full object-cover" src="{{ $meta['midwife_image'] ?: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBCDRp8mvIJH0AG6Ceu9ZLwFQmpAwtg-sIAfoAubGcjIQHRiAD3OApFpg95wPV_OVoTwpESnpX8y-KufyJM9uEefWkb5Kd7qk4CsEK-_Ph2v396HLcBwvu1oHKMdLRuLHQ4pMiLZDPxwGImO1lgfXwtoD9aFzuKsTLkENJrvmyMJlHIlOTRJxImT8mc6iYxS8kb3J6ihKIM494JJGxAY42jI6Gh70FivB1b5mRkiP55HgAqg732Hf64Kw' }}" alt="{{ $meta['midwife_name'] ?? 'Bidan Desa' }}"/>
</div>
<div class="text-center">
<h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $meta['midwife_name'] ?? 'Bidan Rini, Amd.Keb' }}</h3>
<p class="font-label-md text-label-md text-primary mt-1">{{ $meta['midwife_role'] ?? 'Bidan Desa' }}</p>
</div>
</div>
</div>
<!-- Level 3: Kader Posyandu -->
<div class="w-full mt-stack-md relative z-10">
<h3 class="font-headline-sm text-headline-sm text-center text-on-surface-variant mb-gutter">{{ $meta['cadres_title'] ?? 'Tim Kader Posyandu' }}</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
@foreach(($meta['cadres'] ?? []) as $cadre)
<div class="bg-surface-container-lowest rounded-xl p-5 flex flex-col items-center gap-3 border border-surface-variant hover:border-primary-fixed-dim transition-colors" style="box-shadow: 0 4px 12px rgba(0, 107, 95, 0.05);">
<div class="w-16 h-16 rounded-full overflow-hidden bg-surface-container">
<img class="w-full h-full object-cover" src="{{ $cadre['image'] ?: 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=500&q=80' }}" alt="{{ $cadre['name'] ?? 'Kader' }}"/>
</div>
<div class="text-center">
<h4 class="font-label-md text-label-md text-on-surface">{{ $cadre['name'] ?? '' }}</h4>
<p class="font-body-md text-[13px] text-on-surface-variant">{{ $cadre['role'] ?? '' }}</p>
</div>
</div>
@endforeach
</div>
</div>
</div>
</main>
@include('views.partials.public-footer')
@endsection


