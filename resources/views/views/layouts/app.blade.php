<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Posyandu Kita')</title>

<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<script id="tailwind-config">
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "on-tertiary-fixed": "#390c01",
                    "background": "#f3faff",
                    "on-surface": "#071e27",
                    "surface-tint": "#006b5f",
                    "secondary-container": "#d4e6e5",
                    "surface-bright": "#f3faff",
                    "on-secondary-fixed": "#0e1e1e",
                    "inverse-surface": "#1e333c",
                    "error": "#ba1a1a",
                    "primary-fixed-dim": "#70d8c8",
                    "secondary-fixed-dim": "#b8cac9",
                    "on-tertiary-fixed-variant": "#713623",
                    "primary-container": "#008376",
                    "on-primary-fixed-variant": "#005048",
                    "error-container": "#ffdad6",
                    "surface-container-high": "#d5ecf8",
                    "tertiary-fixed-dim": "#ffb59e",
                    "inverse-on-surface": "#dff4ff",
                    "on-error": "#ffffff",
                    "surface-container-highest": "#cfe6f2",
                    "primary": "#00685d",
                    "secondary": "#516161",
                    "on-background": "#071e27",
                    "inverse-primary": "#70d8c8",
                    "surface-container-lowest": "#ffffff",
                    "on-primary-container": "#f4fffb",
                    "on-tertiary": "#ffffff",
                    "outline": "#6d7a77",
                    "tertiary-fixed": "#ffdbd0",
                    "on-secondary-container": "#576867",
                    "surface": "#f3faff",
                    "on-primary": "#ffffff",
                    "on-primary-fixed": "#00201c",
                    "outline-variant": "#bcc9c5",
                    "on-surface-variant": "#3d4946",
                    "primary-fixed": "#8df5e4",
                    "tertiary": "#8b4a36",
                    "surface-container": "#dbf1fe",
                    "on-error-container": "#93000a",
                    "surface-variant": "#cfe6f2",
                    "surface-dim": "#c7dde9",
                    "surface-container-low": "#e6f6ff",
                    "secondary-fixed": "#d4e6e5",
                    "on-secondary-fixed-variant": "#3a4a49",
                    "on-tertiary-container": "#fffbff",
                    "on-secondary": "#ffffff",
                    "tertiary-container": "#a8624c",
                },
                borderRadius: {
                    DEFAULT: "0.25rem",
                    lg: "0.5rem",
                    xl: "0.75rem",
                    full: "9999px",
                },
                spacing: {
                    "stack-lg": "48px",
                    "gutter": "24px",
                    "stack-md": "24px",
                    "container-padding-desktop": "40px",
                    "container-padding-mobile": "20px",
                    "stack-sm": "12px",
                    "base": "8px",
                },
                fontFamily: {
                    "headline-sm": ["Montserrat"],
                    "label-md": ["Inter"],
                    "headline-lg-mobile": ["Montserrat"],
                    "headline-md": ["Montserrat"],
                    "headline-lg": ["Montserrat"],
                    "body-md": ["Inter"],
                    "body-lg": ["Inter"],
                },
                fontSize: {
                    "headline-sm": ["20px", { lineHeight: "28px", fontWeight: "600" }],
                    "label-md": ["14px", { lineHeight: "20px", fontWeight: "600" }],
                    "headline-lg-mobile": ["24px", { lineHeight: "32px", fontWeight: "700" }],
                    "headline-md": ["24px", { lineHeight: "32px", fontWeight: "600" }],
                    "headline-lg": ["32px", { lineHeight: "40px", letterSpacing: "-0.02em", fontWeight: "700" }],
                    "body-md": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                    "body-lg": ["18px", { lineHeight: "28px", fontWeight: "400" }],
                },
            },
        },
    };
</script>

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
