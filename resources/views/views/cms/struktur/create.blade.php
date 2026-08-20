@extends('views.layouts.cms')

@section('title', 'Tambah Kelompok Struktur')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Tambah Kelompok Struktur</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.struktur.store') }}" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        <div style="grid-column:1/-1;"><label>Nama Kelompok</label><input type="text" name="title" value="{{ old('title') }}" placeholder="mis. Pos Pelayanan Terpadu Palem Kelurahan Rancabolang" required></div>
        <div style="grid-column:1/-1;"><label>Keterangan (opsional)</label><input type="text" name="description" value="{{ old('description') }}" placeholder="mis. Tahun 2026 - 2031 &middot; SK Lurah No. 31 Tahun 2026"></div>
        <div><label>Urutan Tampil</label><input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_active" value="1" checked style="width:auto;"> Tampilkan di situs</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.struktur.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
