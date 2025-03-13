<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        // ▼ 変更点：ログインユーザーのプロジェクトだけ取得
        $projects = Project::where('user_id', auth()->id())->get();

        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'technologies' => 'nullable',
            'featured' => 'boolean'
        ]);

        // 画像保存
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        // JSONとして保存
        if (isset($validated['technologies'])) {
            $technologies = explode(',', $validated['technologies']);
            $validated['technologies'] = json_encode(array_map('trim', $technologies));
        }

        // ▼ 変更点：プロジェクト作成時に user_id をセット
        $validated['user_id'] = auth()->id();

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'プロジェクトが正常に作成されました');
    }

    public function show(Project $project)
    {
        // ▼ 変更点：所有者チェック (他人のProjectにはアクセス禁止)
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        // ▼ 所有者チェック
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        // JSONを文字列に変換
        if ($project->technologies) {
            $project->technologies_string = implode(', ', json_decode($project->technologies));
        }
        
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        // ▼ 所有者チェック
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048',
            'url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'technologies' => 'nullable',
            'featured' => 'boolean'
        ]);

        // 画像更新
        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        // JSONとして保存
        if (isset($validated['technologies'])) {
            $technologies = explode(',', $validated['technologies']);
            $validated['technologies'] = json_encode(array_map('trim', $technologies));
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'プロジェクトが正常に更新されました');
    }

    public function destroy(Project $project)
    {
        // ▼ 所有者チェック
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Access denied');
        }

        // 画像を削除
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'プロジェクトが正常に削除されました');
    }
}
