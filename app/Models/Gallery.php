<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'service_id',
        'title',
        'description',
        'location',
        'completion_date',
        'is_featured',
        'position',
        'status'
    ];

    protected $casts = [
        'completion_date' => 'date',
        'is_featured' => 'boolean',
        'status' => 'boolean'
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('position');
    }

    public function beforeImages()
    {
        return $this->hasMany(GalleryImage::class)->where('image_type', 'before')->orderBy('position');
    }

    public function afterImages()
    {
        return $this->hasMany(GalleryImage::class)->where('image_type', 'after')->orderBy('position');
    }

    public function videos()
    {
        return $this->hasMany(GalleryVideo::class)->orderBy('position');
    }

    public function youtubeVideos()
    {
        return $this->hasMany(GalleryVideo::class)->where('video_type', 'youtube')->orderBy('position');
    }

    public function getBeforeImagesCollection()
    {
        return $this->images->where('image_type', 'before')->sortBy('position');
    }

    public function getAfterImagesCollection()
    {
        return $this->images->where('image_type', 'after')->sortBy('position');
    }

    public function getFirstBeforeImageAttribute()
    {
        return $this->beforeImages()->first();
    }

    public function getFirstAfterImageAttribute()
    {
        return $this->afterImages()->first();
    }

    public function firstBeforeImage()
    {
        return $this->getBeforeImagesCollection()->first();
    }

    public function firstAfterImage()
    {
        return $this->getAfterImagesCollection()->first();
    }
}
