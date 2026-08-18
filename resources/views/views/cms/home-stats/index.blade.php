@extends('views.layouts.cms')

@section('title', 'Kelola Statistik Beranda')

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
    <h1 style="margin:0;">Statistik Beranda</h1>
    <a class="btn btn-main" href="{{ route('cms.home-stats.create') }}">Tambah Statistik</a>
</section>

<section class="panel">
    <table class="table">
        <thead><tr><th>Angka</th><th>Label</th><th>Urutan</th><th>Aktif</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->value }}</td>
                <td>{{ $item->label }}</td>
                <td>{{ $item->sort_order }}</td>
                <td>{{ $item->is_active ? 'Ya' : 'Tidak' }}</td>
                <td style="display:flex;gap:8px;">
                    <a class="btn btn-ghost" href="{{ route('cms.home-stats.edit', $item) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.home-stats.destroy', $item) }}" onsubmit="return confirm('Hapus statistik ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada statistik. Contoh: 150+ / Balita Terdaftar.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $items->links() }}</div>
</section>
@endsection
