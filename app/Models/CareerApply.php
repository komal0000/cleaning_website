<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApply extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'position',
        'experience',
        'availability',
        'resume_path',
        'cover_letter'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
