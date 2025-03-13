<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function index()
    {
        // ▼ 変更点：ログインユーザーのスキルのみ取得
        $skills = Skill::where('user_id', auth()->id())
            ->orderBy('level', 'desc')
            ->get();

        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
            'category' => 'nullable|string|max:255',
        ]);

        // ▼ 変更点：作成時に user_id を追加
        $validated['user_id'] = auth()->id();

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'スキルが正常に追加されました');
    }

    public function edit(Skill $skill)
    {
        // ▼ 所有者チェック（他人のSkillは編集不可）
        if ($skill->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        // ▼ 所有者チェック
        if ($skill->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|integer|min:0|max:100',
            'category' => 'nullable|string|max:255',
        ]);

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'スキルが正常に更新されました');
    }

    public function destroy(Skill $skill)
    {
        // ▼ 所有者チェック
        if ($skill->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'スキルが正常に削除されました');
    }
}
