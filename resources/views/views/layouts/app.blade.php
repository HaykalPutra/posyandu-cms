<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Posyandu Kita')</title>

<!-- ========================================== -->
<!-- POINT 2: TAG PWA -->
<!-- ========================================== -->
<meta name="theme-color" content="#00685d"> <!-- Warna tema aplikasi saat di HP -->
<link rel="apple-touch-icon" href="{{ asset('pwa-192x192.png') }}">
<link rel="manifest" href="/build/manifest.webmanifest">
<!-- ========================================== -->

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

    <!-- ========================================== -->
    <!-- MODAL/BANNER CUSTOM INSTALL PWA -->
    <!-- ========================================== -->
    <div id="pwaInstallBanner" class="fixed bottom-0 left-0 right-0 md:bottom-6 md:left-6 md:right-auto z-50 transform translate-y-[150%] opacity-0 transition-all duration-700 ease-out max-w-[360px] w-full pointer-events-none">
        <div class="bg-surface m-4 md:m-0 rounded-2xl shadow-[0_8px_30px_rgba(0,104,93,0.15)] border border-surface-variant overflow-hidden pointer-events-auto">
            <div class="p-5 flex items-start gap-4">
                <div class="bg-primary/10 p-3 rounded-2xl text-primary flex-shrink-0">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">add_to_home_screen</span>
                </div>
                <div class="flex-1">
                    <h4 class="font-headline-sm text-on-surface mb-1 text-[16px] font-bold">Install Aplikasi Posyandu</h4>
                    <p class="font-body-sm text-on-surface-variant text-sm mb-4 leading-relaxed">Pasang aplikasi di layar utama HP kamu untuk akses jadwal dan berita lebih cepat!</p>
                    <div class="flex gap-2">
                        <button id="pwaInstallBtn" class="bg-primary text-on-primary px-4 py-2 rounded-xl font-label-md text-sm hover:bg-primary-container hover:text-on-primary-container transition-all shadow-sm active:scale-95 flex-1 text-center font-semibold">
                            Install
                        </button>
                        <button id="pwaCloseBtn" class="bg-surface-container text-on-surface-variant px-4 py-2 rounded-xl font-label-md text-sm hover:bg-surface-variant transition-all active:scale-95 text-center">
                            Nanti
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Animasi Transisi Halaman (Bawaan Web Kamu)
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

            // ==========================================
            // LOGIKA PWA INSTALL BANNER
            // ==========================================
            let deferredPrompt;
            const pwaInstallBanner = document.getElementById('pwaInstallBanner');
            const pwaInstallBtn = document.getElementById('pwaInstallBtn');
            const pwaCloseBtn = document.getElementById('pwaCloseBtn');

            const hasDismissed = localStorage.getItem('pwa_dismissed');

            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                
                if (!hasDismissed) {
                    setTimeout(() => {
                        pwaInstallBanner.classList.remove('translate-y-[150%]', 'opacity-0');
                        pwaInstallBanner.classList.add('translate-y-0', 'opacity-100');
                    }, 1500); 
                }
            });

            pwaInstallBtn.addEventListener('click', async () => {
                if (deferredPrompt !== null) {
                    deferredPrompt.prompt(); 
                    const { outcome } = await deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        hideBanner();
                    }
                    deferredPrompt = null;
                }
            });

            pwaCloseBtn.addEventListener('click', () => {
                hideBanner();
                localStorage.setItem('pwa_dismissed', 'true'); 
            });

            function hideBanner() {
                pwaInstallBanner.classList.add('translate-y-[150%]', 'opacity-0');
                pwaInstallBanner.classList.remove('translate-y-0', 'opacity-100');
            }
        });
    </script>
</body>
</html>