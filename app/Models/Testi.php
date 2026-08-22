<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testi extends Model
{
    protected $table = 'testimonials';
    protected $fillable = [
        'name',
        'position',
        'message',
        'photo',
        'service',
    ];
}
