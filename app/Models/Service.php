<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'features',
        'position',
        'logo',
        'feature_image'
    ];

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }
}
