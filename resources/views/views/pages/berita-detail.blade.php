@extends('views.layouts.app')

@section('title', ($post->title ?? 'Berita') . ' - Posyandu Kita')
@section('body-class', 'bg-background text-on-background font-body-md antialiased selection:bg-primary-container selection:text-on-primary-container')

@section('content')
@include('views.partials.public-navbar')
<main class="max-w-[1200px] mx-auto px-container-padding-mobile md:px-container-padding-desktop py-stack-lg flex flex-col gap-stack-lg">
<a href="{{ route('berita') }}" class="inline-flex items-center gap-1 text-primary font-label-md text-label-md w-fit">
<span class="material-symbols-outlined text-[18px]">arrow_back</span>
Kembali ke Berita
</a>

<article class="bg-surface rounded-2xl shadow-level-1 overflow-hidden">
<div class="relative h-64 md:h-96 w-full overflow-hidden">
<div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $post->coverImageSrc() ?: 'https://images.unsplash.com/photo-1584515933487-779824d29309?auto=format&fit=crop&w=1200&q=80' }}')"></div>
</div>
<div class="p-6 md:p-10 flex flex-col gap-stack-sm">
<div class="flex items-center gap-2 text-on-surface-variant font-label-md text-label-md">
<span class="bg-tertiary text-on-tertiary px-3 py-1 rounded-full">{{ $post->category ?: 'Berita' }}</span>
<span class="material-symbols-outlined text-[18px]">calendar_today</span>
<time datetime="{{ optional($post->published_at)->format('Y-m-d') }}">{{ optional($post->published_at)->format('d M Y') }}</time>
</div>
<h1 class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">{{ $post->title }}</h1>
@if($post->excerpt)
<p class="font-body-lg text-body-lg text-on-surface-variant">{{ $post->excerpt }}</p>
@endif
<div class="font-body-md text-body-md text-on-surface leading-relaxed whitespace-pre-line mt-4">{{ $post->body }}</div>
</div>
</article>

@if($relatedPosts->isNotEmpty())
<section class="flex flex-col gap-gutter">
<h2 class="font-headline-sm text-headline-sm text-on-surface">Berita Lainnya</h2>
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
@foreach($relatedPosts as $related)
<a href="{{ route('berita.show', $related) }}" class="bg-surface rounded-2xl shadow-level-1 overflow-hidden group cursor-pointer hover:shadow-level-2 transition-shadow duration-300 flex flex-col">
<div class="relative h-40 w-full overflow-hidden">
<div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-500" style="background-image: url('{{ $related->coverImageSrc() ?: 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=1200&q=80' }}')"></div>
</div>
<div class="p-4">
<span class="text-primary font-label-md text-label-md">{{ $related->category ?: 'Informasi' }}</span>
<h3 class="font-headline-sm text-headline-sm text-on-surface group-hover:text-primary transition-colors line-clamp-2 mt-1">{{ $related->title }}</h3>
</div>
</a>
@endforeach
</div>
</section>
@endif
</main>
@include('views.partials.public-footer')
@endsection
