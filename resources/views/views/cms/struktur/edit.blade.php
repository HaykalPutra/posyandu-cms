@extends('views.layouts.cms')

@section('title', 'Edit Kelompok Struktur')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Edit Kelompok Struktur</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.struktur.update', $group) }}" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')
        <div style="grid-column:1/-1;"><label>Nama Kelompok</label><input type="text" name="title" value="{{ old('title', $group->title) }}" required></div>
        <div style="grid-column:1/-1;"><label>Keterangan (opsional)</label><input type="text" name="description" value="{{ old('description', $group->description) }}"></div>
        <div><label>Urutan Tampil</label><input type="number" name="sort_order" value="{{ old('sort_order', $group->sort_order) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $group->is_active) ? 'checked' : '' }} style="width:auto;"> Tampilkan di situs</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.struktur.members.index', $group) }}">Kelola Anggota</a>
            <a class="btn btn-ghost" href="{{ route('cms.struktur.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
