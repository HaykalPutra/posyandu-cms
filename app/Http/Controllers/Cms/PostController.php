<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::query()->orderByDesc('published_at')->paginate(15);
        return view('views.cms.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('views.cms.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'alpha_dash', 'max:120', 'unique:posts,slug'],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'url', 'max:2048'],
            'cover_image_file' => ['nullable', 'image', 'max:4096'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $validated['published_at'] ?? now();

        if ($uploadedImage = $this->storeUploadedImage($request, 'cover_image_file', 'cms/posts')) {
            $validated['cover_media_asset_id'] = $uploadedImage;
            $validated['cover_image'] = null;
        }

        unset($validated['cover_image_file']);

        Post::create($validated);

        return redirect()->route('cms.posts.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return redirect()->route('cms.posts.edit', $id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        return view('views.cms.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'alpha_dash', 'max:120', Rule::unique('posts', 'slug')->ignore($post->id)],
            'category' => ['nullable', 'string', 'max:80'],
            'excerpt' => ['nullable', 'string'],
            'body' => ['required', 'string'],
            'cover_image' => ['nullable', 'url', 'max:2048'],
            'cover_image_file' => ['nullable', 'image', 'max:4096'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        $validated['is_published'] = $request->boolean('is_published');

        if ($uploadedImage = $this->storeUploadedImage($request, 'cover_image_file', 'cms/posts')) {
            $this->deleteDatabaseMedia($post->cover_media_asset_id);
            $validated['cover_media_asset_id'] = $uploadedImage;
            $validated['cover_image'] = null;
        }

        unset($validated['cover_image_file']);

        $post->update($validated);

        return redirect()->route('cms.posts.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $this->deleteDatabaseMedia($post->cover_media_asset_id);
        $post->delete();
        return redirect()->route('cms.posts.index')->with('success', 'Berita berhasil dihapus.');
    }
}
