@extends('views.layouts.cms')

@section('title', 'Struktur Organisasi')

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
    <div>
        <h1 style="margin:0;">Struktur Organisasi</h1>
        <p style="margin:6px 0 0;color:#607285;font-size:13.5px;">Kelompokkan kepengurusan (mis. "Pos Pelayanan Terpadu" dan "Pengurus RW.09"), lalu isi anggota di masing-masing kelompok.</p>
    </div>
    <a class="btn btn-main" href="{{ route('cms.struktur.create') }}">Tambah Kelompok</a>
</section>

<section class="panel">
    <table class="table">
        <thead><tr><th>Nama Kelompok</th><th>Keterangan</th><th>Anggota</th><th>Urutan</th><th>Aktif</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($groups as $group)
            <tr>
                <td>{{ $group->title }}</td>
                <td>{{ $group->description }}</td>
                <td>{{ $group->members_count }} orang</td>
                <td>{{ $group->sort_order }}</td>
                <td>{{ $group->is_active ? 'Ya' : 'Tidak' }}</td>
                <td style="display:flex;gap:8px;flex-wrap:wrap;">
                    <a class="btn btn-main" href="{{ route('cms.struktur.members.index', $group) }}">Kelola Anggota</a>
                    <a class="btn btn-ghost" href="{{ route('cms.struktur.edit', $group) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.struktur.destroy', $group) }}" onsubmit="return confirm('Hapus kelompok ini beserta pindah anggotanya ke Sampah?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada kelompok struktur. Klik "Tambah Kelompok" untuk mulai.</td></tr>
        @endforelse
        </tbody>
    </table>
</section>
@endsection
