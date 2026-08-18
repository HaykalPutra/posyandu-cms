<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'CMS Posyandu')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand: #1f7a53;
            --brand-dark: #175c3e;
            --brand-light: #dff3e8;
            --accent: #b6763f;
            --accent-light: #f5e8dc;
            --bg: #eef8f5;
            --surface: #ffffff;
            --surface-muted: #f6fbf8;
            --ink: #16352a;
            --muted: #5d7b6c;
            --line: #d9e8e0;
            --danger: #bf3246;
            --danger-bg: #fdecee;
            --success: #1f7a53;
            --success-bg: #dff3e8;
            --shadow-sm: 0 2px 10px rgba(22, 53, 42, 0.06);
            --shadow-md: 0 12px 32px rgba(22, 53, 42, 0.10);
            --sidebar-w: 264px;
            --sidebar-w-collapsed: 78px;
            --ease: cubic-bezier(0.22, 1, 0.36, 1);
        }

        * { box-sizing: border-box; }

        html { scroll-behavior: smooth; }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--ink);
            font: 500 15px/1.55 Manrope, "Segoe UI", sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        a { color: inherit; text-decoration: none; }
        button { font-family: inherit; }

        h1, h2, h3 { font-family: Fraunces, Georgia, serif; font-weight: 600; letter-spacing: -0.01em; }

        /* ===== Shell layout ===== */
        .cms-shell { display: flex; min-height: 100vh; }

        /* ===== Sidebar =====
           Gradient now built directly from the same --brand / --brand-dark
           tokens used everywhere else in the CMS (buttons, stat numbers,
           chips) so the sidebar reads as one color family instead of a
           mismatched dark-forest tone. */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            background: linear-gradient(180deg, var(--brand-dark) 0%, var(--brand) 100%);
            color: #eaf6f0;
            display: flex;
            flex-direction: column;
            z-index: 40;
            transition: width 260ms var(--ease);
            overflow: hidden;
        }

        .sidebar.collapsed { width: var(--sidebar-w-collapsed); }

        .sidebar-head {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 16px;
            border-bottom: 1px solid rgba(255,255,255,0.14);
            min-height: 78px;
        }

        .brand { display: flex; align-items: center; gap: 12px; min-width: 0; flex: 1; }

        .brand img {
            height: 38px; width: 38px; object-fit: contain; border-radius: 10px;
            background: rgba(255,255,255,0.95); padding: 4px; flex-shrink: 0;
        }

        .brand-text { min-width: 0; white-space: nowrap; transition: opacity 180ms ease, width 180ms ease; }
        .brand-text strong { display: block; font-family: Fraunces, serif; font-size: 15px; line-height: 1.2; }
        .brand-text span { display: block; font-size: 11.5px; color: rgba(234,246,240,0.72); font-weight: 600; letter-spacing: 0.02em; }

        .sidebar.collapsed .brand-text { opacity: 0; width: 0; overflow: hidden; }

        .collapse-btn {
            width: 30px; height: 30px; border-radius: 999px; border: none;
            background: rgba(255,255,255,0.14); color: #eaf6f0; cursor: pointer;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            transition: background 160ms ease, transform 260ms var(--ease);
        }
        .collapse-btn:hover { background: rgba(255,255,255,0.24); }
        .sidebar.collapsed .collapse-btn { transform: rotate(180deg); }
        .collapse-btn .material-symbols-outlined { font-size: 18px; }

        .sidebar-nav {
            position: relative;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 16px 12px;
        }
        .sidebar-nav::-webkit-scrollbar { width: 5px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.18); border-radius: 999px; }

        .nav-group-label {
            font-size: 10.5px; font-weight: 800; letter-spacing: 0.09em; text-transform: uppercase;
            color: rgba(234,246,240,0.55); margin: 18px 12px 8px; white-space: nowrap;
            transition: opacity 160ms ease;
        }
        .nav-group-label:first-child { margin-top: 4px; }
        .sidebar.collapsed .nav-group-label { opacity: 0; }

        .nav-indicator {
            position: absolute; left: 12px; width: calc(100% - 24px);
            height: 42px; border-radius: 12px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.28);
            box-shadow: 0 8px 20px rgba(10, 30, 22, 0.18);
            transition: transform 320ms var(--ease), opacity 200ms ease;
            opacity: 0;
            pointer-events: none;
            z-index: 0;
        }

        .nav-link {
            position: relative; z-index: 1;
            display: flex; align-items: center; gap: 13px;
            padding: 11px 12px; margin-bottom: 3px;
            border-radius: 12px; color: rgba(234,246,240,0.85);
            font-weight: 700; font-size: 13.5px; white-space: nowrap;
            transition: color 200ms ease, background 200ms ease;
            border: none; background: transparent; width: 100%; text-align: left; cursor: pointer;
        }
        .nav-link:hover { color: #fff; background: rgba(255,255,255,0.09); }
        .nav-link.active { color: #fff; }
        .nav-link .material-symbols-outlined { font-size: 20px; flex-shrink: 0; }
        .nav-link .nav-label { transition: opacity 160ms ease; }
        .sidebar.collapsed .nav-label { opacity: 0; width: 0; overflow: hidden; }

        .sidebar-foot {
            padding: 12px; border-top: 1px solid rgba(255,255,255,0.14);
        }
        .nav-link-danger:hover { background: rgba(191, 50, 70, 0.30); color: #ffd7dc; }

        .sidebar-backdrop {
            display: none; position: fixed; inset: 0; background: rgba(11, 27, 20, 0.5);
            z-index: 39; opacity: 0; transition: opacity 220ms ease;
        }

        /* ===== Main column ===== */
        .cms-main { flex: 1; min-width: 0; display: flex; flex-direction: column; }

        .topbar {
            position: sticky; top: 0; z-index: 30;
            display: flex; align-items: center; justify-content: space-between; gap: 14px;
            padding: 16px 28px; background: rgba(238, 248, 245, 0.85);
            backdrop-filter: blur(10px); border-bottom: 1px solid var(--line);
        }
        .topbar-title h1 { margin: 0; font-size: 21px; color: var(--ink); }
        .topbar-actions { display: flex; align-items: center; gap: 10px; }

        .hamburger {
            display: none; flex-direction: column; justify-content: center; gap: 4px;
            width: 36px; height: 36px; border-radius: 10px; border: 1px solid var(--line);
            background: var(--surface); cursor: pointer; padding: 0 8px;
        }
        .hamburger span { display: block; height: 2px; background: var(--ink); border-radius: 2px; transition: transform 220ms ease, opacity 220ms ease; }
        .hamburger.is-open span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
        .hamburger.is-open span:nth-child(2) { opacity: 0; }
        .hamburger.is-open span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

        .topbar-chip {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--brand-light); color: var(--brand-dark);
            border-radius: 999px; padding: 8px 13px; font-size: 12.5px; font-weight: 800;
        }
        .topbar-chip .material-symbols-outlined { font-size: 16px; }

        .content-area { padding: 26px 28px 48px; max-width: 1200px; width: 100%; margin: 0 auto; }

        /* ===== Shared component styles (used across CMS pages) ===== */
        .panel {
            background: var(--surface); border: 1px solid var(--line);
            border-radius: 18px; padding: 22px;
            box-shadow: var(--shadow-sm);
        }
        .panel + .panel { margin-top: 16px; }

        .grid { display: grid; gap: 14px; }
        .stats { grid-template-columns: repeat(auto-fit, minmax(170px, 1fr)); }
        .stats .panel strong { color: var(--muted); font-size: 12.5px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.04em; }
        .stats .panel div { font-family: Fraunces, serif; color: var(--brand-dark); }

        /* Clickable stat cards */
        a.panel.stat-card {
            display: block;
            transition: transform 200ms var(--ease), box-shadow 200ms ease, border-color 200ms ease;
        }
        a.panel.stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
            border-color: rgba(31, 122, 83, 0.35);
        }
        a.panel.stat-card:active { transform: translateY(-1px) scale(0.99); }
        .stat-card-foot {
            display: flex; align-items: center; gap: 4px;
            margin-top: 10px; font-size: 12px; font-weight: 800; color: var(--brand);
        }
        .stat-card-foot .material-symbols-outlined { font-size: 15px; transition: transform 200ms var(--ease); }
        a.panel.stat-card:hover .stat-card-foot .material-symbols-outlined { transform: translateX(3px); }

        label { display: block; margin: 4px 0 7px; font-size: 12.5px; font-weight: 800; color: #335748; }

        input, textarea, select {
            width: 100%; border: 1px solid var(--line); background: var(--surface-muted);
            border-radius: 12px; padding: 11px 13px; font: 600 14.5px/1.4 Manrope, sans-serif;
            color: var(--ink); outline: none;
            transition: border-color 160ms ease, box-shadow 160ms ease, background 160ms ease;
        }
        textarea { min-height: 150px; resize: vertical; }
        input:focus, textarea:focus, select:focus {
            border-color: rgba(31, 122, 83, 0.5); box-shadow: 0 0 0 4px rgba(31, 122, 83, 0.12); background: #fff;
        }
        input[type="checkbox"] { width: auto; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            border: none; border-radius: 12px; padding: 11px 16px;
            font-weight: 800; font-size: 13.5px; cursor: pointer;
            transition: transform 160ms var(--ease), box-shadow 160ms ease, background 160ms ease;
        }
        .btn:active { transform: scale(0.97); }
        .btn-main { background: linear-gradient(135deg, var(--brand), #24855b); color: #fff; box-shadow: 0 10px 22px rgba(31, 122, 83, 0.22); }
        .btn-main:hover { box-shadow: 0 14px 28px rgba(31, 122, 83, 0.3); transform: translateY(-1px); }
        .btn-ghost { background: var(--surface-muted); color: var(--brand-dark); border: 1px solid var(--line); }
        .btn-ghost:hover { background: var(--brand-light); }
        .btn-danger { background: var(--danger-bg); color: var(--danger); }
        .btn-danger:hover { background: #fbdde1; }

        .table { width: 100%; border-collapse: collapse; }
        .table th {
            text-align: left; font-size: 11.5px; font-weight: 800; text-transform: uppercase;
            letter-spacing: 0.04em; color: var(--muted); padding: 10px 10px; border-bottom: 2px solid var(--line);
        }
        .table td { border-bottom: 1px solid var(--line); padding: 12px 10px; vertical-align: top; font-size: 14px; }
        .table tbody tr { transition: background 140ms ease; }
        .table tbody tr:hover { background: var(--surface-muted); }

        .alert {
            padding: 12px 15px; border-radius: 13px; margin-bottom: 14px;
            font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 9px;
            animation: alertIn 320ms var(--ease);
        }
        .alert-success { background: var(--success-bg); color: #175c3e; }
        .alert-error { background: var(--danger-bg); color: #8d1f32; }

        @keyframes alertIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Page-load reveal for direct content blocks */
        .reveal-block {
            opacity: 0; transform: translateY(14px);
            animation: revealUp 480ms var(--ease) forwards;
        }
        @keyframes revealUp {
            to { opacity: 1; transform: translateY(0); }
        }

        @media (prefers-reduced-motion: reduce) {
            * { animation-duration: 0.001ms !important; transition-duration: 0.001ms !important; }
        }

        /* ===== Mobile ===== */
        @media (max-width: 960px) {
            .hamburger { display: flex; }
            .sidebar {
                position: fixed; top: 0; left: 0; height: 100vh; width: min(280px, 84vw);
                transform: translateX(-100%);
                transition: transform 280ms var(--ease);
                box-shadow: var(--shadow-md);
            }
            .sidebar.mobile-open { transform: translateX(0); }
            .sidebar.collapsed { width: min(280px, 84vw); }
            .sidebar.collapsed .brand-text,
            .sidebar.collapsed .nav-label,
            .sidebar.collapsed .nav-group-label { opacity: 1; width: auto; }
            .collapse-btn { display: none; }
            .sidebar-backdrop.is-visible { display: block; opacity: 1; }
            .content-area { padding: 20px 16px 40px; }
            .topbar { padding: 14px 16px; }
            .topbar-title h1 { font-size: 18px; }
        }
    </style>
</head>
<body>
    <div class="cms-shell">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-head">
                <a href="{{ route('cms.dashboard') }}" class="brand">
                    <img src="{{ asset('storage/images/Posyandu.png') }}" alt="Logo Posyandu">
                    <span class="brand-text">
                        <strong>CMS Posyandu</strong>
                        <span>Panel Admin</span>
                    </span>
                </a>
                <button class="collapse-btn" id="collapseBtn" type="button" aria-label="Ciutkan sidebar">
                    <span class="material-symbols-outlined">chevron_left</span>
                </button>
            </div>

            <nav class="sidebar-nav" id="sidebarNav">
                <div class="nav-indicator" id="navIndicator"></div>

                <p class="nav-group-label">Konten</p>
                <a href="{{ route('cms.dashboard') }}" class="nav-link {{ request()->routeIs('cms.dashboard') ? 'active' : '' }}" title="Dashboard">
                    <span class="material-symbols-outlined">space_dashboard</span><span class="nav-label">Dashboard</span>
                </a>
                <a href="{{ route('cms.pages.index') }}" class="nav-link {{ request()->routeIs('cms.pages.*') ? 'active' : '' }}" title="Halaman">
                    <span class="material-symbols-outlined">description</span><span class="nav-label">Halaman</span>
                </a>
                <a href="{{ route('cms.posts.index') }}" class="nav-link {{ request()->routeIs('cms.posts.*') ? 'active' : '' }}" title="Berita">
                    <span class="material-symbols-outlined">article</span><span class="nav-label">Berita</span>
                </a>
                <a href="{{ route('cms.gallery.index') }}" class="nav-link {{ request()->routeIs('cms.gallery.*') ? 'active' : '' }}" title="Galeri">
                    <span class="material-symbols-outlined">photo_library</span><span class="nav-label">Galeri</span>
                </a>
                <a href="{{ route('cms.carousel.index') }}" class="nav-link {{ request()->routeIs('cms.carousel.*') ? 'active' : '' }}" title="Carousel Beranda">
                    <span class="material-symbols-outlined">view_carousel</span><span class="nav-label">Carousel Beranda</span>
                </a>
                <a href="{{ route('cms.schedules.index') }}" class="nav-link {{ request()->routeIs('cms.schedules.*') ? 'active' : '' }}" title="Jadwal">
                    <span class="material-symbols-outlined">event</span><span class="nav-label">Jadwal</span>
                </a>
                <a href="{{ route('cms.home-stats.index') }}" class="nav-link {{ request()->routeIs('cms.home-stats.*') ? 'active' : '' }}" title="Statistik Beranda">
                    <span class="material-symbols-outlined">monitoring</span><span class="nav-label">Statistik Beranda</span>
                </a>

                <p class="nav-group-label">Pengaturan</p>
                <a href="{{ route('cms.settings.edit') }}" class="nav-link {{ request()->routeIs('cms.settings.*') ? 'active' : '' }}" title="Pengaturan Situs">
                    <span class="material-symbols-outlined">settings</span><span class="nav-label">Pengaturan Situs</span>
                </a>
                <a href="{{ route('cms.profile') }}" class="nav-link {{ request()->routeIs('cms.profile*') ? 'active' : '' }}" title="Profil Saya">
                    <span class="material-symbols-outlined">account_circle</span><span class="nav-label">Profil Saya</span>
                </a>
                <a href="{{ route('cms.trash.index') }}" class="nav-link {{ request()->routeIs('cms.trash.*') ? 'active' : '' }}" title="Sampah">
                    <span class="material-symbols-outlined">delete</span><span class="nav-label">Sampah</span>
                </a>
            </nav>

            <div class="sidebar-foot">
                <a href="{{ route('beranda') }}" target="_blank" class="nav-link" title="Lihat Situs">
                    <span class="material-symbols-outlined">open_in_new</span><span class="nav-label">Lihat Situs</span>
                </a>
                <form method="POST" action="{{ route('cms.logout') }}">
                    @csrf
                    <button type="submit" class="nav-link nav-link-danger" title="Logout">
                        <span class="material-symbols-outlined">logout</span><span class="nav-label">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

        <div class="cms-main">
            <header class="topbar">
                <div style="display:flex;align-items:center;gap:12px;min-width:0;">
                    <button class="hamburger" id="hamburgerBtn" type="button" aria-label="Buka menu">
                        <span></span><span></span><span></span>
                    </button>
                    <div class="topbar-title">
                        <h1>@yield('title', 'CMS Posyandu')</h1>
                    </div>
                </div>
                <div class="topbar-actions">
                    <span class="topbar-chip">
                        <span class="material-symbols-outlined">favorite</span>
                        {{ auth()->user()->name ?? 'Admin' }}
                    </span>
                </div>
            </header>

            <main class="content-area" id="contentArea">
                @if (session('success'))
                    <div class="alert alert-success">
                        <span class="material-symbols-outlined">check_circle</span>{{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error">
                        <span class="material-symbols-outlined">error</span>{{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
    (function () {
        var sidebar = document.getElementById('sidebar');
        var collapseBtn = document.getElementById('collapseBtn');
        var hamburgerBtn = document.getElementById('hamburgerBtn');
        var backdrop = document.getElementById('sidebarBackdrop');
        var nav = document.getElementById('sidebarNav');
        var indicator = document.getElementById('navIndicator');

        // Desktop collapse (persisted)
        if (localStorage.getItem('cmsSidebarCollapsed') === '1') {
            sidebar.classList.add('collapsed');
        }
        collapseBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
            localStorage.setItem('cmsSidebarCollapsed', sidebar.classList.contains('collapsed') ? '1' : '0');
            requestAnimationFrame(positionIndicator);
        });

        // Mobile toggle
        function openMobile() {
            sidebar.classList.add('mobile-open');
            backdrop.classList.add('is-visible');
            hamburgerBtn.classList.add('is-open');
        }
        function closeMobile() {
            sidebar.classList.remove('mobile-open');
            backdrop.classList.remove('is-visible');
            hamburgerBtn.classList.remove('is-open');
        }
        hamburgerBtn.addEventListener('click', function () {
            sidebar.classList.contains('mobile-open') ? closeMobile() : openMobile();
        });
        backdrop.addEventListener('click', closeMobile);

        // Sliding active indicator
        function positionIndicator() {
            var active = nav.querySelector('.nav-link.active');
            if (!active) { indicator.style.opacity = 0; return; }
            indicator.style.opacity = 1;
            indicator.style.transform = 'translateY(' + active.offsetTop + 'px)';
        }
        positionIndicator();
        window.addEventListener('resize', positionIndicator);

        // Staggered reveal for content blocks
        var blocks = document.querySelectorAll('#contentArea > *');
        blocks.forEach(function (el, i) {
            el.classList.add('reveal-block');
            el.style.animationDelay = (i * 60) + 'ms';
        });
    })();
    </script>
</body>
</html>
