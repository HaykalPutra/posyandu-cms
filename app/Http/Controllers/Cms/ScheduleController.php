<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    private function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:180'],
            'category' => ['nullable', 'string', 'max:80'],
            'schedule_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:180'],
            'accent' => ['nullable', 'in:primary,tertiary'],
            'notes' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function index()
    {
        $items = Schedule::query()
            ->orderBy('schedule_date')
            ->orderBy('sort_order')
            ->paginate(20);

        return view('views.cms.schedules.index', compact('items'));
    }

    public function create()
    {
        return view('views.cms.schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['accent'] = $validated['accent'] ?? 'primary';
        $validated['is_active'] = $request->boolean('is_active', true);

        Schedule::create($validated);

        return redirect()->route('cms.schedules.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        return redirect()->route('cms.schedules.edit', $id);
    }

    public function edit(string $id)
    {
        $item = Schedule::findOrFail($id);

        return view('views.cms.schedules.edit', compact('item'));
    }

    public function update(Request $request, string $id)
    {
        $item = Schedule::findOrFail($id);

        $validated = $request->validate($this->rules());

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['accent'] = $validated['accent'] ?? 'primary';
        $validated['is_active'] = $request->boolean('is_active', true);

        $item->update($validated);

        return redirect()->route('cms.schedules.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Soft delete - moves to Sampah instead of vanishing immediately.
     */
    public function destroy(string $id)
    {
        Schedule::findOrFail($id)->delete();

        return redirect()->route('cms.schedules.index')->with('success', 'Jadwal berhasil dipindahkan ke Sampah.');
    }
}
