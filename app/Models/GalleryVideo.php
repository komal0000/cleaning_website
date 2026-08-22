<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryVideo extends Model
{
    protected $fillable = [
        'gallery_id',
        'video_url',
        'video_type',
        'caption',
        'position'
    ];

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }

    /**
     * Get YouTube video ID from URL
     */
    public function getYoutubeIdAttribute()
    {
        if ($this->video_type !== 'youtube') {
            return null;
        }

        // Extract YouTube video ID from various URL formats
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        preg_match($pattern, $this->video_url, $matches);
        
        return isset($matches[1]) ? $matches[1] : null;
    }

    /**
     * Get YouTube embed URL
     */
    public function getEmbedUrlAttribute()
    {
        if ($this->video_type === 'youtube' && $this->youtube_id) {
            return "https://www.youtube.com/embed/{$this->youtube_id}";
        }

        return $this->video_url;
    }

    /**
     * Get YouTube thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->video_type === 'youtube' && $this->youtube_id) {
            return "https://img.youtube.com/vi/{$this->youtube_id}/maxresdefault.jpg";
        }

        return null;
    }
}
