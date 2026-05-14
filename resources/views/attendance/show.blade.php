@extends('layouts.app')
@section('title', 'My Attendance')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">My Attendance</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-calendar-days" style="color:#3B82F6; margin-right:4px;"></i>
            {{ \Carbon\Carbon::now()->format('l, F d Y') }}
        </p>
    </div>
</div>

{{-- MAIN TWO-COLUMN LAYOUT --}}
<div style="display:grid; grid-template-columns:220px 1fr; gap:1.5rem; align-items:start;">

    {{-- LEFT COLUMN: Dark Stat Cards --}}
    <div style="display:flex; flex-direction:column; gap:1rem; position:sticky; top:0; align-self:start;">

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        Total Days
                    </p>
                    <p style="font-size:1.8rem; font-weight:700;">{{ $history->count() }}</p>
                </div>
                <div style="background:rgba(59,130,246,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-calendar" style="color:#60A5FA; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        Total Hours
                    </p>
                    <p style="font-size:1.6rem; font-weight:700; color:#10B981;">
                        {{ number_format($history->sum('hours_worked'), 2) }}h
                    </p>
                </div>
                <div style="background:rgba(16,185,129,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-clock" style="color:#10B981; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        Complete
                    </p>
                    <p style="font-size:1.8rem; font-weight:700; color:#60A5FA;">
                        {{ $history->whereNotNull('time_out')->count() }}
                    </p>
                </div>
                <div style="background:rgba(96,165,250,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-circle-check" style="color:#60A5FA; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <div style="display:flex; justify-content:space-between; align-items:flex-start;">
                <div>
                    <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                        Incomplete
                    </p>
                    <p style="font-size:1.8rem; font-weight:700; color:#F59E0B;">
                        {{ $history->whereNull('time_out')->count() }}
                    </p>
                </div>
                <div style="background:rgba(245,158,11,0.2); border-radius:10px; width:36px; height:36px;
                            display:flex; align-items:center; justify-content:center;">
                    <i class="fa-solid fa-circle-exclamation" style="color:#F59E0B; font-size:0.9rem;"></i>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT COLUMN --}}
    <div style="display:flex; flex-direction:column; gap:1rem; min-width:0;">

        {{-- TIME IN / TIME OUT CARDS --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

            {{-- TIME IN CARD --}}
            <div style="background:white; border-radius:12px; padding:1.5rem;
                        box-shadow:0 1px 4px rgba(0,0,0,0.07);
                        border-top:4px solid #1E3A8A;">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                    <div>
                        <p style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em;
                                  color:#94A3B8; margin-bottom:0.4rem; font-weight:600;">
                            Time In
                        </p>
                        <p style="font-size:1.75rem; font-weight:700; color:#1E3A8A; line-height:1;">
                            @if($record && $record->time_in)
                                {{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}
                            @else
                                <span style="color:#D1D5DB;">--:-- --</span>
                            @endif
                        </p>
                    </div>
                    <div style="background:#EFF6FF; border-radius:10px; width:40px; height:40px;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fa-solid fa-clock" style="color:#1E3A8A; font-size:1.1rem;"></i>
                    </div>
                </div>

                @if(!$record)
                    @if($canTimeIn)
                        <form method="POST" action="{{ route('attendance.timeIn') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary"
                                    style="width:100%; justify-content:center;">
                                <i class="fa-solid fa-play"></i> Time In Now
                            </button>
                        </form>
                        <p style="font-size:0.75rem; color:#9CA3AF; margin-top:0.6rem; text-align:center;">
                            Not yet timed in today
                        </p>
                    @else
                        <button disabled class="btn btn-secondary"
                                style="width:100%; justify-content:center; cursor:not-allowed; opacity:0.5;">
                            <i class="fa-solid fa-lock"></i> Locked until 7:30 AM
                        </button>
                        <p style="font-size:0.75rem; color:#EF4444; margin-top:0.6rem; text-align:center;">
                            <i class="fa-solid fa-clock" style="margin-right:3px;"></i>
                            Available at <strong>7:30 AM</strong>
                        </p>
                    @endif
                @else
                    <div style="background:#EFF6FF; border-radius:8px; padding:0.6rem 1rem;
                                font-size:0.82rem; color:#1E40AF; text-align:center;">
                        <i class="fa-solid fa-circle-check" style="margin-right:4px;"></i>
                        Recorded at {{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}
                    </div>
                @endif
            </div>

            {{-- TIME OUT CARD --}}
            <div style="background:white; border-radius:12px; padding:1.5rem;
                        box-shadow:0 1px 4px rgba(0,0,0,0.07);
                        border-top:4px solid {{ ($record && $record->time_out) ? '#10B981' : '#334155' }};">
                <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1rem;">
                    <div>
                        <p style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.08em;
                                  color:#94A3B8; margin-bottom:0.4rem; font-weight:600;">
                            Time Out
                        </p>
                        <p style="font-size:1.75rem; font-weight:700; line-height:1;
                                  color:{{ ($record && $record->time_out) ? '#10B981' : '#D1D5DB' }};">
                            @if($record && $record->time_out)
                                {{ \Carbon\Carbon::parse($record->time_out)->format('h:i A') }}
                            @else
                                --:-- --
                            @endif
                        </p>
                    </div>
                    <div style="background:{{ ($record && $record->time_out) ? '#ECFDF5' : '#F8FAFC' }};
                                border-radius:10px; width:40px; height:40px;
                                display:flex; align-items:center; justify-content:center;">
                        <i class="fa-solid fa-flag-checkered"
                           style="color:{{ ($record && $record->time_out) ? '#10B981' : '#9CA3AF' }};
                                  font-size:1.1rem;"></i>
                    </div>
                </div>

                @if($record && !$record->time_out)
                    @if($canTimeOut)
                        <form method="POST" action="{{ route('attendance.timeOut') }}">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                    style="width:100%; justify-content:center;">
                                <i class="fa-solid fa-stop"></i> Time Out Now
                            </button>
                        </form>
                        <p style="font-size:0.75rem; color:#92400E; margin-top:0.6rem; text-align:center;">
                            <i class="fa-solid fa-triangle-exclamation" style="margin-right:3px;"></i>
                            You're clocked in — don't forget to time out!
                        </p>
                    @else
                        <button disabled class="btn btn-secondary"
                                style="width:100%; justify-content:center; cursor:not-allowed; opacity:0.5;">
                            <i class="fa-solid fa-lock"></i> Not Yet Available
                        </button>
                     <p style="font-size:0.75rem; color:#6B7280; margin-top:0.6rem; text-align:center;">
                        <i class="fa-solid fa-hourglass-half" style="margin-right:3px;"></i>
                        @if($hoursLeft > 0)
                            {{ $hoursLeft }}h {{ $minsLeft }}m until 3:30 PM
                        @else
                            {{ $minsLeft }} min until 3:30 PM
                        @endif
                    </p>
                    @endif
                @elseif($record && $record->time_out)
                    <div style="background:#ECFDF5; border-radius:8px; padding:0.6rem 1rem;
                                font-size:0.82rem; color:#065F46; text-align:center;">
                        <i class="fa-solid fa-circle-check" style="margin-right:4px;"></i>
                        Shift complete — {{ $record->hours_worked }}h worked
                    </div>
                @else
                    <button disabled class="btn btn-secondary"
                            style="width:100%; justify-content:center; cursor:not-allowed; opacity:0.5;">
                        <i class="fa-solid fa-lock"></i> Time Out
                    </button>
                    <p style="font-size:0.75rem; color:#9CA3AF; margin-top:0.6rem; text-align:center;">
                        Time in first before you can time out
                    </p>
                @endif
            </div>

        </div>

        {{-- OVERTIME DECLARATION --}}
        @if($record && !$record->time_out)
            <div style="background:#1E293B; border-radius:12px; padding:1rem 1.25rem;
                        display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <p style="font-weight:600; font-size:0.875rem; color:white; margin-bottom:0.2rem;">
                        <i class="fa-solid fa-bolt" style="color:#F59E0B; margin-right:6px;"></i>
                        Overtime Declaration
                    </p>
                    <p style="font-size:0.78rem; color:#94A3B8;">
                        @if($record->is_overtime)
                            <span style="color:#10B981;">
                                <i class="fa-solid fa-circle-check" style="margin-right:3px;"></i>
                                Overtime declared — extra hours paid at 1.5x rate
                            </span>
                        @else
                            Declare overtime if you're staying beyond your shift
                        @endif
                    </p>
                </div>
                <form method="POST" action="{{ route('attendance.overtime') }}">
                    @csrf
                    @if($record->is_overtime)
                        <button type="submit"
                                style="background:rgba(239,68,68,0.15); color:#FCA5A5;
                                       border:1px solid rgba(239,68,68,0.3);
                                       padding:0.45rem 1rem; border-radius:6px; font-size:0.8rem;
                                       font-weight:600; cursor:pointer; display:flex;
                                       align-items:center; gap:0.4rem;">
                            <i class="fa-solid fa-xmark"></i> Cancel OT
                        </button>
                    @else
                        <button type="submit"
                                style="background:rgba(245,158,11,0.15); color:#FCD34D;
                                       border:1px solid rgba(245,158,11,0.3);
                                       padding:0.45rem 1rem; border-radius:6px; font-size:0.8rem;
                                       font-weight:600; cursor:pointer; display:flex;
                                       align-items:center; gap:0.4rem;">
                            <i class="fa-solid fa-bolt"></i> Declare OT
                        </button>
                    @endif
                </form>
            </div>
        @endif

        {{-- TODAY STATUS BAR --}}
        <div style="background:#1E293B; border-radius:10px; padding:0.9rem 1.25rem;
                    display:flex; align-items:center; gap:0.75rem;">
            <i class="fa-solid fa-calendar-day" style="color:#60A5FA; font-size:1rem;"></i>
            <span style="font-size:0.875rem; color:#94A3B8;">
                <strong style="color:white;">Today:</strong>
                {{ \Carbon\Carbon::today()->format('l, F d Y') }}
            </span>
            <span style="margin-left:auto;">
                @if(!$record)
                    <span class="badge badge-pending">
                        <i class="fa-solid fa-circle-minus" style="margin-right:3px;"></i>
                        Not Yet Timed In
                    </span>
                @elseif($record && !$record->time_out)
                    <span class="badge badge-ongoing">
                        <i class="fa-solid fa-circle-dot" style="margin-right:3px;"></i>
                        Currently Clocked In
                    </span>
                @else
                    <span class="badge badge-approved">
                        <i class="fa-solid fa-circle-check" style="margin-right:3px;"></i>
                        Shift Complete
                    </span>
                @endif
            </span>
        </div>

        {{-- FILTER BAR --}}
        <div style="background:white; border-radius:12px; padding:1.25rem;
                    box-shadow:0 1px 4px rgba(0,0,0,0.07);">
            <p style="font-size:0.78rem; font-weight:600; text-transform:uppercase;
                      letter-spacing:0.05em; color:#6B7280; margin-bottom:1rem;">
                <i class="fa-solid fa-filter" style="margin-right:4px;"></i>
                Filter Attendance History
            </p>
            <form method="GET" action="{{ route('attendance.show') }}">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.75rem; margin-bottom:0.75rem;">
                    <div class="form-group" style="margin:0;">
                        <label class="form-label">Month</label>
                        <select name="month" class="form-control">
                            <option value="">-- All Months --</option>
                            @foreach(range(1,12) as $m)
                                <option value="{{ $m }}"
                                    {{ request('month') == $m ? 'selected' : '' }}>
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
                    <button type="submit" class="btn btn-primary"
                            style="flex:1; justify-content:center;">
                        <i class="fa-solid fa-magnifying-glass"></i> Filter
                    </button>
                    <a href="{{ route('attendance.show') }}" class="btn btn-secondary"
                       style="flex:1; text-align:center;">
                        <i class="fa-solid fa-rotate-left"></i> Reset
                    </a>
                </div>
            </form>
        </div>

        {{-- ATTENDANCE HISTORY TABLE --}}
        <div style="background:white; border-radius:12px;
                    box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">

            <div style="padding:1rem 1.25rem; background:#1E293B;
                        display:flex; justify-content:space-between; align-items:center;">
                <p style="font-weight:700; font-size:0.9rem; color:white;">
                    <i class="fa-solid fa-table-list" style="color:#60A5FA; margin-right:6px;"></i>
                    Attendance History
                    <span style="font-size:0.8rem; color:#94A3B8; font-weight:400; margin-left:0.4rem;">
                        — {{ $history->count() }} record(s)
                    </span>
                </p>
                <div style="display:flex; gap:0.75rem; font-size:0.78rem;">
                    <a href="{{ request()->fullUrlWithQuery(['sort'=>'date','dir'=> request('dir')==='asc'?'desc':'asc']) }}"
                       style="color:#60A5FA; text-decoration:none;">
                        <i class="fa-solid fa-sort"></i>
                        Date {{ request('sort')==='date' ? (request('dir')==='asc'?'↑':'↓') : '' }}
                    </a>
                    <span style="color:#475569;">|</span>
                    <a href="{{ request()->fullUrlWithQuery(['sort'=>'hours','dir'=> request('dir')==='asc'?'desc':'asc']) }}"
                       style="color:#60A5FA; text-decoration:none;">
                        <i class="fa-solid fa-sort"></i>
                        Hours {{ request('sort')==='hours' ? (request('dir')==='asc'?'↑':'↓') : '' }}
                    </a>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Time In</th>
                            <th>Time Out</th>
                            <th>Hours Worked</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($history as $log)
                        <tr>
                            <td style="color:#9CA3AF; font-size:0.82rem;">{{ $loop->iteration }}</td>
                            <td>
                                <p style="font-size:0.875rem; color:#374151; font-weight:500;">
                                    {{ \Carbon\Carbon::parse($log->date)->format('M d, Y') }}
                                </p>
                            </td>
                            <td style="font-size:0.82rem; color:#9CA3AF;">
                                {{ \Carbon\Carbon::parse($log->date)->format('l') }}
                            </td>
                            <td style="font-size:0.875rem; color:#374151; font-weight:500;">
                                {{ $log->time_in
                                    ? \Carbon\Carbon::parse($log->time_in)->format('h:i A')
                                    : '—' }}
                            </td>
                            <td style="font-size:0.875rem; color:#374151; font-weight:500;">
                                {{ $log->time_out
                                    ? \Carbon\Carbon::parse($log->time_out)->format('h:i A')
                                    : '—' }}
                            </td>
                            <td>
                                @if($log->hours_worked > 8)
                                    <strong style="color:#F59E0B;">
                                        {{ number_format($log->hours_worked, 2) }}h
                                    </strong>
                                    <span style="font-size:0.72rem; color:#9CA3AF; display:block;">
                                        +{{ number_format($log->hours_worked - 8, 2) }}h OT
                                    </span>
                                @elseif($log->hours_worked > 0)
                                    <strong style="color:#374151;">
                                        {{ number_format($log->hours_worked, 2) }}h
                                    </strong>
                                @else
                                    <span style="color:#D1D5DB;">—</span>
                                @endif
                            </td>
                            <td>
                                @if($log->time_out)
                                    <span class="badge badge-approved">
                                        <i class="fa-solid fa-check" style="margin-right:3px;"></i>
                                        Complete
                                    </span>
                                @else
                                    <span class="badge badge-pending">
                                        <i class="fa-solid fa-spinner" style="margin-right:3px;"></i>
                                        In Progress
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center; color:#6B7280; padding:2.5rem;">
                                <i class="fa-solid fa-folder-open" style="font-size:1.5rem; display:block;
                                          margin-bottom:0.5rem; color:#D1D5DB;"></i>
                                No attendance records found.
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