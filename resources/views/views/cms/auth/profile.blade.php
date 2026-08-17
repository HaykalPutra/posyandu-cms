@extends('views.layouts.cms')

@section('title', 'Profil Admin')

@section('content')
<section class="panel" style="max-width:760px;">
    <h1 style="margin:0 0 6px;">Profil Admin</h1>
    <p style="margin:0 0 16px;color:#607285;">Ubah ID login admin, nama tampilan, email, dan password dari halaman ini.</p>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cms.profile.update') }}" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')

        <div>
            <label>Nama Admin</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div>
            <label>ID Admin</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" required>
        </div>

        <div style="grid-column:1/-1;">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div>
            <label>Password Baru</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">
        </div>

        <div>
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" placeholder="Ulangi password baru">
        </div>

        <div class="panel" style="grid-column:1/-1;background:#f8fbfd;padding:14px;">
            <strong style="display:block;margin-bottom:6px;">Info</strong>
            <span style="color:#607285;">Setelah ID atau password diganti, gunakan data baru itu untuk login CMS berikutnya.</span>
        </div>

        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan Perubahan</button>
            <a class="btn btn-ghost" href="{{ route('cms.dashboard') }}">Kembali</a>
        </div>
    </form>
</section>
@endsection
