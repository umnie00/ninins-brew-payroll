@extends('layouts.app')
@section('title', 'Attendance Records')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">Attendance Records</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-calendar-check" style="color:#3B82F6; margin-right:4px;"></i>
            Monitor all employee attendance logs
        </p>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;">

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Total Records
                </p>
                <p style="font-size:1.8rem; font-weight:700;">{{ $attendance->count() }}</p>
            </div>
            <div style="background:rgba(59,130,246,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-calendar" style="color:#60A5FA; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Complete
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#10B981;">
                    {{ $attendance->whereNotNull('time_out')->count() }}
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
                    In Progress
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#F59E0B;">
                    {{ $attendance->whereNull('time_out')->count() }}
                </p>
            </div>
            <div style="background:rgba(245,158,11,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-spinner" style="color:#F59E0B; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Total Hours
                </p>
                <p style="font-size:1.4rem; font-weight:700; color:#60A5FA; margin-top:0.3rem;">
                    {{ number_format($attendance->sum('hours_worked'), 2) }}h
                </p>
            </div>
            <div style="background:rgba(96,165,250,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-clock" style="color:#60A5FA; font-size:1rem;"></i>
            </div>
        </div>
    </div>

</div>

{{-- FILTER BAR --}}
<div style="background:white; border-radius:12px; padding:1.25rem 1.5rem;
            box-shadow:0 1px 4px rgba(0,0,0,0.07); margin-bottom:1.5rem;">
    <p style="font-size:0.78rem; font-weight:600; text-transform:uppercase;
              letter-spacing:0.05em; color:#6B7280; margin-bottom:1rem;">
        <i class="fa-solid fa-filter" style="margin-right:4px;"></i>
        Filter Records
    </p>
    <form method="GET" action="{{ route('attendance.index') }}"
          style="display:flex; gap:1rem; align-items:flex-end; flex-wrap:wrap;">

        <div class="form-group" style="margin:0; flex:2; min-width:200px;">
            <label class="form-label">Search Employee</label>
            <div style="position:relative;">
                <i class="fa-solid fa-magnifying-glass"
                   style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%);
                          color:#9CA3AF; font-size:0.82rem;"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       style="padding-left:2.25rem;"
                       placeholder="Type employee name...">
            </div>
        </div>

        <div class="form-group" style="margin:0; flex:1; min-width:160px;">
            <label class="form-label">Filter by Date</label>
            <input type="date" name="date"
                   value="{{ request('date') }}"
                   class="form-control">
        </div>

        <div style="display:flex; gap:0.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        </div>
    </form>
</div>

{{-- ATTENDANCE TABLE --}}
<div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">

    <div style="padding:1rem 1.5rem; background:#1E293B;
                display:flex; justify-content:space-between; align-items:center;">
        <p style="font-weight:700; font-size:0.9rem; color:white;">
            <i class="fa-solid fa-table-list" style="color:#60A5FA; margin-right:6px;"></i>
            Attendance Log
        </p>
        <span style="font-size:0.78rem; color:#94A3B8;">
            @if(request('search') || request('date'))
                {{ $attendance->count() }} result(s) found
            @else
                {{ $attendance->count() }} total record(s)
            @endif
        </span>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>Hours Worked</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendance as $record)
                <tr>
                    <td style="color:#9CA3AF; font-size:0.82rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <div style="width:32px; height:32px; background:#1E293B;
                                        border-radius:8px; display:flex; align-items:center;
                                        justify-content:center; font-size:0.75rem;
                                        font-weight:700; color:#60A5FA; flex-shrink:0;">
                                {{ strtoupper(substr($record->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight:600; font-size:0.875rem; color:#111827;">
                                    {{ $record->employee->full_name }}
                                </p>
                                <p style="font-size:0.75rem; color:#9CA3AF;">
                                    {{ $record->employee->job_title }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>
                            <p style="font-size:0.875rem; color:#374151; font-weight:500;">
                                {{ \Carbon\Carbon::parse($record->date)->format('M d, Y') }}
                            </p>
                            <p style="font-size:0.75rem; color:#9CA3AF;">
                                {{ \Carbon\Carbon::parse($record->date)->format('l') }}
                            </p>
                        </div>
                    </td>
                    <td>
                        @if($record->time_in)
                            <span style="font-size:0.875rem; color:#374151; font-weight:500;">
                                {{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}
                            </span>
                        @else
                            <span style="color:#D1D5DB;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($record->time_out)
                            <span style="font-size:0.875rem; color:#374151; font-weight:500;">
                                {{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }}
                            </span>
                        @else
                            <span style="color:#D1D5DB;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($record->hours_worked > 8)
                            <strong style="color:#F59E0B;">
                                {{ number_format($record->hours_worked, 2) }}h
                            </strong>
                            <span style="font-size:0.72rem; color:#9CA3AF; display:block;">
                                +{{ number_format($record->hours_worked - 8, 2) }}h OT
                            </span>
                        @elseif($record->hours_worked > 0)
                            <strong style="color:#374151;">
                                {{ number_format($record->hours_worked, 2) }}h
                            </strong>
                        @else
                            <span style="color:#D1D5DB;">—</span>
                        @endif
                    </td>
                    <td>
                        @if($record->time_out)
                            <span class="badge badge-approved">
                                <i class="fa-solid fa-check" style="margin-right:3px;"></i>
                                Complete
                            </span>
                        @else
                            <span class="badge badge-pending">
                                <i class="fa-solid fa-circle-dot" style="margin-right:3px;"></i>
                                In Progress
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; color:#6B7280; padding:3rem;">
                        <i class="fa-solid fa-folder-open" style="font-size:2rem; color:#D1D5DB;
                                  display:block; margin-bottom:0.75rem;"></i>
                        No attendance records found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection