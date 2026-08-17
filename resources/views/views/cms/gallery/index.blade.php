@extends('views.layouts.cms')

@section('title', 'Kelola Galeri')

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
    <h1 style="margin:0;">Galeri</h1>
    <a class="btn btn-main" href="{{ route('cms.gallery.create') }}">Tambah Item</a>
</section>

<section class="panel">
    <table class="table">
        <thead><tr><th>Judul</th><th>Featured</th><th>Urutan</th><th>Tanggal</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($items as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->is_featured ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $item->sort_order }}</td>
                <td>{{ optional($item->captured_at)->format('d M Y') }}</td>
                <td style="display:flex;gap:8px;">
                    <a class="btn btn-ghost" href="{{ route('cms.gallery.edit', $item) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.gallery.destroy', $item) }}" onsubmit="return confirm('Hapus item ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada item galeri.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $items->links() }}</div>
</section>
@endsection
