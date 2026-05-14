@extends('layouts.app')
@section('title', 'Payroll Records')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">Payroll Records</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-money-bill-wave" style="color:#3B82F6; margin-right:4px;"></i>
            Manage and review all employee payroll
        </p>
    </div>
    <a href="{{ route('payroll.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Generate Payroll
    </a>
</div>

{{-- SUMMARY STAT CARDS --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;">

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Total Records
                </p>
                <p style="font-size:1.8rem; font-weight:700;">{{ $payrolls->count() }}</p>
            </div>
            <div style="background:rgba(59,130,246,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-file-invoice" style="color:#60A5FA; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Approved
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#10B981;">
                    {{ $payrolls->where('status','approved')->count() }}
                </p>
            </div>
            <div style="background:rgba(16,185,129,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-circle-check" style="color:#10B981; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Pending
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#F59E0B;">
                    {{ $payrolls->where('status','pending')->count() }}
                </p>
            </div>
            <div style="background:rgba(245,158,11,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-hourglass-half" style="color:#F59E0B; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Total Net Pay
                </p>
                <p style="font-size:1.1rem; font-weight:700; color:#60A5FA; margin-top:0.4rem;">
                    ₱{{ number_format($payrolls->where('status','approved')->sum('net_pay'), 0) }}
                </p>
            </div>
            <div style="background:rgba(96,165,250,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-peso-sign" style="color:#60A5FA; font-size:1rem;"></i>
            </div>
        </div>
    </div>

</div>

{{-- PAYROLL TABLE --}}
<div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">

    {{-- Table Header --}}
    <div style="padding:1rem 1.5rem; border-bottom:1px solid #F1F5F9;
                display:flex; justify-content:space-between; align-items:center;
                background:#1E293B;">
        <p style="font-weight:700; font-size:0.9rem; color:white;">
            <i class="fa-solid fa-table-list" style="color:#60A5FA; margin-right:6px;"></i>
            All Payroll Records
        </p>
        <span style="font-size:0.78rem; color:#94A3B8;">
            {{ $payrolls->count() }} record(s)
        </span>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Period</th>
                    <th>Total Hours</th>
                    <th>Gross Pay</th>
                    <th>Tax (10%)</th>
                    <th>Net Pay</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payrolls as $payroll)
                <tr>
                    <td style="color:#9CA3AF; font-size:0.82rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <div style="width:32px; height:32px; background:#1E293B;
                                        border-radius:8px; display:flex; align-items:center;
                                        justify-content:center; font-size:0.75rem;
                                        font-weight:700; color:#60A5FA; flex-shrink:0;">
                                {{ strtoupper(substr($payroll->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight:600; font-size:0.875rem; color:#111827;">
                                    {{ $payroll->employee->full_name }}
                                </p>
                                <p style="font-size:0.75rem; color:#9CA3AF;">
                                    {{ $payroll->employee->job_title }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:0.82rem; background:#F8FAFC; padding:0.25rem 0.6rem;
                                     border-radius:6px; color:#374151; font-weight:500;">
                            {{ \Carbon\Carbon::parse($payroll->period_start)->format('M d') }}
                            –
                            {{ \Carbon\Carbon::parse($payroll->period_end)->format('M d, Y') }}
                        </span>
                    </td>
                    <td>
                        <span style="font-weight:600; color:#374151;">
                            {{ $payroll->total_hours }}h
                        </span>
                        @if($payroll->overtime_hours > 0)
                            <span style="font-size:0.72rem; color:#F59E0B; display:block;">
                                +{{ $payroll->overtime_hours }}h OT
                            </span>
                        @endif
                    </td>
                    <td style="color:#374151;">
                        ₱{{ number_format($payroll->gross_pay + $payroll->overtime_pay, 2) }}
                    </td>
                    <td style="color:#EF4444;">
                        ₱{{ number_format($payroll->tax_amount, 2) }}
                    </td>
                    <td>
                        <strong style="color:#10B981; font-size:0.95rem;">
                            ₱{{ number_format($payroll->net_pay, 2) }}
                        </strong>
                    </td>
                    <td>
                        <span class="badge badge-{{ $payroll->status }}">
                            @if($payroll->status === 'approved')
                                <i class="fa-solid fa-check" style="margin-right:3px;"></i>
                            @elseif($payroll->status === 'rejected')
                                <i class="fa-solid fa-xmark" style="margin-right:3px;"></i>
                            @else
                                <i class="fa-solid fa-hourglass-half" style="margin-right:3px;"></i>
                            @endif
                            {{ ucfirst($payroll->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('payroll.show', $payroll->id) }}"
                               style="background:#EFF6FF; color:#1E3A8A; padding:0.3rem 0.7rem;
                                      border-radius:6px; font-size:0.78rem; font-weight:600;
                                      text-decoration:none; display:inline-flex; align-items:center; gap:0.3rem;">
                                <i class="fa-solid fa-eye"></i> View
                            </a>
                            <form action="{{ route('payroll.destroy', $payroll->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete this payroll record?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        style="background:#FEF2F2; color:#EF4444; padding:0.3rem 0.7rem;
                                               border-radius:6px; font-size:0.78rem; font-weight:600;
                                               border:none; cursor:pointer; display:inline-flex;
                                               align-items:center; gap:0.3rem;">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; color:#6B7280; padding:3rem;">
                        <i class="fa-solid fa-folder-open" style="font-size:2rem; color:#D1D5DB; display:block; margin-bottom:0.75rem;"></i>
                        No payroll records yet.
                        <a href="{{ route('payroll.create') }}" style="color:#3B82F6; font-weight:600;">
                            Generate one now!
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection