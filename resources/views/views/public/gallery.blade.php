@extends('views.layouts.public')

@section('title', 'Galeri - Posyandu Palem')

@section('content')
<section class="hero section reveal">
    <span class="chip">Dokumentasi Visual</span>
    <h1>{{ $page->title }}</h1>
    <p class="lead">{{ $page->subtitle }}</p>
</section>

<section class="reveal" style="margin-top:18px;">
    <div class="grid" style="margin-top:0;">
        @forelse($items as $item)
            <article class="card" style="grid-column: span 4;padding:12px;">
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:100%;aspect-ratio:4/3;object-fit:cover;border-radius:12px;border:1px solid #d8e2d7;">
                <div style="padding:10px 4px 4px;">
                    <h3 style="font-size:18px;">{{ $item->title }}</h3>
                    <p style="margin-top:6px;color:#4b6556;">{{ $item->description }}</p>
                </div>
            </article>
        @empty
            <article class="card" style="grid-column: span 12;">Galeri belum memiliki item.</article>
        @endforelse
    </div>

    <div style="margin-top:14px;">{{ $items->links() }}</div>
</section>
@endsection
