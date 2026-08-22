<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'service',
        'message',
        'status'
    ];

    // Status constants
    const STATUS_NEW = 'new';
    const STATUS_READ = 'read';
    const STATUS_REPLIED = 'replied';
    const STATUS_CLOSED = 'closed';

    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => 'New',
            self::STATUS_READ => 'Read',
            self::STATUS_REPLIED => 'Replied',
            self::STATUS_CLOSED => 'Closed'
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::getStatuses()[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'new' => 'badge-primary',
            'read' => 'badge-info',
            'replied' => 'badge-success',
            'closed' => 'badge-secondary'
        ];

        return $badges[$this->status] ?? 'badge-secondary';
    }
}
