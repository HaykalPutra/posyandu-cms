<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\OrgGroup;
use Illuminate\Http\Request;

class OrgGroupController extends Controller
{
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'description' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function index()
    {
        $groups = OrgGroup::query()
            ->withCount('members')
            ->orderBy('sort_order')
            ->get();

        return view('views.cms.struktur.index', compact('groups'));
    }

    public function create()
    {
        return view('views.cms.struktur.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        OrgGroup::create($validated);

        return redirect()->route('cms.struktur.index')->with('success', 'Kelompok struktur berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('cms.struktur.members.index', $id);
    }

    public function edit(string $id)
    {
        $group = OrgGroup::findOrFail($id);

        return view('views.cms.struktur.edit', compact('group'));
    }

    public function update(Request $request, string $id)
    {
        $group = OrgGroup::findOrFail($id);

        $validated = $request->validate($this->rules());

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        $group->update($validated);

        return redirect()->route('cms.struktur.index')->with('success', 'Kelompok struktur berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        OrgGroup::findOrFail($id)->delete();

        return redirect()->route('cms.struktur.index')->with('success', 'Kelompok struktur dipindahkan ke Sampah dan tidak lagi tampil di situs.');
    }
}
