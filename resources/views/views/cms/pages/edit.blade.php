@extends('views.layouts.cms')

@section('title', 'Edit Halaman')

@section('content')
<section class="panel">
    <h1 style="margin-top:0;">Edit Halaman: {{ $page->title }}</h1>
    @php($meta = $page->meta ?? [])
    @if(in_array($page->slug, ['beranda', 'berita', 'galeri', 'dokumentasi', 'struktur', 'tentang', 'lokasi'], true))
        <p style="margin:4px 0 14px;color:#607285;">
            Preview halaman publik:
            <a href="{{ route(match($page->slug) {
                'beranda' => 'beranda',
                'berita' => 'berita',
                'galeri' => 'galeri',
                'dokumentasi' => 'dokumentasi',
                'struktur' => 'struktur',
                'tentang' => 'tentang',
                'lokasi' => 'lokasi',
            }) }}" target="_blank" style="color:#195f46;font-weight:700;">{{ route(match($page->slug) {
                'beranda' => 'beranda',
                'berita' => 'berita',
                'galeri' => 'galeri',
                'dokumentasi' => 'dokumentasi',
                'struktur' => 'struktur',
                'tentang' => 'tentang',
                'lokasi' => 'lokasi',
            }) }}</a>
        </p>
    @endif

    <div class="panel" style="margin-bottom:14px;background:#f8fbfd;">
        <strong style="display:block;margin-bottom:8px;">Ringkasan Cepat</strong>
        <div class="grid" style="grid-template-columns:repeat(auto-fit,minmax(180px,1fr));color:#607285;">
            <div><strong style="display:block;color:#172635;">Menu</strong>{{ $page->nav_label }}</div>
            <div><strong style="display:block;color:#172635;">Slug</strong>/{{ $page->slug }}</div>
            <div><strong style="display:block;color:#172635;">Status</strong>{{ $page->is_published ? 'Publish' : 'Draft' }}</div>
            <div><strong style="display:block;color:#172635;">Urutan</strong>{{ $page->sort_order }}</div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-error"><ul style="margin:0;padding-left:18px;">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('cms.pages.update', $page) }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')
        <div><label>Slug</label><input type="text" name="slug" value="{{ old('slug', $page->slug) }}" required></div>
        <div><label>Label Navigasi</label><input type="text" name="nav_label" value="{{ old('nav_label', $page->nav_label) }}" required></div>
        <div><label>Judul</label><input type="text" name="title" value="{{ old('title', $page->title) }}" required></div>
        <div><label>Subjudul</label><input type="text" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}"></div>
        <div><label>Hero Image URL</label><input type="url" name="hero_image" value="{{ old('hero_image', $page->hero_image) }}"></div>
        <div><label>Upload Hero Image Lokal</label><input type="file" name="hero_image_file" accept="image/*"></div>
        <div><label>Urutan</label><input type="number" name="sort_order" value="{{ old('sort_order', $page->sort_order) }}" min="0"></div>
        @if($page->hero_image)
            <div style="grid-column:1/-1;">
                <label>Preview Hero Saat Ini</label>
                <img src="{{ $page->hero_image }}" alt="{{ $page->title }}" style="width:100%;max-width:320px;border-radius:12px;border:1px solid #d5dde6;display:block;">
            </div>
        @endif

        @if($page->slug === 'beranda')
            <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
                <h2 style="margin:0 0 12px;">Pengaturan Khusus Beranda</h2>
                <div class="grid" style="grid-template-columns:1fr 1fr;">
                    <div><label>Badge Hero</label><input type="text" name="meta_badge" value="{{ old('meta_badge', $meta['badge'] ?? '') }}"></div>
                    <div></div>
                    <div><label>Tombol Utama</label><input type="text" name="meta_primary_cta_label" value="{{ old('meta_primary_cta_label', $meta['primary_cta_label'] ?? '') }}"></div>
                    <div><label>Link Tombol Utama</label><input type="text" name="meta_primary_cta_url" value="{{ old('meta_primary_cta_url', $meta['primary_cta_url'] ?? '') }}"></div>
                    <div><label>Tombol Kedua</label><input type="text" name="meta_secondary_cta_label" value="{{ old('meta_secondary_cta_label', $meta['secondary_cta_label'] ?? '') }}"></div>
                    <div><label>Link Tombol Kedua</label><input type="text" name="meta_secondary_cta_url" value="{{ old('meta_secondary_cta_url', $meta['secondary_cta_url'] ?? '') }}"></div>
                </div>
                <h3 style="margin:14px 0 8px;">Statistik Beranda</h3>
                @foreach(old('meta_stats_values', array_column($meta['stats'] ?? [[],[],[],[]], 'value')) as $index => $value)
                    <div class="grid" style="grid-template-columns:160px 1fr;margin-bottom:8px;">
                        <div><input type="text" name="meta_stats_values[]" value="{{ $value }}" placeholder="Angka {{ $index + 1 }}"></div>
                        <div><input type="text" name="meta_stats_labels[]" value="{{ old('meta_stats_labels.' . $index, $meta['stats'][$index]['label'] ?? '') }}" placeholder="Label statistik {{ $index + 1 }}"></div>
                    </div>
                @endforeach
                <h3 style="margin:14px 0 8px;">Jadwal Beranda</h3>
                @for($index = 0; $index < 3; $index++)
                    <div class="panel" style="padding:12px;margin-bottom:10px;">
                        <div class="grid" style="grid-template-columns:1fr 1fr;">
                            <div><label>Tipe</label><input type="text" name="meta_schedule_types[]" value="{{ old('meta_schedule_types.' . $index, $meta['schedules'][$index]['type'] ?? '') }}"></div>
                            <div><label>Tanggal</label><input type="text" name="meta_schedule_dates[]" value="{{ old('meta_schedule_dates.' . $index, $meta['schedules'][$index]['date'] ?? '') }}"></div>
                            <div><label>Lokasi</label><input type="text" name="meta_schedule_locations[]" value="{{ old('meta_schedule_locations.' . $index, $meta['schedules'][$index]['location'] ?? '') }}"></div>
                            <div><label>Jam</label><input type="text" name="meta_schedule_times[]" value="{{ old('meta_schedule_times.' . $index, $meta['schedules'][$index]['time'] ?? '') }}"></div>
                            <div>
                                <label>Warna Aksen</label>
                                <select name="meta_schedule_accents[]" style="width:100%;border:1px solid #d5dde6;border-radius:10px;padding:10px 12px;font:inherit;">
                                    @php($accent = old('meta_schedule_accents.' . $index, $meta['schedules'][$index]['accent'] ?? 'primary'))
                                    <option value="primary" {{ $accent === 'primary' ? 'selected' : '' }}>Primary</option>
                                    <option value="tertiary" {{ $accent === 'tertiary' ? 'selected' : '' }}>Tertiary</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        @endif

        @if($page->slug === 'berita')
            <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
                <h2 style="margin:0 0 12px;">Pengaturan Khusus Berita</h2>
                <div class="grid" style="grid-template-columns:1fr 1fr;">
                    <div><label>Judul Sorotan Utama</label><input type="text" name="meta_featured_section_title" value="{{ old('meta_featured_section_title', $meta['featured_section_title'] ?? '') }}"></div>
                    <div><label>Judul Daftar Artikel</label><input type="text" name="meta_list_section_title" value="{{ old('meta_list_section_title', $meta['list_section_title'] ?? '') }}"></div>
                </div>
                <h3 style="margin:14px 0 8px;">Chip Filter Berita</h3>
                <div data-repeater="filter-berita">
                    @foreach(old('meta_filter_labels', $meta['filter_labels'] ?? []) as $label)
                        <div class="panel" style="display:flex;gap:8px;margin-bottom:8px;padding:12px;align-items:center;">
                            <input type="text" name="meta_filter_labels[]" value="{{ $label }}" placeholder="Label filter">
                            <button type="button" class="btn btn-danger" data-remove-row>Hapus</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-ghost" data-add-row='{"target":"filter-berita","html":"<div class=&quot;panel&quot; style=&quot;display:flex;gap:8px;margin-bottom:8px;padding:12px;align-items:center;&quot;><input type=&quot;text&quot; name=&quot;meta_filter_labels[]&quot; placeholder=&quot;Label filter&quot;><button type=&quot;button&quot; class=&quot;btn btn-danger&quot; data-remove-row>Hapus</button></div>"}'>Tambah Filter</button>
            </div>
        @endif

        @if($page->slug === 'galeri')
            <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
                <h2 style="margin:0 0 12px;">Pengaturan Khusus Galeri</h2>
                <div><label>Catatan Footer Galeri</label><input type="text" name="meta_footer_note" value="{{ old('meta_footer_note', $meta['footer_note'] ?? '') }}"></div>
                <h3 style="margin:14px 0 8px;">Chip Filter Galeri</h3>
                <div data-repeater="filter-galeri">
                    @foreach(old('meta_filter_labels', $meta['filter_labels'] ?? []) as $label)
                        <div class="panel" style="display:flex;gap:8px;margin-bottom:8px;padding:12px;align-items:center;">
                            <input type="text" name="meta_filter_labels[]" value="{{ $label }}" placeholder="Label filter galeri">
                            <button type="button" class="btn btn-danger" data-remove-row>Hapus</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-ghost" data-add-row='{"target":"filter-galeri","html":"<div class=&quot;panel&quot; style=&quot;display:flex;gap:8px;margin-bottom:8px;padding:12px;align-items:center;&quot;><input type=&quot;text&quot; name=&quot;meta_filter_labels[]&quot; placeholder=&quot;Label filter galeri&quot;><button type=&quot;button&quot; class=&quot;btn btn-danger&quot; data-remove-row>Hapus</button></div>"}'>Tambah Filter</button>
            </div>
        @endif

        @if($page->slug === 'dokumentasi')
            <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
                <h2 style="margin:0 0 12px;">Pengaturan Khusus Dokumentasi</h2>
                <div class="grid" style="grid-template-columns:1fr 1fr;">
                    <div><label>Judul Section Galeri</label><input type="text" name="meta_gallery_section_title" value="{{ old('meta_gallery_section_title', $meta['gallery_section_title'] ?? '') }}"></div>
                    <div><label>Subjudul Section Galeri</label><input type="text" name="meta_gallery_section_subtitle" value="{{ old('meta_gallery_section_subtitle', $meta['gallery_section_subtitle'] ?? '') }}"></div>
                </div>
            </div>
        @endif

        @if($page->slug === 'tentang')
            <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
                <h2 style="margin:0 0 12px;">Pengaturan Khusus Tentang</h2>
                <div class="grid" style="grid-template-columns:1fr 1fr;">
                    <div><label>Judul Visi</label><input type="text" name="meta_vision_title" value="{{ old('meta_vision_title', $meta['vision_title'] ?? '') }}"></div>
                    <div><label>Judul Misi</label><input type="text" name="meta_mission_title" value="{{ old('meta_mission_title', $meta['mission_title'] ?? '') }}"></div>
                    <div style="grid-column:1/-1;"><label>Isi Visi</label><textarea name="meta_vision_body" style="min-height:100px;">{{ old('meta_vision_body', $meta['vision_body'] ?? '') }}</textarea></div>
                    <div><label>Judul Sejarah</label><input type="text" name="meta_history_title" value="{{ old('meta_history_title', $meta['history_title'] ?? '') }}"></div>
                    <div><label>Judul Dampak</label><input type="text" name="meta_impact_title" value="{{ old('meta_impact_title', $meta['impact_title'] ?? '') }}"></div>
                    <div style="grid-column:1/-1;"><label>Subjudul Dampak</label><textarea name="meta_impact_subtitle" style="min-height:90px;">{{ old('meta_impact_subtitle', $meta['impact_subtitle'] ?? '') }}</textarea></div>
                </div>
                <h3 style="margin:14px 0 8px;">Daftar Misi</h3>
                <div data-repeater="mission-items">
                    @foreach(old('meta_mission_items', $meta['mission_items'] ?? []) as $item)
                        <div class="panel" style="display:flex;gap:8px;margin-bottom:8px;padding:12px;align-items:center;">
                            <input type="text" name="meta_mission_items[]" value="{{ $item }}" placeholder="Isi misi">
                            <button type="button" class="btn btn-danger" data-remove-row>Hapus</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-ghost" data-add-row='{"target":"mission-items","html":"<div class=&quot;panel&quot; style=&quot;display:flex;gap:8px;margin-bottom:8px;padding:12px;align-items:center;&quot;><input type=&quot;text&quot; name=&quot;meta_mission_items[]&quot; placeholder=&quot;Isi misi&quot;><button type=&quot;button&quot; class=&quot;btn btn-danger&quot; data-remove-row>Hapus</button></div>"}'>Tambah Misi</button>

                <h3 style="margin:14px 0 8px;">Statistik Dampak</h3>
                <div data-repeater="impact-stats">
                    @foreach(old('meta_impact_values', array_column($meta['impact_stats'] ?? [], 'value')) as $index => $value)
                        <div class="panel" style="padding:12px;margin-bottom:10px;">
                            <div class="grid" style="grid-template-columns:1fr 1fr;">
                                <div><label>Angka</label><input type="text" name="meta_impact_values[]" value="{{ $value }}"></div>
                                <div><label>Label</label><input type="text" name="meta_impact_labels[]" value="{{ old('meta_impact_labels.' . $index, $meta['impact_stats'][$index]['label'] ?? '') }}"></div>
                                <div><label>Icon Material</label><input type="text" name="meta_impact_icons[]" value="{{ old('meta_impact_icons.' . $index, $meta['impact_stats'][$index]['icon'] ?? '') }}"></div>
                                <div><label>Warna Icon</label><input type="text" name="meta_impact_colors[]" value="{{ old('meta_impact_colors.' . $index, $meta['impact_stats'][$index]['color'] ?? '') }}"></div>
                            </div>
                            <button type="button" class="btn btn-danger" data-remove-parent style="margin-top:8px;">Hapus Statistik</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-ghost" data-add-row='{"target":"impact-stats","html":"<div class=&quot;panel&quot; style=&quot;padding:12px;margin-bottom:10px;&quot;><div class=&quot;grid&quot; style=&quot;grid-template-columns:1fr 1fr;&quot;><div><label>Angka</label><input type=&quot;text&quot; name=&quot;meta_impact_values[]&quot;></div><div><label>Label</label><input type=&quot;text&quot; name=&quot;meta_impact_labels[]&quot;></div><div><label>Icon Material</label><input type=&quot;text&quot; name=&quot;meta_impact_icons[]&quot; value=&quot;favorite&quot;></div><div><label>Warna Icon</label><input type=&quot;text&quot; name=&quot;meta_impact_colors[]&quot; value=&quot;primary&quot;></div></div><button type=&quot;button&quot; class=&quot;btn btn-danger&quot; data-remove-parent style=&quot;margin-top:8px;&quot;>Hapus Statistik</button></div>"}'>Tambah Statistik</button>
            </div>
        @endif

        @if($page->slug === 'lokasi')
            <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
                <h2 style="margin:0 0 12px;">Pengaturan Khusus Lokasi</h2>
                <div class="grid" style="grid-template-columns:1fr 1fr;">
                    <div style="grid-column:1/-1;"><label>Alamat Lengkap</label><textarea name="meta_address" style="min-height:110px;">{{ old('meta_address', $meta['address'] ?? '') }}</textarea></div>
                    <div><label>Nomor Telepon</label><input type="text" name="meta_phone" value="{{ old('meta_phone', $meta['phone'] ?? '') }}"></div>
                    <div><label>Link Google Maps (tombol "Buka di Google Maps")</label><input type="text" name="meta_maps_url" value="{{ old('meta_maps_url', $meta['maps_url'] ?? '') }}" placeholder="https://maps.app.goo.gl/..."></div>
                    <div style="grid-column:1/-1;">
                        <label>Kode Embed Peta (opsional)</label>
                        <textarea name="meta_maps_embed" style="min-height:90px;font-family:monospace;font-size:12.5px;" placeholder="Tempel di sini kode <iframe> dari Google Maps &rarr; Bagikan &rarr; Sematkan peta">{{ old('meta_maps_embed', $meta['maps_embed'] ?? '') }}</textarea>
                        <p style="margin:6px 0 0;font-size:12.5px;color:#607285;">Buka Google Maps &rarr; cari lokasi &rarr; Bagikan &rarr; tab "Sematkan peta" &rarr; Salin HTML &rarr; tempel utuh di sini. Kalau diisi, peta live akan muncul di atas foto lokasi. Kosongkan untuk memakai foto saja.</p>
                    </div>
                    <div style="grid-column:1/-1;"><label>Jadwal Operasional</label><textarea name="meta_schedule" style="min-height:90px;">{{ old('meta_schedule', $meta['schedule'] ?? '') }}</textarea></div>
                </div>
                <h3 style="margin:14px 0 8px;">Catatan Transportasi</h3>
                @for($index = 0; $index < 3; $index++)
                    <input type="text" name="meta_transport_notes[]" value="{{ old('meta_transport_notes.' . $index, $meta['transport_notes'][$index] ?? '') }}" placeholder="Catatan transportasi {{ $index + 1 }}" style="margin-bottom:8px;">
                @endfor
            </div>
        @endif

        @if($page->slug === 'struktur')
            <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
                <h2 style="margin:0 0 8px;">Anggota &amp; Kelompok Struktur</h2>
                <p style="margin:0 0 14px;color:#607285;font-size:13.5px;">Daftar kelompok (mis. "Pengurus Terpadu" dan "Pengurus RW.09") beserta anggotanya sekarang dikelola di menu tersendiri, bukan di sini &mdash; supaya bisa nambah/kurangi orang sebanyak apapun dan upload foto masing-masing.</p>
                <a href="{{ route('cms.struktur.index') }}" class="btn btn-main">Kelola Struktur Organisasi &rarr;</a>
            </div>
        @endif

        <div style="grid-column:1/-1;"><label>Isi Konten</label><textarea name="body">{{ old('body', $page->body) }}</textarea></div>
        <label style="display:flex;align-items:center;gap:8px;grid-column:1/-1;"><input type="checkbox" name="is_published" value="1" {{ old('is_published', $page->is_published) ? 'checked' : '' }} style="width:auto;"> Publish</label>
        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Update</button>
            <a class="btn btn-ghost" href="{{ route('cms.pages.index') }}">Kembali</a>
        </div>
    </form>
</section>

@push('scripts')
<script>
document.addEventListener('click', function (event) {
    var addButton = event.target.closest('[data-add-row]');
    if (addButton) {
        var config = JSON.parse(addButton.getAttribute('data-add-row'));
        var target = document.querySelector('[data-repeater="' + config.target + '"]');
        if (target) {
            target.insertAdjacentHTML('beforeend', config.html);
        }
        return;
    }

    var removeRow = event.target.closest('[data-remove-row]');
    if (removeRow) {
        removeRow.parentElement.remove();
        return;
    }

    var removeParent = event.target.closest('[data-remove-parent]');
    if (removeParent) {
        removeParent.closest('.panel').remove();
    }
});
</script>
@endpush
@endsection
