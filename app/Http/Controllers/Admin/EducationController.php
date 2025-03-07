<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $educations = Education::orderBy('start_date', 'desc')->get();
        return view('admin.education.index', compact('educations'));
    }

    public function create()
    {
        return view('admin.education.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'current' => 'boolean',
        ]);

        // 現在も在学中の場合はend_dateをnullに
        if ($request->has('current') && $request->current) {
            $validated['end_date'] = null;
        }

        Education::create($validated);

        return redirect()->route('admin.education.index')
            ->with('success', '学歴が正常に追加されました');
    }

    public function edit(Education $education)
    {
        return view('admin.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'current' => 'boolean',
        ]);

        // 現在も在学中の場合はend_dateをnullに
        if ($request->has('current') && $request->current) {
            $validated['end_date'] = null;
        }

        $education->update($validated);

        return redirect()->route('admin.education.index')
            ->with('success', '学歴が正常に更新されました');
    }

    public function destroy(Education $education)
    {
        $education->delete();

        return redirect()->route('admin.education.index')
            ->with('success', '学歴が正常に削除されました');
    }
}
