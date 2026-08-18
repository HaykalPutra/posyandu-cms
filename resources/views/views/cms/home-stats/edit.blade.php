@extends('views.layouts.cms')

@section('title', 'Edit Statistik Beranda')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Edit Statistik Beranda</h1>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.home-stats.update', $item) }}" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')
        <div><label>Angka (mis. 150+, 12, 98%)</label><input type="text" name="value" value="{{ old('value', $item->value) }}" required></div>
        <div><label>Label (mis. Balita Terdaftar)</label><input type="text" name="label" value="{{ old('label', $item->label) }}" required></div>
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0"></div>
        <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="is_active" value="1" {{ old('is_active', $item->is_active) ? 'checked' : '' }} style="width:auto;"> Tampilkan di beranda</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan</button>
            <a class="btn btn-ghost" href="{{ route('cms.home-stats.index') }}">Batal</a>
        </div>
    </form>
</section>
@endsection
