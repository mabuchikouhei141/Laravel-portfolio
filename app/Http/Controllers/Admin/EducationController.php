<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        // ▼ 変更点：ログインユーザーの学歴だけを取得
        $educations = Education::where('user_id', auth()->id())
            ->orderBy('start_date', 'desc')
            ->get();

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

        // ▼ 変更点：作成時に user_id をセット
        $validated['user_id'] = auth()->id();

        Education::create($validated);

        return redirect()->route('admin.education.index')
            ->with('success', '学歴が正常に追加されました');
    }

    public function edit(Education $education)
    {
        // ▼ 所有者チェック（他人の学歴を編集不可に）
        if ($education->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        return view('admin.education.edit', compact('education'));
    }

    public function update(Request $request, Education $education)
    {
        // ▼ 所有者チェック
        if ($education->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

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
        // ▼ 所有者チェック
        if ($education->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        $education->delete();

        return redirect()->route('admin.education.index')
            ->with('success', '学歴が正常に削除されました');
    }
}
