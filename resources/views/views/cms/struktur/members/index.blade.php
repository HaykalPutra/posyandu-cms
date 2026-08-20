@extends('views.layouts.cms')

@section('title', 'Anggota - ' . $group->title)

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;">
    <div>
        <p style="margin:0 0 4px;"><a href="{{ route('cms.struktur.index') }}" style="color:#607285;font-size:13px;">&larr; Semua Kelompok</a></p>
        <h1 style="margin:0;">{{ $group->title }}</h1>
    </div>
    <a class="btn btn-main" href="{{ route('cms.struktur.members.create', $group) }}">Tambah Anggota</a>
</section>

<section class="panel">
    <table class="table">
        <thead><tr><th>Foto</th><th>Nama</th><th>Jabatan</th><th>Urutan</th><th>Aktif</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($members as $member)
            <tr>
                <td>
                    @if($member->photoSrc())
                        <img src="{{ $member->photoSrc() }}" alt="{{ $member->name }}" style="width:40px;height:40px;border-radius:999px;object-fit:cover;">
                    @else
                        <div style="width:40px;height:40px;border-radius:999px;background:{{ $member->avatarColor() }};color:#fff;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:13px;">{{ $member->initials() }}</div>
                    @endif
                </td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->position }}</td>
                <td>{{ $member->sort_order }}</td>
                <td>{{ $member->is_active ? 'Ya' : 'Tidak' }}</td>
                <td style="display:flex;gap:8px;">
                    <a class="btn btn-ghost" href="{{ route('cms.struktur.members.edit', [$group, $member]) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.struktur.members.destroy', [$group, $member]) }}" onsubmit="return confirm('Hapus anggota ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada anggota di kelompok ini.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $members->links() }}</div>
</section>
@endsection
