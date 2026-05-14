@extends('layouts.app')
@section('title', 'My Payslips')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">My Payslips</h1>
        <p style="color:#6B7280; margin-top:0.25rem;">
            Review your payslips, track earnings, and monitor deductions all in one place.
    </div>
</div>

{{-- MAIN TWO-COLUMN LAYOUT --}}
<div style="display:grid; grid-template-columns:220px 1fr; gap:1.5rem; align-items:start;">

    {{-- LEFT COLUMN: Dark Stat Cards stacked vertically --}}
    <div style="display:flex; flex-direction:column; gap:1rem; position:sticky; top:0; align-self:start;">

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        <i class="fa-solid fa-receipt" style="margin-right:4px;"></i>
                        Total Payslips
                    </p>
                    <p style="font-size:1.8rem; font-weight:700;">{{ $payslips->count() }}</p>
                </div>
                <div style="background:rgba(59,130,246,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-file-invoice" style="color:#60A5FA; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        <i class="fa-solid fa-peso-sign" style="margin-right:4px;"></i>
                        Total Net Pay
                    </p>
                    <p style="font-size:1.5rem; font-weight:700; color:#10B981;">
                        ₱{{ number_format($payslips->sum('net_pay'), 0) }}
                    </p>
                </div>
                <div style="background:rgba(16,185,129,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-money-bill" style="color:#10B981; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        <i class="fa-solid fa-receipt" style="margin-right:4px;"></i>
                        Total Tax Paid
                    </p>
                    <p style="font-size:1.5rem; font-weight:700; color:#EF4444;">
                        ₱{{ number_format($payslips->sum('tax_amount'), 0) }}
                    </p>
                </div>
                <div style="background:rgba(239,68,68,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-file-csv" style="color:#EF4444; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        <i class="fa-solid fa-chart-line" style="margin-right:4px;"></i>
                        Total Gross Pay
                    </p>
                    <p style="font-size:1.5rem; font-weight:700; color:#F59E0B;">
                        ₱{{ number_format($payslips->sum(fn($p) => $p->gross_pay + $p->overtime_pay), 0) }}
                    </p>
                </div>
                <div style="background:rgba(245,158,11,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-chart-column" style="color:#F59E0B; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN: Filter on top + Table below --}}
    <div style="display:flex; flex-direction:column; gap:1rem;">

        {{-- FILTER BAR --}}
        <div style="background:white; border-radius:12px; padding:1.25rem 1.5rem;
                    box-shadow:0 1px 4px rgba(0,0,0,0.07);">
            <p style="font-size:0.78rem; font-weight:600; text-transform:uppercase;
                      letter-spacing:0.05em; color:#6B7280; margin-bottom:1rem;">
                <i class="fa-solid fa-filter" style="margin-right:4px;"></i>
                Filter Payslips
            </p>
            <form method="GET" action="{{ route('payslip.index') }}">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; margin-bottom:0.75rem;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-control">
                            <option value="">-- All Months --</option>
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}" {{ request('month') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Year</label>
                        <select name="year" class="form-control">
                            @foreach($years as $y)
                                <option value="{{ $y }}"
                                    {{ request('year', \Carbon\Carbon::now()->year) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">From Date</label>
                        <input type="date" name="date_from"
                               value="{{ request('date_from') }}"
                               class="form-control">
                    </div>
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">To Date</label>
                        <input type="date" name="date_to"
                               value="{{ request('date_to') }}"
                               class="form-control">
                    </div>
                </div>
                <div style="display:flex; gap:0.5rem;">
                    <button type="submit" class="btn btn-primary" style="flex:1;">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>
                    <a href="{{ route('payslip.index') }}" class="btn btn-secondary" style="flex:1; text-align:center;">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- PAYSLIPS TABLE --}}
        <div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">
            <div style="padding:1rem 1.5rem; background:#1E293B;
                        display:flex; justify-content:space-between; align-items:center;">
                <p style="font-weight:700; font-size:0.9rem; color:white;">
                    <i class="fa-solid fa-table-list" style="color:#60A5FA; margin-right:6px;"></i>
                    Payslip Records
                </p>
                <span style="font-size:0.78rem; color:#94A3B8;">
                    @if(request('month') || request('year') || request('date_from') || request('date_to'))
                        {{ $payslips->count() }} result(s) found
                    @else
                        {{ $payslips->count() }} total record(s)
                    @endif
                </span>
            </div>
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Pay Period</th>
                            <th>Hours</th>
                            <th>Gross Pay</th>
                            <th>Tax (10%)</th>
                            <th>Net Pay</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payslips as $payslip)
                        <tr>
                            <td style="color:#9CA3AF; font-size:0.82rem;">{{ $loop->iteration }}</td>
                            <td>
                                <span style="font-size:0.82rem; background:#F8FAFC; padding:0.25rem 0.6rem;
                                             border-radius:6px; color:#374151; font-weight:500;">
                                    {{ \Carbon\Carbon::parse($payslip->period_start)->format('M d') }}
                                    –
                                    {{ \Carbon\Carbon::parse($payslip->period_end)->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <div style="font-size:0.875rem; color:#374151; font-weight:500;">
                                    {{ $payslip->total_hours }}h
                                    @if($payslip->overtime_hours > 0)
                                        <span style="font-size:0.72rem; color:#F59E0B; display:block;">
                                            +{{ $payslip->overtime_hours }}h OT
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td style="color:#374151; font-weight:500;">
                                ₱{{ number_format($payslip->gross_pay + $payslip->overtime_pay, 2) }}
                            </td>
                            <td style="color:#EF4444; font-weight:500;">
                                ₱{{ number_format($payslip->tax_amount, 2) }}
                            </td>
                            <td>
                                <strong style="color:#10B981; font-size:0.95rem;">
                                    ₱{{ number_format($payslip->net_pay, 2) }}
                                </strong>
                            </td>
                            <td>
                                <div class="actions" style="display:flex; gap:0.4rem;">
                                    <a href="{{ route('payslip.show', $payslip->id) }}"
                                       style="background:#EFF6FF; color:#1E3A8A; padding:0.3rem 0.7rem;
                                              border-radius:6px; font-size:0.78rem; font-weight:600;
                                              text-decoration:none; display:inline-flex;
                                              align-items:center; gap:0.3rem;">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color:#6B7280; padding:3rem;">
                                <i class="fa-solid fa-folder-open" style="font-size:2rem; color:#D1D5DB;
                                          display:block; margin-bottom:0.75rem;"></i>
                                @if(request('month') || request('year') || request('date_from') || request('date_to'))
                                    No payslips found matching your filter.
                                @else
                                    No payslips yet. Once your payroll is approved, they'll appear here.
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection