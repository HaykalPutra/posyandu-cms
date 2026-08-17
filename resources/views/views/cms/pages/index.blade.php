@extends('views.layouts.cms')

@section('title', 'Kelola Halaman')

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
    <div>
        <h1 style="margin:0;">Halaman Website</h1>
        <p style="margin:6px 0 0;color:#607285;">Kelola halaman per menu website: Beranda, Berita, Galeri, Dokumentasi, Struktur, Tentang, dan Lokasi.</p>
    </div>
    <a class="btn btn-main" href="{{ route('cms.pages.create') }}">Tambah Halaman</a>
</section>

<section class="panel">
    <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(220px,1fr));margin-bottom:18px;">
        @foreach($pages as $page)
            @if(in_array($page->slug, $defaultSlugs, true))
                <article class="panel" style="padding:16px;background:#f9fcfb;">
                    <div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;">
                        <div>
                            <strong style="display:block;font-size:16px;">{{ $page->nav_label }}</strong>
                            <span style="color:#607285;font-size:13px;">/{{ $page->slug }}</span>
                        </div>
                        <span style="font-size:12px;padding:4px 8px;border-radius:999px;background:{{ $page->is_published ? '#e7f4eb' : '#f8e7ea' }};color:{{ $page->is_published ? '#1f5f40' : '#8d1f32' }};font-weight:700;">
                            {{ $page->is_published ? 'Publish' : 'Draft' }}
                        </span>
                    </div>
                    <p style="margin:10px 0 0;color:#607285;min-height:42px;">{{ $page->title }}</p>
                    <div style="display:flex;gap:8px;margin-top:12px;flex-wrap:wrap;">
                        <a class="btn btn-main" href="{{ route('cms.pages.edit', $page) }}">Edit Halaman</a>
                        <form method="POST" action="{{ route('cms.pages.destroy', $page) }}" onsubmit="return confirm('Hapus halaman ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Hapus</button>
                        </form>
                    </div>
                </article>
            @endif
        @endforeach
    </div>

    <h2 style="margin:0 0 12px;">Semua Halaman</h2>
    <table class="table">
        <thead><tr><th>Menu</th><th>Slug</th><th>Judul</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($pages as $page)
            <tr>
                <td>{{ $page->nav_label }}</td>
                <td>{{ $page->slug }}</td>
                <td>{{ $page->title }}</td>
                <td>{{ $page->sort_order }}</td>
                <td>{{ $page->is_published ? 'Publish' : 'Draft' }}</td>
                <td style="display:flex;gap:8px;">
                    <a class="btn btn-ghost" href="{{ route('cms.pages.edit', $page) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.pages.destroy', $page) }}" onsubmit="return confirm('Hapus halaman ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada halaman.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $pages->links() }}</div>
</section>
@endsection
