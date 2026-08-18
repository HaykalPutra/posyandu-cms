<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Posyandu Kita')</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    :root {
        --page-transition-duration: 320ms;
        --reveal-duration: 700ms;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background-image:
            radial-gradient(circle at 10% 10%, rgba(112, 216, 200, 0.14) 0%, transparent 38%),
            radial-gradient(circle at 90% 20%, rgba(139, 74, 54, 0.1) 0%, transparent 30%);
    }

    .page-shell {
        opacity: 0;
        transform: translateY(12px);
        transition: opacity var(--page-transition-duration) ease, transform var(--page-transition-duration) ease;
    }

    body.page-ready .page-shell {
        opacity: 1;
        transform: translateY(0);
    }

    body.page-leaving .page-shell {
        opacity: 0;
        transform: translateY(10px);
    }

    .reveal-item {
        opacity: 0;
        transform: translateY(24px) scale(0.985);
        transition: opacity var(--reveal-duration) ease, transform var(--reveal-duration) cubic-bezier(0.2, 0.7, 0.2, 1);
        transition-delay: var(--reveal-delay, 0ms);
        will-change: transform, opacity;
    }

    .reveal-item.revealed {
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    @media (prefers-reduced-motion: reduce) {
        .page-shell,
        .reveal-item {
            transition: none !important;
            transform: none !important;
            opacity: 1 !important;
        }
    }
</style>

@stack('styles')
</head>
<body class="@yield('body-class', 'bg-background text-on-background antialiased min-h-screen flex flex-col font-body-md')">
    <div class="page-shell">
        @yield('content')
    </div>
    @include('views.partials.whatsapp-bubble')
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.body.classList.add('page-ready');

            var candidates = document.querySelectorAll('main section, main article, main > div, footer > div > div, nav, header');

            candidates.forEach(function (el, index) {
                if (el.classList.contains('reveal-item')) {
                    return;
                }

                el.classList.add('reveal-item');
                el.style.setProperty('--reveal-delay', (index % 8) * 70 + 'ms');
            });

            var observer = new IntersectionObserver(function (entries, obs) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal-item').forEach(function (el) {
                observer.observe(el);
            });

            document.querySelectorAll('a[href]').forEach(function (link) {
                link.addEventListener('click', function (event) {
                    var href = link.getAttribute('href') || '';
                    var target = link.getAttribute('target');

                    if (event.defaultPrevented || target === '_blank' || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) {
                        return;
                    }

                    try {
                        var destination = new URL(link.href, window.location.origin);
                        if (destination.origin !== window.location.origin || destination.pathname === window.location.pathname) {
                            return;
                        }
                    } catch (e) {
                        return;
                    }

                    event.preventDefault();
                    document.body.classList.add('page-leaving');

                    setTimeout(function () {
                        window.location.href = link.href;
                    }, 180);
                });
            });
        });
    </script>
</body>
</html>
