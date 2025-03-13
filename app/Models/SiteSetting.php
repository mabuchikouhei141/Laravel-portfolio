<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'key', 'value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 指定したキーの設定値を取得する
     */
    public static function getValue($key, $default = null, $userId = null)
    {
        // (後述) ログインユーザーIDをデフォルトにする実装
        $userId = $userId ?? auth()->id();

        // user_id がある設定を優先して取得する
        $setting = self::where('key', $key)
                       ->where('user_id', $userId)
                       ->first();

        return $setting ? $setting->value : $default;
    }

    public static function setValue($key, $value, $userId = null)
    {
        $userId = $userId ?? auth()->id();

        // "key + user_id" でユニークになるように updateOrCreate
        $setting = self::updateOrCreate(
            ['key' => $key, 'user_id' => $userId],
            ['value' => $value]
        );

        return $setting;
    }
}
