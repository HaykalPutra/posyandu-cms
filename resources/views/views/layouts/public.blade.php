<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Posyandu Palem')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Fraunces:opsz,wght@9..144,500;9..144,700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f6f8f5;
            --surface: #ffffff;
            --line: #d8e2d7;
            --ink: #102218;
            --muted: #4a6555;
            --brand: #1f7a53;
            --brand-soft: #dff6e8;
            --accent: #bb6b3d;
            --radius: 18px;
            --shadow: 0 12px 40px rgba(22, 54, 36, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--ink);
            background:
                radial-gradient(circle at 10% 0%, rgba(31, 122, 83, 0.15), transparent 40%),
                radial-gradient(circle at 100% 20%, rgba(187, 107, 61, 0.15), transparent 40%),
                var(--bg);
            font-family: Manrope, sans-serif;
            line-height: 1.65;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1120px, calc(100% - 2.2rem));
            margin: 0 auto;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(8px);
            background: rgba(246, 248, 245, 0.85);
            border-bottom: 1px solid rgba(216, 226, 215, 0.8);
        }

        .topbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 74px;
            gap: 16px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 800;
            letter-spacing: 0.2px;
        }

        .brand-dot {
            width: 16px;
            height: 16px;
            border-radius: 99px;
            background: linear-gradient(135deg, var(--brand), #34b77a);
            box-shadow: 0 0 0 4px rgba(31, 122, 83, 0.14);
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .menu a {
            padding: 8px 12px;
            border-radius: 999px;
            color: var(--muted);
            font-weight: 600;
            font-size: 14px;
            transition: 220ms ease;
        }

        .menu a.active,
        .menu a:hover {
            background: var(--brand-soft);
            color: var(--brand);
            transform: translateY(-1px);
        }

        .section {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }

        .hero {
            margin-top: 26px;
            padding: 42px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 380px;
            height: 380px;
            border-radius: 999px;
            right: -120px;
            top: -150px;
            background: radial-gradient(circle, rgba(31, 122, 83, 0.2), transparent 70%);
            pointer-events: none;
        }

        h1, h2, h3 {
            margin: 0;
            line-height: 1.2;
        }

        h1 {
            font-family: Fraunces, serif;
            font-size: clamp(30px, 4vw, 50px);
            max-width: 14ch;
        }

        .lead {
            color: var(--muted);
            max-width: 60ch;
            margin-top: 14px;
            font-size: clamp(15px, 2vw, 18px);
        }

        .grid {
            margin-top: 20px;
            display: grid;
            gap: 16px;
            grid-template-columns: repeat(12, minmax(0, 1fr));
        }

        .card {
            padding: 22px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: #fff;
        }

        .chip {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 999px;
            background: #eef3ee;
            color: #2e4e3b;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
            text-transform: uppercase;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--brand);
            color: #fff;
            padding: 12px 18px;
            border-radius: 999px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            transition: 220ms ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            background: #186341;
        }

        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 550ms ease, transform 550ms ease;
        }

        .reveal.in {
            opacity: 1;
            transform: translateY(0);
        }

        footer {
            margin: 42px 0 36px;
            color: #537160;
            font-size: 14px;
        }

        @media (max-width: 880px) {
            .hero {
                padding: 28px;
            }

            .topbar-inner {
                flex-direction: column;
                align-items: flex-start;
                padding: 10px 0;
            }

            .menu {
                width: 100%;
                justify-content: flex-start;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .reveal {
                opacity: 1;
                transform: none;
                transition: none;
            }

            .menu a,
            .btn {
                transition: none;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container topbar-inner">
            <a class="brand" href="{{ route('beranda') }}">
                <span class="brand-dot"></span>
                <span>Posyandu Palem</span>
            </a>
            <nav class="menu">
                <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('berita') }}" class="{{ request()->routeIs('berita') ? 'active' : '' }}">Berita</a>
                <a href="{{ route('galeri') }}" class="{{ request()->routeIs('galeri') ? 'active' : '' }}">Galeri</a>
                <a href="{{ route('dokumentasi') }}" class="{{ request()->routeIs('dokumentasi') ? 'active' : '' }}">Dokumentasi</a>
                <a href="{{ route('struktur') }}" class="{{ request()->routeIs('struktur') ? 'active' : '' }}">Struktur</a>
                <a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">Tentang</a>
                <a href="{{ route('lokasi') }}" class="{{ request()->routeIs('lokasi') ? 'active' : '' }}">Lokasi</a>
                <a href="{{ route('cms.login') }}">CMS</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="container">
        <div class="section card">
            <strong>Posyandu Palem</strong> · Layanan promotif dan preventif untuk ibu, bayi, balita, serta lansia.
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            document.querySelectorAll('.reveal').forEach(function (item) {
                observer.observe(item);
            });
        });
    </script>
</body>
</html>
