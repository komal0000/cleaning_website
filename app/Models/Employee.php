<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'employee_code',
        'employee_password',
        'email',
        'is_active',
    ];

    protected $hidden = [
        'employee_password',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function openAttendanceRecord(): ?AttendanceRecord
    {
        return $this->attendanceRecords()
            ->whereNull('clock_out_at')
            ->latest('clock_in_at')
            ->first();
    }

    public function hasValidEmail(): bool
    {
        return filled($this->email) && filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false;
    }
}
