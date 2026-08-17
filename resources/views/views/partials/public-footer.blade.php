<footer class="w-full rounded-t-xl bg-surface-container dark:bg-surface-container-high">
<div class="grid grid-cols-1 md:grid-cols-3 gap-stack-lg px-container-padding-mobile md:px-container-padding-desktop py-stack-lg max-w-[1200px] mx-auto">
<div class="flex flex-col gap-4">
<div class="flex items-center gap-2">
<img src="{{ asset('storage/images/Posyandu.png') }}" alt="Logo Posyandu" class="h-10 w-auto object-contain">
</div>
<p class="font-body-md text-body-md text-on-surface-variant max-w-sm mt-2">
                    {{ $siteSettings['site_tagline'] ?? 'Nurturing Professionalism for a Healthier Community. Kami hadir untuk melayani dengan empati dan dedikasi.' }}
                </p>
<div class="mt-auto pt-4 border-t border-surface-variant/50">
<p class="font-label-md text-label-md text-on-surface-variant">{{ $siteSettings['footer_copyright'] ?? '© 2024 Posyandu Kita.' }}</p>
</div>
</div>
<div class="flex flex-col gap-3">
<h4 class="font-headline-sm text-headline-sm text-on-surface mb-2">Tautan Bermanfaat</h4>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:underline transition-all duration-200 w-fit" href="#">Kebijakan Privasi</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:underline transition-all duration-200 w-fit" href="#">Syarat &amp; Ketentuan</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:underline transition-all duration-200 w-fit" href="#">Pusat Bantuan</a>
<a class="font-label-md text-label-md text-on-surface-variant hover:text-primary hover:underline transition-all duration-200 w-fit" href="#">Kemitraan</a>
</div>
<div class="flex flex-col gap-3">
<h4 class="font-headline-sm text-headline-sm text-on-surface mb-2">Hubungi Kami</h4>
<div class="flex items-center gap-2 text-on-surface-variant">
<span class="material-symbols-outlined text-[20px]">location_on</span>
<span class="font-body-md text-body-md">{{ $siteSettings['contact_address'] ?? 'Jl. Sehat Bersama No. 10, Jakarta Raya' }}</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant mt-2">
<span class="material-symbols-outlined text-[20px]">mail</span>
<span class="font-body-md text-body-md">{{ $siteSettings['contact_email'] ?? 'halo@posyandukita.id' }}</span>
</div>
<div class="flex items-center gap-2 text-on-surface-variant mt-2">
<span class="material-symbols-outlined text-[20px]">call</span>
<span class="font-body-md text-body-md">{{ $siteSettings['contact_phone'] ?? '0812-3456-7890' }}</span>
</div>
</div>
</div>
</footer>
