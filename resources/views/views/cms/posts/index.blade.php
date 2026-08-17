@extends('views.layouts.cms')

@section('title', 'Kelola Berita')

@section('content')
<section class="panel" style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:10px;">
    <h1 style="margin:0;">Berita</h1>
    <a class="btn btn-main" href="{{ route('cms.posts.create') }}">Tambah Berita</a>
</section>

<section class="panel">
    <table class="table">
        <thead><tr><th>Judul</th><th>Kategori</th><th>Publish</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->category ?: '-' }}</td>
                <td>{{ optional($post->published_at)->format('d M Y') }}</td>
                <td>{{ $post->is_published ? 'Publish' : 'Draft' }}</td>
                <td style="display:flex;gap:8px;">
                    <a class="btn btn-ghost" href="{{ route('cms.posts.edit', $post) }}">Edit</a>
                    <form method="POST" action="{{ route('cms.posts.destroy', $post) }}" onsubmit="return confirm('Hapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">Belum ada berita.</td></tr>
        @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">{{ $posts->links() }}</div>
</section>
@endsection
