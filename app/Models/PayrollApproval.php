<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollApproval extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_id',
        'approved_by',
        'status',
        'remarks',
        'acted_at',
    ];

    // ── Relationships ────────────────────────────────────────

    public function approval()
    {
        return $this->hasOne(PayrollApproval::class);
    }
    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}