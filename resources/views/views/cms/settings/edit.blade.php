@extends('views.layouts.cms')

@section('title', 'Pengaturan Situs')

@section('content')
<section class="panel" style="max-width:880px;">
    <h1 style="margin:0 0 6px;">Pengaturan Situs</h1>
    <p style="margin:0 0 16px;color:#607285;">Kelola identitas Posyandu, footer, kontak umum, dan bubble WhatsApp dari satu tempat.</p>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('cms.settings.update') }}" enctype="multipart/form-data" class="grid" style="grid-template-columns:1fr 1fr;">
        @csrf
        @method('PUT')

        <div><label>Nama Situs</label><input type="text" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" required></div>
        <div>
            <label>Logo Posyandu</label>
            <input type="file" name="logo_file" accept="image/*">
            @if(!empty($settings['logo_media_asset_id']))
                <img src="{{ route('media.show', $settings['logo_media_asset_id']) }}" alt="Logo saat ini" style="width:56px;height:56px;object-fit:contain;margin-top:8px;border:1px solid #d5dde6;border-radius:10px;background:#fff;padding:5px;">
            @endif
        </div>
        <div><label>No. WhatsApp</label><input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number']) }}"></div>
        <div style="grid-column:1/-1;"><label>Tagline / Deskripsi Footer</label><textarea name="site_tagline" style="min-height:100px;">{{ old('site_tagline', $settings['site_tagline']) }}</textarea></div>
        <div style="grid-column:1/-1;"><label>Alamat Umum</label><textarea name="contact_address" style="min-height:100px;">{{ old('contact_address', $settings['contact_address']) }}</textarea></div>
        <div><label>Email Kontak</label><input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']) }}"></div>
        <div><label>Telepon Kontak</label><input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']) }}"></div>
        <div style="grid-column:1/-1;"><label>Pesan Default WhatsApp</label><textarea name="whatsapp_message" style="min-height:90px;">{{ old('whatsapp_message', $settings['whatsapp_message']) }}</textarea></div>
        <div style="grid-column:1/-1;"><label>Copyright Footer</label><input type="text" name="footer_copyright" value="{{ old('footer_copyright', $settings['footer_copyright']) }}"></div>

        <div class="panel" style="grid-column:1/-1;background:#f8fbfd;">
            <strong style="display:block;margin-bottom:8px;">Preview Singkat</strong>
            <div style="display:grid;gap:6px;color:#607285;">
                <div><strong>Nama:</strong> {{ old('site_name', $settings['site_name']) }}</div>
                <div><strong>WA:</strong> {{ old('whatsapp_number', $settings['whatsapp_number']) }}</div>
                <div><strong>Email:</strong> {{ old('contact_email', $settings['contact_email']) }}</div>
            </div>
        </div>

        <div style="display:flex;gap:8px;grid-column:1/-1;">
            <button class="btn btn-main" type="submit">Simpan Pengaturan</button>
            <a class="btn btn-ghost" href="{{ route('cms.dashboard') }}">Kembali</a>
        </div>
    </form>
</section>
@endsection
