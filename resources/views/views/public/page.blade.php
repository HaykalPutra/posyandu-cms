@extends('views.layouts.public')

@section('title', $page->title . ' - Posyandu Palem')

@section('content')
<section class="hero section reveal">
    @if(!empty($page->hero_image))
        <img src="{{ $page->hero_image }}" alt="{{ $page->title }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.2;pointer-events:none;">
    @endif
    <span class="chip">{{ strtoupper($page->slug) }}</span>
    <h1>{{ $page->title }}</h1>
    <p class="lead">{{ $page->subtitle }}</p>
</section>

<section class="section card reveal" style="margin-top:18px;white-space:pre-line;">
    {{ $page->body }}
</section>
@endsection
