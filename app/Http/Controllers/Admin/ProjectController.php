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
        $projects = Project::all();
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

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        // JSONとして保存
        if (isset($validated['technologies'])) {
            $technologies = explode(',', $validated['technologies']);
            $validated['technologies'] = json_encode(array_map('trim', $technologies));
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'プロジェクトが正常に作成されました');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        // JSONを文字列に変換
        if ($project->technologies) {
            $project->technologies_string = implode(', ', json_decode($project->technologies));
        }
        
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
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

        if ($request->hasFile('image')) {
            // 古い画像を削除
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
        // 画像を削除
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'プロジェクトが正常に削除されました');
    }
}
