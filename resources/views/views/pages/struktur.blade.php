@extends('views.layouts.app')

@section('title', 'Struktur Organisasi - Posyandu Kita')
@section('body-class', 'bg-background text-on-background antialiased min-h-screen flex flex-col')

@section('content')
@include('views.partials.public-navbar')
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

<!-- Kelompok Struktur (dinamis dari CMS) -->
@forelse($orgGroups as $group)
@php($tiers = $group->structuredMembers())
@unless($loop->first)
<div class="h-px bg-outline-variant w-full my-stack-sm"></div>
@endunless
<section class="flex flex-col gap-stack-md">
<header class="text-center max-w-2xl mx-auto mb-stack-sm">
<h2 class="font-headline-lg-mobile text-headline-lg-mobile md:font-headline-lg md:text-headline-lg text-primary mb-stack-sm">{{ $group->title }}</h2>
@if($group->description)
<p class="font-body-md text-body-md text-on-surface-variant">{{ $group->description }}</p>
@endif
</header>

@if($tiers['leader'] === null && $tiers['secretariat']->isEmpty() && $tiers['departments']->isEmpty() && $tiers['flatMembers']->isEmpty())
<div class="bg-surface-container-lowest rounded-xl border border-surface-variant/60 p-10 text-center">
<p class="font-body-md text-body-md text-on-surface-variant">Belum ada anggota di kelompok ini. Tambahkan lewat menu "Struktur Organisasi" di CMS.</p>
</div>
@else
<div class="flex flex-col items-center gap-stack-lg">

@if($tiers['departments']->isNotEmpty())
    {{-- Layout hierarki: Ketua sendirian di atas, lalu Sekretaris/Bendahara, lalu kartu per Bidang --}}
    @if($tiers['leader'])
    <div class="flex flex-col items-center">
    <div class="bg-surface-container-lowest rounded-xl p-6 flex flex-col items-center gap-stack-sm w-[280px] border border-secondary-container shadow-sm">
    @include('views.partials.org-avatar', ['member' => $tiers['leader'], 'sizeClass' => 'w-20 h-20', 'bgClass' => 'bg-primary-container', 'textClass' => 'text-on-primary-container'])
    <div class="text-center">
    <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $tiers['leader']->name }}</h3>
    <p class="font-label-md text-label-md text-primary mt-1">{{ $tiers['leader']->position }}</p>
    </div>
    </div>
    </div>
    @endif

    @if($tiers['secretariat']->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
    @foreach($tiers['secretariat'] as $member)
    <div class="bg-surface-container-lowest rounded-xl p-6 flex flex-col items-center gap-stack-sm w-[280px] border border-secondary-container shadow-sm">
    @include('views.partials.org-avatar', ['member' => $member, 'sizeClass' => 'w-16 h-16', 'bgClass' => 'bg-secondary-container', 'textClass' => 'text-on-secondary-container'])
    <div class="text-center">
    <h3 class="font-headline-sm text-headline-sm text-on-surface">{{ $member->name }}</h3>
    <p class="font-label-md text-label-md text-primary mt-1">{{ $member->position }}</p>
    </div>
    </div>
    @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-gutter w-full">
    @foreach($tiers['departments'] as $departmentName => $entries)
    <div class="bg-surface-container-low rounded-xl p-5 border border-surface-variant">
    <h4 class="font-label-md text-primary mb-3 border-b border-primary/20 pb-2">{{ $departmentName }}</h4>
    <div class="flex flex-col gap-3">
    @foreach($entries as $entry)
    <div class="flex items-center gap-3">
    @include('views.partials.org-avatar', ['member' => $entry->member, 'sizeClass' => 'w-10 h-10', 'bgClass' => 'bg-surface-container-highest', 'textClass' => 'text-on-surface-variant', 'textSize' => 'text-[14px]'])
    <div>
    <p class="font-label-md text-on-surface">{{ $entry->member->name }}</p>
    <p class="text-[12px] text-on-surface-variant">{{ $entry->role }}</p>
    </div>
    </div>
    @endforeach
    </div>
    </div>
    @endforeach
    </div>

    @if($tiers['flatMembers']->isNotEmpty())
    <div class="w-full">
    <h3 class="font-headline-sm text-headline-sm text-center text-on-surface-variant mb-gutter">Anggota</h3>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
    @foreach($tiers['flatMembers'] as $member)
    <div class="flex flex-col items-center gap-2">
    @include('views.partials.org-avatar', ['member' => $member, 'sizeClass' => 'w-12 h-12', 'bgClass' => 'bg-surface-container-highest', 'textClass' => 'text-on-surface-variant'])
    <p class="font-label-md text-[13px] text-on-surface text-center">{{ $member->name }}</p>
    </div>
    @endforeach
    </div>
    </div>
    @endif
@else
    {{-- Tidak ada Bidang: tampilkan pimpinan sebagai "core team" sebaris, sisanya jadi grid Anggota --}}
    @php($coreTeam = collect($tiers['leader'] ? [$tiers['leader']] : [])->concat($tiers['secretariat']))
    @if($coreTeam->isNotEmpty())
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter w-full">
    @foreach($coreTeam as $member)
    <div class="bg-surface-container-lowest rounded-xl p-6 flex flex-col items-center gap-stack-sm border border-secondary-container shadow-sm">
    @php($isLeader = $tiers['leader'] && $member->id === $tiers['leader']->id)
    @include('views.partials.org-avatar', ['member' => $member, 'sizeClass' => 'w-16 h-16', 'bgClass' => $isLeader ? 'bg-primary-container' : 'bg-secondary-container', 'textClass' => $isLeader ? 'text-on-primary-container' : 'text-on-secondary-container'])
    <div class="text-center">
    <h3 class="font-label-md text-label-md text-on-surface">{{ $member->name }}</h3>
    <p class="text-[12px] text-primary">{{ $member->position }}</p>
    </div>
    </div>
    @endforeach
    </div>
    @endif

    @if($tiers['flatMembers']->isNotEmpty())
    <div class="w-full">
    @if($coreTeam->isNotEmpty())
    <h3 class="font-headline-sm text-headline-sm text-center text-on-surface-variant mb-gutter">Anggota</h3>
    @endif
    <div class="grid grid-cols-2 md:grid-cols-4 gap-gutter">
    @foreach($tiers['flatMembers'] as $member)
    <div class="flex flex-col items-center gap-2">
    @include('views.partials.org-avatar', ['member' => $member, 'sizeClass' => 'w-12 h-12', 'bgClass' => 'bg-surface-container-highest', 'textClass' => 'text-on-surface-variant'])
    <p class="font-label-md text-[13px] text-on-surface text-center">{{ $member->name }}</p>
    </div>
    @endforeach
    </div>
    </div>
    @endif
@endif

</div>
@endif
</section>
@empty
<div class="bg-surface-container-lowest rounded-xl border border-surface-variant/60 p-10 text-center">
<p class="font-body-md text-body-md text-on-surface-variant">Struktur organisasi belum diisi. Tambahkan lewat menu "Struktur Organisasi" di CMS.</p>
</div>
@endforelse
</main>
@include('views.partials.public-footer')
@endsection