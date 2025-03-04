<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = ['institution', 'degree', 'field_of_study', 'description', 'start_date', 'end_date', 'current'];
}
