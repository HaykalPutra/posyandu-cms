@extends('views.layouts.cms')

@section('title', 'Tambah Slide Carousel')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Tambah Slide Carousel</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.carousel.store') }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        <div><label>Judul (opsional)</label><input type="text" name="title" value="{{ old('title') }}"></div>
        <div><label>Subjudul (opsional)</label><input type="text" name="subtitle" value="{{ old('subtitle') }}"></div>
        <div style="grid-column:1/-1;"><label>URL Gambar</label><input type="url" name="image_url" value="{{ old('image_url') }}"></div>
        <div style="grid-column:1/-1;"><label>Upload Gambar Lokal</label><input type="file" name="image_file" accept="image/*"></div>
        <div style="grid-column:1/-1;"><label>Link Tujuan (opsional, mis. #jadwal atau /berita)</label><input type="text" name="link_url" value="{{ old('link_url') }}"></div>
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_active" value="1" checked style="width:auto;"> Aktifkan slide</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.carousel.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
