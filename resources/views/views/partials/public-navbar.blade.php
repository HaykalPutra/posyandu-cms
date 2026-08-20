<nav class="w-full top-0 sticky shadow-sm bg-surface dark:bg-surface-dim z-50">
<div class="flex justify-between items-center h-20 px-container-padding-mobile md:px-container-padding-desktop max-w-[1200px] mx-auto">
<div class="flex items-center gap-2">
<img src="{{ asset('storage/images/Posyandu.png') }}" alt="Logo Posyandu" class="h-12 w-auto object-contain">
</div>
<div class="hidden md:flex items-center gap-gutter">
<a class="{{ request()->routeIs('beranda') ? 'text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md' : 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 duration-200 hover:bg-primary-container/10 px-3 py-2 rounded-lg font-label-md text-label-md' }}" href="{{ route('beranda') }}">Beranda</a>
<a class="{{ request()->routeIs('berita') ? 'text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md' : 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 duration-200 hover:bg-primary-container/10 px-3 py-2 rounded-lg font-label-md text-label-md' }}" href="{{ route('berita') }}">Berita</a>
<a class="{{ request()->routeIs('galeri') ? 'text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md' : 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 duration-200 hover:bg-primary-container/10 px-3 py-2 rounded-lg font-label-md text-label-md' }}" href="{{ route('galeri') }}">Galeri</a>
<a class="{{ request()->routeIs('dokumentasi') ? 'text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md' : 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 duration-200 hover:bg-primary-container/10 px-3 py-2 rounded-lg font-label-md text-label-md' }}" href="{{ route('dokumentasi') }}">Dokumentasi</a>
<a class="{{ request()->routeIs('struktur') ? 'text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md' : 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 duration-200 hover:bg-primary-container/10 px-3 py-2 rounded-lg font-label-md text-label-md' }}" href="{{ route('struktur') }}">Struktur</a>
<a class="{{ request()->routeIs('tentang') ? 'text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md' : 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 duration-200 hover:bg-primary-container/10 px-3 py-2 rounded-lg font-label-md text-label-md' }}" href="{{ route('tentang') }}">Tentang</a>
<a class="{{ request()->routeIs('lokasi') ? 'text-primary font-bold border-b-2 border-primary pb-1 font-label-md text-label-md' : 'text-on-surface-variant hover:text-primary transition-colors cursor-pointer active:scale-95 duration-200 hover:bg-primary-container/10 px-3 py-2 rounded-lg font-label-md text-label-md' }}" href="{{ route('lokasi') }}">Lokasi</a>
</div>
<a class="hidden md:flex items-center gap-2 border border-primary text-primary px-5 py-2.5 rounded-full font-label-md text-label-md hover:bg-primary hover:text-on-primary transition-colors" href="{{ route('cms.login') }}">
<span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
<span>Login CMS</span>
</a>
<button id="mobileMenuBtn" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="mobileMenuPanel" class="md:hidden text-primary p-2 rounded-lg hover:bg-primary-container/10 transition-colors">
<span id="mobileMenuIcon" class="material-symbols-outlined text-3xl">menu</span>
</button>
</div>

<!-- Mobile dropdown panel -->
<div id="mobileMenuPanel" class="hidden md:hidden bg-surface border-t border-surface-variant/60 shadow-md">
<div class="flex flex-col px-container-padding-mobile py-3 max-w-[1200px] mx-auto">
<a class="{{ request()->routeIs('beranda') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant' }} font-label-md text-label-md px-3 py-3 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-colors" href="{{ route('beranda') }}">Beranda</a>
<a class="{{ request()->routeIs('berita') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant' }} font-label-md text-label-md px-3 py-3 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-colors" href="{{ route('berita') }}">Berita</a>
<a class="{{ request()->routeIs('galeri') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant' }} font-label-md text-label-md px-3 py-3 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-colors" href="{{ route('galeri') }}">Galeri</a>
<a class="{{ request()->routeIs('dokumentasi') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant' }} font-label-md text-label-md px-3 py-3 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-colors" href="{{ route('dokumentasi') }}">Dokumentasi</a>
<a class="{{ request()->routeIs('struktur') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant' }} font-label-md text-label-md px-3 py-3 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-colors" href="{{ route('struktur') }}">Struktur</a>
<a class="{{ request()->routeIs('tentang') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant' }} font-label-md text-label-md px-3 py-3 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-colors" href="{{ route('tentang') }}">Tentang</a>
<a class="{{ request()->routeIs('lokasi') ? 'text-primary font-bold bg-primary-container/10' : 'text-on-surface-variant' }} font-label-md text-label-md px-3 py-3 rounded-lg hover:bg-primary-container/10 hover:text-primary transition-colors" href="{{ route('lokasi') }}">Lokasi</a>
<a class="flex items-center justify-center gap-2 border border-primary text-primary px-5 py-3 rounded-full font-label-md text-label-md mt-2" href="{{ route('cms.login') }}">
<span class="material-symbols-outlined text-[18px]">admin_panel_settings</span>
<span>Login CMS</span>
</a>
</div>
</div>
</nav>

<script>
(function () {
    var btn = document.getElementById('mobileMenuBtn');
    var panel = document.getElementById('mobileMenuPanel');
    var icon = document.getElementById('mobileMenuIcon');

    if (!btn || !panel || !icon) {
        return;
    }

    function isOpen() {
        return !panel.classList.contains('hidden');
    }

    function openMenu() {
        panel.classList.remove('hidden');
        icon.textContent = 'close';
        btn.setAttribute('aria-expanded', 'true');
    }

    function closeMenu() {
        panel.classList.add('hidden');
        icon.textContent = 'menu';
        btn.setAttribute('aria-expanded', 'false');
    }

    btn.addEventListener('click', function (event) {
        event.stopPropagation();
        isOpen() ? closeMenu() : openMenu();
    });

    panel.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', closeMenu);
    });

    document.addEventListener('click', function (event) {
        if (isOpen() && !panel.contains(event.target) && !btn.contains(event.target)) {
            closeMenu();
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768 && isOpen()) {
            closeMenu();
        }
    });
})();
</script>