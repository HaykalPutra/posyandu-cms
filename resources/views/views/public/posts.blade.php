@extends('views.layouts.public')

@section('title', 'Berita - Posyandu Palem')

@section('content')
<section class="hero section reveal">
    <span class="chip">Update Posyandu</span>
    <h1>{{ $page->title }}</h1>
    <p class="lead">{{ $page->subtitle }}</p>
</section>

<section class="reveal" style="margin-top:18px;">
    <div class="grid" style="margin-top:0;">
        @forelse($posts as $post)
            <article class="card" style="grid-column: span 6;">
                <div style="display:flex;justify-content:space-between;gap:10px;flex-wrap:wrap;">
                    <span class="chip">{{ $post->category ?: 'Berita' }}</span>
                    <small style="color:#6a8474;">{{ optional($post->published_at)->format('d M Y') }}</small>
                </div>
                <h2 style="font-size:24px;margin-top:12px;">{{ $post->title }}</h2>
                <p style="color:#4b6556;margin-top:8px;">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 220) }}</p>
            </article>
        @empty
            <article class="card" style="grid-column: span 12;">Belum ada berita dipublikasikan.</article>
        @endforelse
    </div>

    <div style="margin-top:14px;">{{ $posts->links() }}</div>
</section>
@endsection
