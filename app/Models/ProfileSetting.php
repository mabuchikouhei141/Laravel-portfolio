<?php

// app/Models/ProfileSetting.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'title', 
        'bio', 
        'profile_image',
        'github_url',
        'twitter_url',
        'user_id',
    ];

    /**
     * ログインユーザー固有のプロフィール設定を取得または作成
     */
    public static function getForCurrentUser()
    {
        $userId = auth()->id();

        // user_id がログインユーザのレコードを取得
        $profile = self::where('user_id', $userId)->first();

        // なければ作成（デフォルト値を設定）
        if (!$profile) {
            $profile = self::create([
                'user_id' => $userId,
                'name' => 'あなたの名前',
                'title' => 'ウェブ開発者 / デザイナー',
                'bio' => "ここにあなたの自己紹介文を...\n",
                // 必要に応じて github_url, twitter_url のデフォルトも設定可
            ]);
        }

        return $profile;
    }

    // オプション: ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}