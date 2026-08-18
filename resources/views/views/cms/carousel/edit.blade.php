@extends('views.layouts.cms')

@section('title', 'Edit Slide Carousel')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Edit Slide Carousel</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    @if ($item->imageSrc())
        <img src="{{ $item->imageSrc() }}" alt="{{ $item->title }}" style="max-height:160px;border-radius:10px;margin-bottom:14px;">
    @endif

    <form method="POST" action="{{ route('cms.carousel.update', $item) }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')
        <div><label>Judul (opsional)</label><input type="text" name="title" value="{{ old('title', $item->title) }}"></div>
        <div><label>Subjudul (opsional)</label><input type="text" name="subtitle" value="{{ old('subtitle', $item->subtitle) }}"></div>
        <div style="grid-column:1/-1;"><label>URL Gambar</label><input type="url" name="image_url" value="{{ old('image_url', $item->image_media_asset_id ? '' : $item->image_url) }}"></div>
        <div style="grid-column:1/-1;"><label>Upload Gambar Lokal (kosongkan jika tidak diganti)</label><input type="file" name="image_file" accept="image/*"></div>
        <div style="grid-column:1/-1;"><label>Link Tujuan (opsional)</label><input type="text" name="link_url" value="{{ old('link_url', $item->link_url) }}"></div>
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }} style="width:auto;"> Aktifkan slide</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.carousel.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
