<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CMS Posyandu')</title>
    <style>
        :root {
            --bg: #f2f5f8;
            --surface: #fff;
            --ink: #172635;
            --muted: #607285;
            --line: #d5dde6;
            --brand: #195f46;
            --danger: #bf3246;
        }
        * { box-sizing: border-box; }
        body { margin: 0; background: var(--bg); color: var(--ink); font: 500 15px/1.55 Manrope, Segoe UI, sans-serif; }
        a { color: inherit; text-decoration: none; }
        .wrap { width: min(1160px, calc(100% - 2rem)); margin: 0 auto; }
        .bar { position: sticky; top: 0; z-index: 50; background: rgba(255,255,255,.92); backdrop-filter: blur(8px); border-bottom: 1px solid var(--line); }
        .bar-inner { display: flex; align-items: center; justify-content: space-between; gap: 12px; min-height: 66px; }
        .links { display: flex; flex-wrap: wrap; gap: 8px; }
        .links a { padding: 8px 12px; border-radius: 999px; color: var(--muted); font-weight: 700; font-size: 13px; }
        .links a.active, .links a:hover { background: #e8f1ec; color: var(--brand); }
        .panel { background: var(--surface); border: 1px solid var(--line); border-radius: 14px; padding: 20px; }
        .grid { display: grid; gap: 14px; }
        .stats { grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); }
        input, textarea { width: 100%; border: 1px solid var(--line); border-radius: 10px; padding: 10px 12px; font: inherit; }
        textarea { min-height: 160px; resize: vertical; }
        .btn { border: none; border-radius: 10px; padding: 10px 14px; font-weight: 700; cursor: pointer; }
        .btn-main { background: var(--brand); color: #fff; }
        .btn-ghost { background: #ebf0f5; color: #294357; }
        .btn-danger { background: #f7e7ea; color: var(--danger); }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border-bottom: 1px solid var(--line); padding: 10px 8px; text-align: left; vertical-align: top; }
        .alert { padding: 10px 12px; border-radius: 10px; margin-bottom: 12px; }
        .alert-success { background: #e7f4eb; color: #1f5f40; }
        .alert-error { background: #f8e7ea; color: #8d1f32; }
    </style>
</head>
<body>
    <header class="bar">
        <div class="wrap bar-inner">
            <a href="{{ route('cms.dashboard') }}" aria-label="Dashboard CMS">
                <img src="{{ asset('storage/images/Posyandu.png') }}" alt="Logo Posyandu" style="height:42px;width:auto;object-fit:contain;display:block;">
            </a>
            <nav class="links">
                <a href="{{ route('cms.dashboard') }}" class="{{ request()->routeIs('cms.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('cms.pages.index') }}" class="{{ request()->routeIs('cms.pages.*') ? 'active' : '' }}">Halaman</a>
                <a href="{{ route('cms.posts.index') }}" class="{{ request()->routeIs('cms.posts.*') ? 'active' : '' }}">Berita</a>
                <a href="{{ route('cms.gallery.index') }}" class="{{ request()->routeIs('cms.gallery.*') ? 'active' : '' }}">Galeri</a>
                <a href="{{ route('cms.settings.edit') }}" class="{{ request()->routeIs('cms.settings.*') ? 'active' : '' }}">Pengaturan Situs</a>
                <a href="{{ route('cms.profile') }}" class="{{ request()->routeIs('cms.profile*') ? 'active' : '' }}">Profil</a>
                <a href="{{ route('beranda') }}">Lihat Situs</a>
                <form method="POST" action="{{ route('cms.logout') }}" style="display:inline;">@csrf<button class="btn btn-danger" type="submit">Logout</button></form>
            </nav>
        </div>
    </header>

    <main class="wrap" style="padding:20px 0 32px;">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
