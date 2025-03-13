<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        // 例: プロジェクトとの関係
        public function projects()
        {
            return $this->hasMany(Project::class);
        }
    
        // 例: スキルとの関係
        public function skills()
        {
            return $this->hasMany(Skill::class);
        }
    
        // 例: 経験 (experiences) との関係
        public function experiences()
        {
            return $this->hasMany(Experience::class);
        }
    
        // 例: 学歴 (education) との関係
        public function education()
        {
            return $this->hasMany(Education::class);
        }
    
        // 例: プロフィール設定 (profile_settings) との関係
        public function profileSettings()
        {
            return $this->hasMany(ProfileSetting::class);
        }
}
