@extends('views.layouts.cms')

@section('title', 'Edit Berita')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Edit Berita: {{ $post->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.posts.update', $post) }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')
        <div><label>Judul</label><input type="text" name="title" value="{{ old('title', $post->title) }}" required></div>
        <div><label>Slug</label><input type="text" name="slug" value="{{ old('slug', $post->slug) }}" required></div>
        <div><label>Kategori</label><input type="text" name="category" value="{{ old('category', $post->category) }}"></div>
        <div><label>Tanggal Publish</label><input type="date" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}"></div>
        <div style="grid-column:1/-1;"><label>Cover Image URL</label><input type="url" name="cover_image" value="{{ old('cover_image', $post->cover_image) }}"></div>
        <div style="grid-column:1/-1;"><label>Upload Cover Lokal</label><input type="file" name="cover_image_file" accept="image/*"></div>
        @if($post->cover_image)
            <div style="grid-column:1/-1;">
                <label>Preview Cover Saat Ini</label>
                <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" style="width:100%;max-width:320px;border-radius:12px;border:1px solid #d5dde6;display:block;">
            </div>
        @endif
        <div style="grid-column:1/-1;"><label>Ringkasan</label><textarea name="excerpt" style="min-height:100px;">{{ old('excerpt', $post->excerpt) }}</textarea></div>
        <div style="grid-column:1/-1;"><label>Isi Berita</label><textarea name="body">{{ old('body', $post->body) }}</textarea></div>
        <label style="display:flex;align-items:center;gap:8px;grid-column:1/-1;"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }} style="width:auto;"> Publish</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Update</button>
            <a class="btn btn-ghost" href="{{ route('cms.posts.index') }}">Kembali</a>
        </div>
    </form>
</section>
@endsection
