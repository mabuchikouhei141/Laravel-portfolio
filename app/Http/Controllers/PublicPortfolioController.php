<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class PublicPortfolioController extends Controller
{
    // ユーザーのトップページ (/u/{user})
    public function index(User $user)
    {
        // 例：ユーザーのプロフィール＋代表プロジェクト
        // 必要であれば ProfileSetting も取得
        $profile = $user->profileSettings()->first(); // hasManyの場合
        // $profile = $user->profileSettings; // 複数取得するなら

        // プロジェクトのうちfeaturedなものだけ取得
        $featuredProjects = $user->projects()->where('featured', true)->take(3)->get();

        // スキル一覧 (user->skills)
        $skills = $user->skills()->get();

        return view('public_portfolio.index', compact('user', 'profile', 'featuredProjects', 'skills'));
    }

    // Aboutページ (/u/{user}/about)
    public function about(User $user)
    {
        // スキル、職歴、学歴などを取得
        $skillsByCategory = $user->skills()
                                 ->orderBy('level', 'desc')
                                 ->get()
                                 ->groupBy('category');

        $experiences = $user->experiences()
                            ->orderBy('start_date', 'desc')
                            ->get();

        $education = $user->education()
                          ->orderBy('start_date', 'desc')
                          ->get();

        // ProfileSettingも必要であれば取得
        $profile = $user->profileSettings()->first();

        return view('public_portfolio.about', compact('user', 'skillsByCategory', 'experiences', 'education', 'profile'));
    }

    // プロジェクト一覧 (/u/{user}/projects)
    public function projects(User $user)
    {
        // ログイン不要で閲覧できる公開ページなので user->projects を取得
        $projects = $user->projects()
                         ->orderBy('created_at', 'desc')
                         ->get();
        
        return view('public_portfolio.projects', compact('user', 'projects'));
    }

    // プロジェクト詳細 (/u/{user}/projects/{project})
    public function projectShow(User $user, Project $project)
    {
        // ユーザーとプロジェクトの関連性チェック
        if ($project->user_id !== $user->id) {
            abort(404); // 又は403
        }

        return view('public_portfolio.project_show', compact('user', 'project'));
    }
}
