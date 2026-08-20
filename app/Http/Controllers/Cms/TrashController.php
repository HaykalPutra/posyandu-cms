<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CarouselItem;
use App\Models\CmsPage;
use App\Models\GalleryItem;
use App\Models\OrgGroup;
use App\Models\OrgMember;
use App\Models\Post;
use App\Models\Schedule;

class TrashController extends Controller
{
    /**
     * Allow-listed types the trash can operate on. Never resolve the model
     * class from user input directly - always go through this map.
     *
     * media_field: which column (if any) holds a MediaAsset id that should
     * be purged when the record is permanently deleted.
     */
    private function types(): array
    {
        return [
            'pages' => ['model' => CmsPage::class, 'label' => 'Halaman', 'media_field' => 'hero_media_asset_id', 'title_field' => 'title'],
            'posts' => ['model' => Post::class, 'label' => 'Berita', 'media_field' => 'cover_media_asset_id', 'title_field' => 'title'],
            'gallery' => ['model' => GalleryItem::class, 'label' => 'Galeri', 'media_field' => 'image_media_asset_id', 'title_field' => 'title'],
            'carousel' => ['model' => CarouselItem::class, 'label' => 'Carousel Beranda', 'media_field' => 'image_media_asset_id', 'title_field' => 'title'],
            'schedules' => ['model' => Schedule::class, 'label' => 'Jadwal', 'media_field' => null, 'title_field' => 'title'],
            'struktur' => ['model' => OrgGroup::class, 'label' => 'Kelompok Struktur', 'media_field' => null, 'title_field' => 'title'],
            'struktur-anggota' => ['model' => OrgMember::class, 'label' => 'Anggota Struktur', 'media_field' => 'photo_media_asset_id', 'title_field' => 'name'],
        ];
    }

    public function index()
    {
        $groups = [];

        foreach ($this->types() as $key => $meta) {
            $items = $meta['model']::onlyTrashed()
                ->orderByDesc('deleted_at')
                ->limit(50)
                ->get();

            $groups[$key] = [
                'label' => $meta['label'],
                'title_field' => $meta['title_field'],
                'items' => $items,
            ];
        }

        return view('views.cms.trash.index', compact('groups'));
    }

    public function restore(string $type, string $id)
    {
        $meta = $this->types()[$type] ?? null;

        abort_if($meta === null, 404);

        $item = $meta['model']::onlyTrashed()->findOrFail($id);
        $item->restore();

        return redirect()->route('cms.trash.index')->with('success', $meta['label'] . ' berhasil dipulihkan.');
    }

    /**
     * Permanently deletes a trashed record, including its associated image
     * (if any). This cannot be undone - only call it on a record that is
     * already soft-deleted.
     */
    public function forceDelete(string $type, string $id)
    {
        $meta = $this->types()[$type] ?? null;

        abort_if($meta === null, 404);

        $item = $meta['model']::onlyTrashed()->findOrFail($id);

        if ($meta['media_field'] && $item->{$meta['media_field']}) {
            $this->deleteDatabaseMedia($item->{$meta['media_field']});
        }

        $item->forceDelete();

        return redirect()->route('cms.trash.index')->with('success', $meta['label'] . ' berhasil dihapus permanen.');
    }
}
