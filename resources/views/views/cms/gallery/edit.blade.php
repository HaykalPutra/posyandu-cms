@extends('views.layouts.cms')

@section('title', 'Edit Item Galeri')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Edit Item: {{ $item->title }}</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.gallery.update', $item) }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')
        <div><label>Judul</label><input type="text" name="title" value="{{ old('title', $item->title) }}" required></div>
        <div><label>Tanggal Kegiatan</label><input type="date" name="captured_at" value="{{ old('captured_at', optional($item->captured_at)->format('Y-m-d')) }}"></div>
        <div style="grid-column:1/-1;"><label>URL Gambar</label><input type="url" name="image_url" value="{{ old('image_url', $item->image_url) }}"></div>
        <div style="grid-column:1/-1;"><label>Upload Gambar Lokal</label><input type="file" name="image_file" accept="image/*"></div>
        @if($item->image_url)
            <div style="grid-column:1/-1;">
                <label>Preview Gambar Saat Ini</label>
                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" style="width:100%;max-width:320px;border-radius:12px;border:1px solid #d5dde6;display:block;">
            </div>
        @endif
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $item->is_featured) ? 'checked' : '' }} style="width:auto;"> Jadikan unggulan</label>
        <div style="grid-column:1/-1;"><label>Deskripsi</label><textarea name="description" style="min-height:100px;">{{ old('description', $item->description) }}</textarea></div>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Update</button>
            <a class="btn btn-ghost" href="{{ route('cms.gallery.index') }}">Kembali</a>
        </div>
    </form>
</section>
@endsection
