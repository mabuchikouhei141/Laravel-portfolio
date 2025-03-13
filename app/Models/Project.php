<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'image',
        'url',
        'github_url',
        'technologies',
        'featured',
        'user_id',
    ];
    
    protected $casts = [
        'featured' => 'boolean',
    ];
    
    // オプション: technologiesをJSON配列として取得するアクセサ
    public function getTechnologiesArrayAttribute()
    {
        return $this->technologies ? json_decode($this->technologies) : [];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
