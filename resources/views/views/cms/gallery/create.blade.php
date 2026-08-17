@extends('views.layouts.cms')

@section('title', 'Tambah Item Galeri')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Tambah Item Galeri</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.gallery.store') }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        <div><label>Judul</label><input type="text" name="title" value="{{ old('title') }}" required></div>
        <div><label>Tanggal Kegiatan</label><input type="date" name="captured_at" value="{{ old('captured_at') }}"></div>
        <div style="grid-column:1/-1;"><label>URL Gambar</label><input type="url" name="image_url" value="{{ old('image_url') }}"></div>
        <div style="grid-column:1/-1;"><label>Upload Gambar Lokal</label><input type="file" name="image_file" accept="image/*"></div>
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_featured" value="1" style="width:auto;"> Jadikan unggulan</label>
        <div style="grid-column:1/-1;"><label>Deskripsi</label><textarea name="description" style="min-height:100px;">{{ old('description') }}</textarea></div>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.gallery.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
