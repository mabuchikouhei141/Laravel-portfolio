<?php
// app/Http/Controllers/Admin/ProfileSettingsController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileSettingsController extends Controller
{
    public function edit()
    {
        // ▼ ログイン中ユーザーのプロフィール設定を取得or作成
        $profile = ProfileSetting::getForCurrentUser();

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        // ▼ ログインユーザー固有のプロフィールを取得
        $profile = ProfileSetting::getForCurrentUser();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'github_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
        ]);

        // 画像がアップロードされた場合
        if ($request->hasFile('profile_image')) {
            // 古い画像を削除
            if ($profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            // 新しい画像を保存
            $validated['profile_image'] = $request->file('profile_image')->store('profile', 'public');
        }

        // 更新
        $profile->update($validated);

        return redirect()->route('admin.profile.edit')
            ->with('success', 'プロフィール情報が更新されました');
    }
}
