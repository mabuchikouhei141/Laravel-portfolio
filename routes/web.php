<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// 公開ページ用ルート
Route::get('/', [WelcomeController::class, 'index'])->name('home');
// ユーザー固有のポートフォリオ公開ページ用ルート
Route::prefix('u')->group(function () {
    // /u/{user} -> ユーザートップページ
    Route::get('{user}', [\App\Http\Controllers\PublicPortfolioController::class, 'index'])
         ->name('public.portfolio.index');

    // /u/{user}/about
    Route::get('{user}/about', [\App\Http\Controllers\PublicPortfolioController::class, 'about'])
         ->name('public.portfolio.about');

    // /u/{user}/projects
    Route::get('{user}/projects', [\App\Http\Controllers\PublicPortfolioController::class, 'projects'])
         ->name('public.portfolio.projects');

    // /u/{user}/projects/{project}
    Route::get('{user}/projects/{project}', [\App\Http\Controllers\PublicPortfolioController::class, 'projectShow'])
         ->name('public.portfolio.projects.show');
});


// 管理画面へのアクセスルート
Route::get('/admin', function () {
    return redirect()->route('dashboard');
})->name('admin');

// 認証が必要なダッシュボード
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証ユーザー用ルート - 'admin.' プレフィックスをつける
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    //サイト設定管理ルート	
    Route::get('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [App\Http\Controllers\Admin\SiteSettingController::class, 'update'])->name('settings.update');
    // プロフィール設定
    Route::get('/profile-settings', [App\Http\Controllers\Admin\ProfileSettingsController::class, 'edit'])->name('profile.edit');
    Route::put('/profile-settings', [App\Http\Controllers\Admin\ProfileSettingsController::class, 'update'])->name('profile.update');
    // プロジェクト管理ルート
    Route::resource('projects', AdminProjectController::class);
    
    // スキル管理ルート
    Route::resource('skills', SkillController::class);
    
    // 経歴管理ルート
    Route::resource('experiences', ExperienceController::class);
    
    // 教育管理ルート
    Route::resource('education', EducationController::class);
});

// プロフィール関連ルート
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 認証関連ルート（Breezeが生成）
require __DIR__.'/auth.php';
