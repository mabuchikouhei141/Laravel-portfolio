<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index()
    {
        // ▼ 変更点：ログインユーザーの職歴のみ取得
        $experiences = Experience::where('user_id', auth()->id())
            ->orderBy('start_date', 'desc')
            ->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'current' => 'boolean',
        ]);

        // 現在も続いている場合はend_dateをnullに
        if ($request->has('current') && $request->current) {
            $validated['end_date'] = null;
        }

        // ▼ 変更点：作成時に user_id をセット
        $validated['user_id'] = auth()->id();

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', '職歴が正常に追加されました');
    }

    public function edit(Experience $experience)
    {
        // ▼ 所有者チェック
        if ($experience->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        // ▼ 所有者チェック
        if ($experience->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        $validated = $request->validate([
            'position' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'current' => 'boolean',
        ]);

        if ($request->has('current') && $request->current) {
            $validated['end_date'] = null;
        }

        $experience->update($validated);

        return redirect()->route('admin.experiences.index')
            ->with('success', '職歴が正常に更新されました');
    }

    public function destroy(Experience $experience)
    {
        // ▼ 所有者チェック
        if ($experience->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        $experience->delete();

        return redirect()->route('admin.experiences.index')
            ->with('success', '職歴が正常に削除されました');
    }
}
