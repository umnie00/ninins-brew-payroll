<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $table = 'payroll';

    protected $fillable = [
        'employee_id',
        'period_start',
        'period_end',
        'total_hours',
        'overtime_hours',
        'hourly_rate',
        'gross_pay',
        'overtime_pay',
        'tax_amount',
        'net_pay',
        'status',
    ];

    // ── Relationships ────────────────────────────────────────

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function approval()
    {
        return $this->hasOne(PayrollApproval::class);
    }
}