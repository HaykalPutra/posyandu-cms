@extends('views.layouts.cms')

@section('title', 'Edit Anggota')

@section('content')
<section class="panel">
    <p style="margin:0 0 4px;"><a href="{{ route('cms.struktur.members.index', $group) }}" style="color:#607285;font-size:13px;">&larr; {{ $group->title }}</a></p>
    <h1 style="margin-top:0;">Edit Anggota</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <div style="margin-bottom:14px;">
        @if($member->photoSrc())
            <img src="{{ $member->photoSrc() }}" alt="{{ $member->name }}" style="width:64px;height:64px;border-radius:999px;object-fit:cover;">
        @else
            <div style="width:64px;height:64px;border-radius:999px;background:{{ $member->avatarColor() }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:18px;">{{ $member->initials() }}</div>
        @endif
    </div>

    <form method="POST" action="{{ route('cms.struktur.members.update', [$group, $member]) }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')
        <div><label>Nama</label><input type="text" name="name" value="{{ old('name', $member->name) }}" required></div>
        <div>
            <label>Jabatan</label>
            <input type="text" name="position" value="{{ old('position', $member->position) }}" placeholder="Ketua / Sekretaris / Ketua Bidang Kesehatan / Anggota" required>
            <p style="margin:6px 0 0;font-size:12.5px;color:#607285;">
                Halaman Struktur otomatis menyusun tampilan berdasarkan teks ini. Gunakan persis: <strong>"Ketua"</strong> (pemimpin utama),
                <strong>"Sekretaris"</strong> / <strong>"Bendahara"</strong> (baris kedua), <strong>"Ketua Bidang [Nama]"</strong> / <strong>"Kader Bidang [Nama]"</strong>
                (masuk kartu Bidang [Nama] otomatis), atau <strong>"Anggota"</strong> (daftar anggota biasa di bawah).
            </p>
        </div>
        <div style="grid-column:1/-1;"><label>Foto (URL, opsional)</label><input type="url" name="photo_url" value="{{ old('photo_url', $member->photo_media_asset_id ? '' : $member->photo_url) }}"></div>
        <div style="grid-column:1/-1;">
            <label>Upload Foto Baru (kosongkan jika tidak diganti)</label>
            <input type="file" name="photo_file" accept="image/*">
            <p style="margin:6px 0 0;font-size:12.5px;color:#607285;">Kalau tidak ada foto sama sekali, akan otomatis muncul avatar inisial nama.</p>
        </div>
        <div><label>Urutan Tampil</label><input type="number" name="sort_order" value="{{ old('sort_order', $member->sort_order) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $member->is_active) ? 'checked' : '' }} style="width:auto;"> Tampilkan di situs</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.struktur.members.index', $group) }}">Batal</a>
        </div>
    </form>
</section>
@endsection