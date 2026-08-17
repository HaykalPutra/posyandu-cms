<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = GalleryItem::query()
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('views.cms.gallery.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('views.cms.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:2048', 'required_without:image_file'],
            'image_file' => ['nullable', 'image', 'max:4096', 'required_without:image_url'],
            'captured_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($uploadedImage = $this->storeUploadedImage($request, 'image_file', 'cms/gallery')) {
            $validated['image_media_asset_id'] = $uploadedImage;
            $validated['image_url'] = null;
        }

        unset($validated['image_file']);

        GalleryItem::create($validated);

        return redirect()->route('cms.gallery.index')->with('success', 'Item galeri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('cms.gallery.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = GalleryItem::findOrFail($id);
        return view('views.cms.gallery.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = GalleryItem::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:2048', 'required_without:image_file'],
            'image_file' => ['nullable', 'image', 'max:4096', 'required_without:image_url'],
            'captured_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_featured'] = $request->boolean('is_featured');

        if ($uploadedImage = $this->storeUploadedImage($request, 'image_file', 'cms/gallery')) {
            $this->deleteDatabaseMedia($item->image_media_asset_id);
            $validated['image_media_asset_id'] = $uploadedImage;
            $validated['image_url'] = null;
        }

        unset($validated['image_file']);

        $item->update($validated);

        return redirect()->route('cms.gallery.index')->with('success', 'Item galeri berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = GalleryItem::findOrFail($id);
        $this->deleteDatabaseMedia($item->image_media_asset_id);
        $item->delete();
        return redirect()->route('cms.gallery.index')->with('success', 'Item galeri berhasil dihapus.');
    }
}
