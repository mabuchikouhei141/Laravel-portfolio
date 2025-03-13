<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'position',  // title → position
        'company',
        'description',
        'location',  // location追加
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
