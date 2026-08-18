<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\HomeStat;
use Illuminate\Http\Request;

class HomeStatController extends Controller
{
    private function rules(): array
    {
        return [
            'value' => ['required', 'string', 'max:40'],
            'label' => ['required', 'string', 'max:120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function index()
    {
        $items = HomeStat::query()
            ->orderBy('sort_order')
            ->paginate(20);

        return view('views.cms.home-stats.index', compact('items'));
    }

    public function create()
    {
        return view('views.cms.home-stats.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        HomeStat::create($validated);

        return redirect()->route('cms.home-stats.index')->with('success', 'Statistik berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('cms.home-stats.edit', $id);
    }

    public function edit(string $id)
    {
        $item = HomeStat::findOrFail($id);

        return view('views.cms.home-stats.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = HomeStat::findOrFail($id);

        $validated = $request->validate($this->rules());

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        $item->update($validated);

        return redirect()->route('cms.home-stats.index')->with('success', 'Statistik berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        HomeStat::findOrFail($id)->delete();

        return redirect()->route('cms.home-stats.index')->with('success', 'Statistik berhasil dihapus.');
    }
}
