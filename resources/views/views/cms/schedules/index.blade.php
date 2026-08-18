@extends('views.layouts.cms')

@section('title', 'Kelola Jadwal')

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
    <h1 style="margin:0;">Jadwal Mendatang</h1>
    <a class="btn btn-main" href="{{ route('cms.schedules.create') }}">Tambah Jadwal</a>
</section>

<section class="panel">
    <table class="table">
        <thead><tr><th>Judul</th><th>Kategori</th><th>Tanggal</th><th>Jam</th><th>Lokasi</th><th>Aktif</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ optional($item->schedule_date)->format('d M Y') }}</td>
                <td>{{ $item->timeRangeLabel() }}</td>
                <td>{{ $item->location }}</td>
                <td>{{ $item->is_active ? 'Ya' : 'Tidak' }}</td>
                <td style="display:flex;gap:8px;">
                    <a class="btn btn-ghost" href="{{ route('cms.schedules.edit', $item) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.schedules.destroy', $item) }}" onsubmit="return confirm('Hapus jadwal ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="7">Belum ada jadwal.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $items->links() }}</div>
</section>
@endsection
