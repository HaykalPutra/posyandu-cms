@extends('views.layouts.cms')

@section('title', 'Tambah Berita')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Tambah Berita</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.posts.store') }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        <div><label>Judul</label><input type="text" name="title" value="{{ old('title') }}" required></div>
        <div><label>Slug</label><input type="text" name="slug" value="{{ old('slug') }}" required></div>
        <div><label>Kategori</label><input type="text" name="category" value="{{ old('category') }}"></div>
        <div><label>Tanggal Publish</label><input type="date" name="published_at" value="{{ old('published_at') }}"></div>
        <div style="grid-column:1/-1;"><label>Cover Image URL</label><input type="url" name="cover_image" value="{{ old('cover_image') }}"></div>
        <div style="grid-column:1/-1;"><label>Upload Cover Lokal</label><input type="file" name="cover_image_file" accept="image/*"></div>
        <div style="grid-column:1/-1;"><label>Ringkasan</label><textarea name="excerpt" style="min-height:100px;">{{ old('excerpt') }}</textarea></div>
        <div style="grid-column:1/-1;"><label>Isi Berita</label><textarea name="body">{{ old('body') }}</textarea></div>
        <label style="display:flex;align-items:center;gap:8px;grid-column:1/-1;"><input type="checkbox" name="is_published" value="1" checked style="width:auto;"> Publish</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.posts.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
