@extends('views.layouts.cms')

@section('title', 'Tambah Jadwal')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Tambah Jadwal</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.schedules.store') }}" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        <div><label>Judul Kegiatan</label><input type="text" name="title" value="{{ old('title') }}" required></div>
        <div><label>Kategori (mis. Penimbangan, Imunisasi)</label><input type="text" name="category" value="{{ old('category') }}"></div>
        <div><label>Tanggal</label><input type="date" name="schedule_date" value="{{ old('schedule_date') }}" required></div>
        <div>
            <label>Warna Label</label>
            <select name="accent">
                <option value="primary" {{ old('accent') === 'primary' ? 'selected' : '' }}>Primary (hijau)</option>
                <option value="tertiary" {{ old('accent') === 'tertiary' ? 'selected' : '' }}>Tertiary (coklat)</option>
            </select>
        </div>
        <div><label>Jam Mulai</label><input type="time" name="start_time" value="{{ old('start_time') }}"></div>
        <div><label>Jam Selesai</label><input type="time" name="end_time" value="{{ old('end_time') }}"></div>
        <div style="grid-column:1/-1;"><label>Lokasi</label><input type="text" name="location" value="{{ old('location') }}"></div>
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_active" value="1" checked style="width:auto;"> Aktifkan jadwal</label>
        <div style="grid-column:1/-1;"><label>Catatan (opsional)</label><textarea name="notes">{{ old('notes') }}</textarea></div>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.schedules.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
