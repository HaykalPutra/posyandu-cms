@extends('views.layouts.cms')

@section('title', 'Tambah Halaman')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Tambah Halaman</h1>
    <p style="margin:4px 0 14px;color:#607285;">
        Gunakan slug standar agar terhubung ke menu website: beranda, berita, galeri, dokumentasi, struktur, tentang, lokasi.
    </p>
    @if(!empty($presetData))
        <div class="alert alert-success">Preset halaman <strong>{{ $presetData['nav_label'] }}</strong> dimuat. Tinggal sesuaikan lalu simpan.</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.pages.store') }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        <div>
            <label>Slug</label>
            <input type="text" id="slug-input" name="slug" value="{{ old('slug', $presetData['slug'] ?? '') }}" required>
            <div style="display:flex;gap:6px;flex-wrap:wrap;margin-top:6px;">
                @foreach($defaultPages as $preset)
                    <a class="btn btn-ghost" style="padding:6px 10px;" href="{{ route('cms.pages.create', ['preset' => $preset['slug']]) }}">{{ $preset['nav_label'] }}</a>
                @endforeach
            </div>
        </div>
        <div><label>Label Navigasi</label><input type="text" name="nav_label" value="{{ old('nav_label', $presetData['nav_label'] ?? '') }}" required></div>
        <div><label>Judul</label><input type="text" name="title" value="{{ old('title', $presetData['title'] ?? '') }}" required></div>
        <div><label>Subjudul</label><input type="text" name="subtitle" value="{{ old('subtitle', $presetData['subtitle'] ?? '') }}"></div>
        <div><label>Hero Image URL</label><input type="url" name="hero_image" value="{{ old('hero_image', $presetData['hero_image'] ?? '') }}"></div>
        <div><label>Upload Hero Image Lokal</label><input type="file" name="hero_image_file" accept="image/*"></div>
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $presetData['sort_order'] ?? 0) }}" min="0"></div>
        <div style="grid-column:1/-1;"><label>Isi Konten</label><textarea name="body">{{ old('body', $presetData['body'] ?? '') }}</textarea></div>
        <label style="display:flex;align-items:center;gap:8px;grid-column:1/-1;"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $presetData['is_published'] ?? true) ? 'checked' : '' }} style="width:auto;"> Publish</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.pages.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
