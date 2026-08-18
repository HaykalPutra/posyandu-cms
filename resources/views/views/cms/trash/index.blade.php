@extends('views.layouts.cms')

@section('title', 'Sampah')

@section('content')
<section class="panel">
    <h2 style="margin:0 0 6px;">Sampah</h2>
    <p style="margin:0 0 18px;color:#5d7b6c;">
        Data yang dihapus disimpan di sini dulu, belum hilang permanen. Pulihkan kalau salah hapus,
        atau hapus permanen kalau memang sudah tidak dibutuhkan lagi. Menampilkan maksimal 50 item terbaru per kategori.
    </p>

    @foreach ($groups as $key => $group)
        <div style="margin-bottom:26px;">
            <h3 style="margin:0 0 10px;font-size:16px;">{{ $group['label'] }} ({{ $group['items']->count() }})</h3>

            @if ($group['items']->isEmpty())
                <p style="color:#5d7b6c;font-size:13.5px;margin:0 0 4px;">Tidak ada {{ strtolower($group['label']) }} di sampah.</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Dihapus</th>
                            <th style="width:220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($group['items'] as $item)
                            <tr>
                                <td>{{ $item->{$group['title_field']} ?: '(tanpa judul)' }}</td>
                                <td>{{ $item->deleted_at?->format('d M Y H:i') }}</td>
                                <td>
                                    <div style="display:flex;gap:8px;flex-wrap:wrap;">
                                        <form method="POST" action="{{ route('cms.trash.restore', [$key, $item->id]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-ghost">Pulihkan</button>
                                        </form>
                                        <form method="POST" action="{{ route('cms.trash.force-delete', [$key, $item->id]) }}"
                                              onsubmit="return confirm('Hapus permanen? Data dan foto terkait tidak bisa dikembalikan lagi.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus Permanen</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endforeach
</section>
@endsection
