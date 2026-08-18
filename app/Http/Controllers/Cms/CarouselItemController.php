<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\CarouselItem;
use Illuminate\Http\Request;

class CarouselItemController extends Controller
{
    public function index()
    {
        $items = CarouselItem::query()
            ->orderBy('sort_order')
            ->paginate(20);

        return view('views.cms.carousel.index', compact('items'));
    }

    public function create()
    {
        return view('views.cms.carousel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:2048', 'required_without:image_file'],
            'image_file' => ['nullable', 'image', 'max:4096', 'required_without:image_url'],
            'link_url' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($uploadedImage = $this->storeUploadedImage($request, 'image_file', 'cms/carousel')) {
            $validated['image_media_asset_id'] = $uploadedImage;
            $validated['image_url'] = null;
        }

        unset($validated['image_file']);

        CarouselItem::create($validated);

        return redirect()->route('cms.carousel.index')->with('success', 'Slide carousel berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('cms.carousel.edit', $id);
    }

    public function edit(string $id)
    {
        $item = CarouselItem::findOrFail($id);

        return view('views.cms.carousel.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = CarouselItem::findOrFail($id);

        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_url' => ['nullable', 'url', 'max:2048', 'required_without:image_file'],
            'image_file' => ['nullable', 'image', 'max:4096', 'required_without:image_url'],
            'link_url' => ['nullable', 'string', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($uploadedImage = $this->storeUploadedImage($request, 'image_file', 'cms/carousel')) {
            $this->deleteDatabaseMedia($item->image_media_asset_id);
            $validated['image_media_asset_id'] = $uploadedImage;
            $validated['image_url'] = null;
        }

        unset($validated['image_file']);

        $item->update($validated);

        return redirect()->route('cms.carousel.index')->with('success', 'Slide carousel berhasil diperbarui.');
    }

    /**
     * Soft delete - moves to Sampah. Image is only purged on a permanent
     * delete from Sampah, so a restored slide still has its photo.
     */
    public function destroy(string $id)
    {
        $item = CarouselItem::findOrFail($id);
        $item->delete();

        return redirect()->route('cms.carousel.index')->with('success', 'Slide carousel berhasil dipindahkan ke Sampah.');
    }
}
