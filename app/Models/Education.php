<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    
    protected $table = 'education'; // テーブル名が単数形なので指定
    
    protected $fillable = [
        'institution',
        'degree',
        'field',
        'description',
        'start_date',
        'end_date',
        'current',
        'user_id',
    ];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'current' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
