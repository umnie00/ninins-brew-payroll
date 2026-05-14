<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'emergency_name',
        'emergency_relationship',
        'emergency_phone',
        'job_title',
        'department',
        'hourly_rate',
        'status',
        'hired_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}