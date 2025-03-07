<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'hero_title' => SiteSetting::getValue('hero_title', 'ようこそ、私のポートフォリオへ'),
            'hero_subtitle' => SiteSetting::getValue('hero_subtitle', 'ウェブ開発者・デザイナーとしての作品を紹介します'),
            'hero_image' => SiteSetting::getValue('hero_image'),
        ];

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_image' => 'nullable|image|max:2048',
        ]);

        // テキスト設定を保存
        SiteSetting::setValue('hero_title', $validated['hero_title']);
        SiteSetting::setValue('hero_subtitle', $validated['hero_subtitle']);

        // ヒーロー画像の処理
        if ($request->hasFile('hero_image')) {
            // 古い画像を削除（存在する場合）
            $oldImage = SiteSetting::getValue('hero_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }

            // 新しい画像を保存
            $path = $request->file('hero_image')->store('hero-images', 'public');
            SiteSetting::setValue('hero_image', $path);
        }

        // 画像削除チェックボックスがチェックされた場合
        if ($request->has('remove_hero_image') && $request->input('remove_hero_image')) {
            $oldImage = SiteSetting::getValue('hero_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            SiteSetting::setValue('hero_image', null);
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'サイト設定が更新されました');
    }
}
