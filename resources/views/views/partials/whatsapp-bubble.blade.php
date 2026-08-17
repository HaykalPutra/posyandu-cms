<a
    href="https://wa.me/{{ $siteSettings['whatsapp_number'] ?? '6281234567890' }}?text={{ urlencode($siteSettings['whatsapp_message'] ?? 'Halo Posyandu Kita, saya ingin bertanya.') }}"
    target="_blank"
    rel="noopener noreferrer"
    aria-label="Hubungi Kami via WhatsApp"
    class="fixed right-5 bottom-5 z-[60] bg-[#25D366] text-white rounded-full shadow-lg hover:scale-105 active:scale-95 transition-transform px-4 py-3 flex items-center gap-2"
>
    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
        <path d="M19.05 4.91A9.82 9.82 0 0 0 12.02 2C6.57 2 2.13 6.43 2.13 11.89c0 1.75.46 3.46 1.33 4.97L2 22l5.27-1.38a9.87 9.87 0 0 0 4.75 1.21h.01c5.45 0 9.89-4.43 9.89-9.89a9.8 9.8 0 0 0-2.87-7.03Zm-7.03 15.23h-.01a8.2 8.2 0 0 1-4.18-1.15l-.3-.18-3.13.82.84-3.05-.2-.31a8.17 8.17 0 0 1-1.27-4.38c0-4.52 3.69-8.2 8.22-8.2a8.15 8.15 0 0 1 5.82 2.41 8.13 8.13 0 0 1 2.4 5.8c0 4.53-3.68 8.23-8.19 8.23Zm4.5-6.15c-.25-.13-1.46-.72-1.69-.8-.22-.08-.38-.12-.55.12-.16.24-.63.8-.77.97-.14.16-.29.18-.54.06-.25-.13-1.05-.39-2-1.24-.74-.66-1.24-1.47-1.38-1.72-.14-.24-.02-.37.1-.5.11-.11.25-.29.37-.43.12-.14.16-.24.25-.4.08-.16.04-.31-.02-.43-.06-.13-.55-1.32-.75-1.8-.2-.48-.4-.41-.55-.41h-.46c-.16 0-.43.06-.65.31-.22.24-.85.83-.85 2.03 0 1.2.87 2.36.99 2.53.12.16 1.71 2.61 4.15 3.66.58.25 1.03.4 1.38.51.58.18 1.1.15 1.51.09.46-.07 1.46-.6 1.66-1.18.2-.58.2-1.08.14-1.18-.06-.1-.22-.16-.47-.28Z"/>
    </svg>
    <span class="font-label-md text-label-md">{{ $siteSettings['contact_phone'] ?? 'Hubungi Kami' }}</span>
</a>
