@extends('layouts.app')
@section('title', 'My Payslip')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">My Payslip</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-file-invoice-dollar" style="color:#3B82F6; margin-right:4px;"></i>
            Generated on {{ $payroll->created_at->format('F d, Y') }}
        </p>
    </div>
    <a href="{{ route('payslip.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
</div>

{{-- TWO COLUMN LAYOUT --}}
<div style="display:grid; grid-template-columns:1fr 1.4fr; gap:1.5rem; align-items:start;">

    {{-- LEFT: Employee Info + Status --}}
    <div style="display:flex; flex-direction:column; gap:1rem;">

        {{-- Employee Card --}}
        <div style="background:#1E293B; border-radius:12px; padding:1.5rem; color:white;">
            <div style="display:flex; align-items:center; gap:1rem; margin-bottom:1.25rem;">
                <div style="width:50px; height:50px;
                            background:linear-gradient(135deg,#3B82F6,#1E3A8A);
                            border-radius:12px; display:flex; align-items:center;
                            justify-content:center; font-size:1.2rem; font-weight:700;
                            color:white; flex-shrink:0;">
                    {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                </div>
                <div>
                    <p style="font-weight:700; font-size:1rem; margin-bottom:0.15rem;">
                        {{ $employee->full_name }}
                    </p>
                    <p style="font-size:0.8rem; color:#94A3B8;">
                        {{ $employee->job_title }}
                    </p>
                </div>
            </div>
            <div style="border-top:1px solid rgba(255,255,255,0.1); padding-top:1rem;
                        display:flex; flex-direction:column; gap:0.6rem;">
                <div style="display:flex; justify-content:space-between; font-size:0.82rem;">
                    <span style="color:#94A3B8;">Department</span>
                    <span style="color:white;">{{ $employee->department }}</span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.82rem;">
                    <span style="color:#94A3B8;">Hourly Rate</span>
                    <span style="color:#60A5FA; font-weight:600;">
                        ₱{{ number_format($payroll->hourly_rate, 2) }}/hr
                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; font-size:0.82rem;">
                    <span style="color:#94A3B8;">Pay Period</span>
                    <span style="color:white;">
                        {{ \Carbon\Carbon::parse($payroll->period_start)->format('M d') }}
                        –
                        {{ \Carbon\Carbon::parse($payroll->period_end)->format('M d, Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Status Card --}}
        <div style="background:white; border-radius:12px; padding:1.25rem;
                    box-shadow:0 1px 4px rgba(0,0,0,0.07);
                    border-left:4px solid #10B981;">
            <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                      color:#6B7280; margin-bottom:0.5rem;">
                Payslip Status
            </p>
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <i class="fa-solid fa-circle-check" style="color:#10B981; font-size:1.2rem;"></i>
                <span style="font-weight:700; font-size:1rem; color:#10B981;">Approved</span>
            </div>
            <p style="font-size:0.78rem; color:#9CA3AF; margin-top:0.4rem;">
                Released and available for viewing
            </p>
        </div>

        {{-- Hours Summary --}}
        <div style="background:white; border-radius:12px; padding:1.25rem;
                    box-shadow:0 1px 4px rgba(0,0,0,0.07);">
            <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                      color:#6B7280; margin-bottom:1rem; font-weight:600;">
                <i class="fa-solid fa-clock" style="margin-right:4px;"></i>
                Hours Summary
            </p>
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.85rem; color:#6B7280;">Total Hours</span>
                    <span style="font-weight:700; font-size:1rem; color:#111827;">
                        {{ $payroll->total_hours }}h
                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.85rem; color:#6B7280;">Regular Hours</span>
                    <span style="font-weight:600; color:#3B82F6;">
                        {{ round($payroll->total_hours - $payroll->overtime_hours, 2) }}h
                    </span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.85rem; color:#6B7280;">Overtime Hours</span>
                    <span style="font-weight:600; color:#F59E0B;">
                        {{ $payroll->overtime_hours }}h
                        @if($payroll->overtime_hours > 0)
                            <span style="font-size:0.72rem; color:#9CA3AF;">(×1.5)</span>
                        @endif
                    </span>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT: Pay Breakdown --}}
    <div style="background:white; border-radius:12px;
                box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">

        {{-- Header --}}
        <div style="background:#1E293B; padding:1.25rem 1.5rem;">
            <div style="display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <p style="font-weight:700; font-size:0.95rem; color:white; margin-bottom:0.2rem;">
                        <i class="fa-solid fa-file-invoice-dollar"
                           style="color:#60A5FA; margin-right:6px;"></i>
                        Pay Breakdown
                    </p>
                    <p style="font-size:0.78rem; color:#94A3B8;">
                        {{ \Carbon\Carbon::parse($payroll->period_start)->format('F d') }}
                        –
                        {{ \Carbon\Carbon::parse($payroll->period_end)->format('F d, Y') }}
                    </p>
                </div>
                <div style="text-align:center;">
                    <div style="background:rgba(16,185,129,0.15); border:1px solid rgba(16,185,129,0.3);
                                border-radius:8px; padding:0.4rem 0.8rem;">
                        <p style="font-size:0.65rem; color:#6EE7B7; text-transform:uppercase;
                                  letter-spacing:0.08em; margin-bottom:0.1rem;">Ninin's Brew</p>
                        <p style="font-size:0.72rem; color:#A7F3D0; font-weight:500;">
                            Payroll System
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Earnings --}}
        <div style="padding:1.25rem 1.5rem; border-bottom:1px solid #F1F5F9;">
            <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                      color:#94A3B8; margin-bottom:1rem; font-weight:600;">
                Earnings
            </p>
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <p style="font-size:0.875rem; color:#374151;">Basic Pay</p>
                        <p style="font-size:0.75rem; color:#9CA3AF;">
                            {{ round($payroll->total_hours - $payroll->overtime_hours, 2) }}h
                            × ₱{{ number_format($payroll->hourly_rate, 2) }}
                        </p>
                    </div>
                    <span style="font-weight:600; color:#111827;">
                        ₱{{ number_format($payroll->gross_pay, 2) }}
                    </span>
                </div>
                @if($payroll->overtime_hours > 0)
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <p style="font-size:0.875rem; color:#374151;">Overtime Pay</p>
                            <p style="font-size:0.75rem; color:#9CA3AF;">
                                {{ $payroll->overtime_hours }}h
                                × ₱{{ number_format($payroll->hourly_rate * 1.5, 2) }}
                            </p>
                        </div>
                        <span style="font-weight:600; color:#F59E0B;">
                            + ₱{{ number_format($payroll->overtime_pay, 2) }}
                        </span>
                    </div>
                @endif
                <div style="background:#F8FAFC; border-radius:8px; padding:0.75rem 1rem;
                            display:flex; justify-content:space-between; align-items:center;
                            margin-top:0.25rem;">
                    <span style="font-weight:600; font-size:0.875rem; color:#374151;">
                        Total Earnings
                    </span>
                    <span style="font-weight:700; font-size:1rem; color:#111827;">
                        ₱{{ number_format($payroll->gross_pay + $payroll->overtime_pay, 2) }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Deductions --}}
        <div style="padding:1.25rem 1.5rem; border-bottom:1px solid #F1F5F9;">
            <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                      color:#94A3B8; margin-bottom:1rem; font-weight:600;">
                Deductions
            </p>
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <p style="font-size:0.875rem; color:#374151;">Income Tax</p>
                    <p style="font-size:0.75rem; color:#9CA3AF;">10% of total earnings</p>
                </div>
                <span style="font-weight:600; color:#EF4444;">
                    − ₱{{ number_format($payroll->tax_amount, 2) }}
                </span>
            </div>
        </div>

        {{-- Net Pay --}}
        <div style="padding:1.5rem;
                    background:linear-gradient(135deg, #0F172A, #1E3A8A);">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.1em;
                              color:#94A3B8; margin-bottom:0.3rem;">
                        Net Pay
                    </p>
                    <p style="font-size:0.8rem; color:#64748B;">After all deductions</p>
                </div>
                <div style="text-align:right;">
                    <p style="font-size:1.75rem; font-weight:800; color:#10B981;
                              letter-spacing:-0.02em;">
                        ₱{{ number_format($payroll->net_pay, 2) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div style="padding:1rem 1.5rem; background:#F8FAFC;
                    display:flex; justify-content:space-between; align-items:center;">
            <span style="font-size:0.78rem; color:#9CA3AF;">
                <i class="fa-solid fa-clock-rotate-left" style="margin-right:4px;"></i>
                Generated {{ $payroll->created_at->format('F d, Y') }}
            </span>
            <span class="badge badge-approved">
                <i class="fa-solid fa-check" style="margin-right:3px;"></i>
                Approved
            </span>
        </div>

    </div>

</div>

@endsection