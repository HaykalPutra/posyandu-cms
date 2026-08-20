<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\OrgGroup;
use App\Models\OrgMember;
use Illuminate\Http\Request;

class OrgMemberController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'position' => ['required', 'string', 'max:150'],
            'photo_url' => ['nullable', 'url', 'max:2048'],
            'photo_file' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function index(string $group)
    {
        $group = OrgGroup::findOrFail($group);
        $members = $group->members()->paginate(30);

        return view('views.cms.struktur.members.index', compact('group', 'members'));
    }

    public function create(string $group)
    {
        $group = OrgGroup::findOrFail($group);

        return view('views.cms.struktur.members.create', compact('group'));
    }

    public function store(Request $request, string $group)
    {
        $group = OrgGroup::findOrFail($group);

        $validated = $request->validate($this->rules());
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['org_group_id'] = $group->id;

        if ($mediaId = $this->storeUploadedImage($request, 'photo_file', 'cms/struktur')) {
            $validated['photo_media_asset_id'] = $mediaId;
            $validated['photo_url'] = null;
        }

        unset($validated['photo_file']);

        OrgMember::create($validated);

        return redirect()->route('cms.struktur.members.index', $group->id)->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function edit(string $group, string $member)
    {
        $group = OrgGroup::findOrFail($group);
        $member = OrgMember::where('org_group_id', $group->id)->findOrFail($member);

        return view('views.cms.struktur.members.edit', compact('group', 'member'));
    }

    public function update(Request $request, string $group, string $member)
    {
        $group = OrgGroup::findOrFail($group);
        $member = OrgMember::where('org_group_id', $group->id)->findOrFail($member);

        $validated = $request->validate($this->rules());
        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = $request->boolean('is_active', true);

        if ($mediaId = $this->storeUploadedImage($request, 'photo_file', 'cms/struktur')) {
            $validated['photo_media_asset_id'] = $mediaId;
            $validated['photo_url'] = null;
        }

        unset($validated['photo_file']);

        $member->update($validated);

        return redirect()->route('cms.struktur.members.index', $group->id)->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(string $group, string $member)
    {
        $group = OrgGroup::findOrFail($group);
        $member = OrgMember::where('org_group_id', $group->id)->findOrFail($member);
        $member->delete();

        return redirect()->route('cms.struktur.members.index', $group->id)->with('success', 'Anggota dipindahkan ke Sampah.');
    }
}
