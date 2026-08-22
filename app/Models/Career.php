<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'title',
        'description',
        'location',
        'type',         //  Full-Time, Part-Time
        'deadline',
        'requirement',
    ];
}
