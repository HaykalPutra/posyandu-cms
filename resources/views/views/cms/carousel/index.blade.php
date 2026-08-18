@extends('views.layouts.cms')

@section('title', 'Kelola Carousel Beranda')

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
    <h1 style="margin:0;">Carousel Beranda</h1>
    <a class="btn btn-main" href="{{ route('cms.carousel.create') }}">Tambah Slide</a>
</section>

<section class="panel">
    <table class="table">
        <thead><tr><th>Judul</th><th>Aktif</th><th>Urutan</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->title ?: '(tanpa judul)' }}</td>
                <td>{{ $item->is_active ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $item->sort_order }}</td>
                <td style="display:flex;gap:8px;">
                    <a class="btn btn-ghost" href="{{ route('cms.carousel.edit', $item) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.carousel.destroy', $item) }}" onsubmit="return confirm('Hapus slide ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">Belum ada slide carousel. Beranda akan menampilkan hero default.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $items->links() }}</div>
</section>
@endsection
