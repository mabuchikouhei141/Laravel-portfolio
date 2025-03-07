<?php

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
        'twitter_url'
    ];

    /**
     * デフォルトのプロフィール設定を取得または作成
     */
    public static function getDefault()
    {
        $profile = self::first();
        
        if (!$profile) {
            $profile = self::create([
                'name' => 'あなたの名前',
                'title' => 'ウェブ開発者 / デザイナー',
                'bio' => "ここにあなたの自己紹介文を記載します。専門分野、経験年数、得意なことなどを書きましょう。\n\n技術的なスキルだけでなく、チームでの役割や、どのようなプロジェクトに関わりたいかなど、あなたの人となりが伝わる文章を心がけましょう。"
            ]);
        }
        
        return $profile;
    }
}