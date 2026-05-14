@extends('layouts.app')
@section('title', 'Admin Dashboard')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.25rem;">
            Welcome back, <strong style="color:#111827;">{{ auth()->user()->name }}</strong>
        </p>
    </div>
    <div style="background:#1E293B; color:white; padding:0.6rem 1rem; border-radius:10px; text-align:right; font-size:0.82rem;">
        <div style="color:#94A3B8; margin-bottom:0.2rem;">
            <i class="fa-solid fa-calendar-days" style="color:#60A5FA; margin-right:5px;"></i>
            {{ \Carbon\Carbon::now()->format('l, F d Y') }}
        </div>
        <div style="font-size:0.9rem; font-weight:600; color:white;">
            <i class="fa-solid fa-clock" style="color:#10B981; margin-right:5px;"></i>
            <span id="live-time"></span>
        </div>
    </div>
</div>

{{-- STAT CARDS --}}
<div style="display:grid; grid-template-columns:repeat(5,1fr); gap:1rem; margin-bottom:1.5rem;">

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">Total Employees</p>
                <p style="font-size:1.8rem; font-weight:700;">{{ $totalEmployees }}</p>
            </div>
            <div style="background:rgba(59,130,246,0.2); border-radius:10px; width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-users" style="color:#60A5FA; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">Active</p>
                <p style="font-size:1.8rem; font-weight:700; color:#10B981;">{{ $activeEmployees }}</p>
            </div>
            <div style="background:rgba(16,185,129,0.2); border-radius:10px; width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-user-check" style="color:#10B981; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">Attendance Today</p>
                <p style="font-size:1.8rem; font-weight:700; color:#F59E0B;">{{ $attendanceToday }}</p>
            </div>
            <div style="background:rgba(245,158,11,0.2); border-radius:10px; width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-calendar-check" style="color:#F59E0B; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">Pending Approvals</p>
                <p style="font-size:1.8rem; font-weight:700; color:#EF4444;">{{ $pendingApprovals }}</p>
            </div>
            <div style="background:rgba(239,68,68,0.2); border-radius:10px; width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-hourglass-half" style="color:#EF4444; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">Net Pay Released</p>
                <p style="font-size:1.1rem; font-weight:700; color:#60A5FA; margin-top:0.4rem;">₱{{ number_format($totalNetPay, 0) }}</p>
            </div>
            <div style="background:rgba(96,165,250,0.2); border-radius:10px; width:38px; height:38px; display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-peso-sign" style="color:#60A5FA; font-size:1rem;"></i>
            </div>
        </div>
    </div>

</div>

{{-- CHARTS ROW --}}
<div style="display:grid; grid-template-columns:2fr 1fr; gap:1.5rem; margin-bottom:1.5rem;">

    <div style="background:white; border-radius:12px; padding:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,0.07);">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
            <div>
                <p style="font-weight:700; font-size:0.95rem; color:#111827;">
                    <i class="fa-solid fa-money-bill-wave" style="color:#3B82F6; margin-right:6px;"></i>
                    Monthly Net Pay Released
                </p>
                <p style="font-size:0.78rem; color:#6B7280; margin-top:0.2rem;">{{ \Carbon\Carbon::now()->year }} Overview</p>
            </div>
            <span style="font-size:0.75rem; background:#1E293B; color:#94A3B8; padding:0.25rem 0.7rem; border-radius:999px; font-weight:500;">
                {{ \Carbon\Carbon::now()->year }}
            </span>
        </div>
        <canvas id="payrollChart" height="100"></canvas>
    </div>

    <div style="background:white; border-radius:12px; padding:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,0.07);">
        <div style="margin-bottom:1.25rem;">
            <p style="font-weight:700; font-size:0.95rem; color:#111827;">
                <i class="fa-solid fa-chart-line" style="color:#10B981; margin-right:6px;"></i>
                Employee Growth
            </p>
            <p style="font-size:0.78rem; color:#6B7280; margin-top:0.2rem;">{{ \Carbon\Carbon::now()->year }} headcount</p>
        </div>
        <canvas id="growthChart" height="180"></canvas>
    </div>

</div>

{{-- ATTENDANCE CHART --}}
<div style="background:white; border-radius:12px; padding:1.5rem; box-shadow:0 1px 4px rgba(0,0,0,0.07); margin-bottom:1.5rem;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1.25rem;">
        <div>
            <p style="font-weight:700; font-size:0.95rem; color:#111827;">
                <i class="fa-solid fa-calendar-days" style="color:#F59E0B; margin-right:6px;"></i>
                Daily Attendance
            </p>
            <p style="font-size:0.78rem; color:#6B7280; margin-top:0.2rem;">Last 14 days</p>
        </div>
    </div>
    <canvas id="attendanceChart" height="55"></canvas>
</div>

{{-- RECENT ACTIVITY --}}
<div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

    {{-- TODAY'S ATTENDANCE --}}
    <div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">
        <div style="padding:1rem 1.25rem; background:#1E293B; display:flex; justify-content:space-between; align-items:center;">
            <p style="font-weight:700; font-size:0.9rem; color:white;">
                <i class="fa-solid fa-clock" style="color:#60A5FA; margin-right:6px;"></i>
                Today's Attendance
            </p>
            <a href="{{ route('attendance.index') }}"
               style="font-size:0.78rem; color:#94A3B8; text-decoration:none; font-weight:500;">
                View all <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
            </a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Time In</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentAttendance as $record)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.5rem;">
                            <div style="width:28px; height:28px; background:#1E293B; border-radius:8px;
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:0.7rem; color:#60A5FA; font-weight:700; flex-shrink:0;">
                                {{ strtoupper(substr($record->employee->first_name, 0, 1)) }}
                            </div>
                            <span style="font-size:0.85rem; font-weight:500;">{{ $record->employee->full_name }}</span>
                        </div>
                    </td>
                    <td style="font-size:0.85rem; color:#374151;">
                        {{ \Carbon\Carbon::parse($record->time_in)->format('h:i A') }}
                    </td>
                    <td>
                        @if($record->time_out)
                            <span class="badge badge-approved">
                                <i class="fa-solid fa-check" style="margin-right:3px;"></i>Done
                            </span>
                        @else
                            <span class="badge badge-ongoing">
                                <i class="fa-solid fa-circle-dot" style="margin-right:3px;"></i>In
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center; color:#6B7280; padding:2rem;">
                        <i class="fa-solid fa-calendar-xmark" style="font-size:1.5rem; color:#D1D5DB; display:block; margin-bottom:0.5rem;"></i>
                        No attendance recorded today.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PENDING APPROVALS --}}
    <div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">
        <div style="padding:1rem 1.25rem; background:#1E293B; display:flex; justify-content:space-between; align-items:center;">
            <p style="font-weight:700; font-size:0.9rem; color:white;">
                <i class="fa-solid fa-circle-check" style="color:#10B981; margin-right:6px;"></i>
                Pending Approvals
                @if($pendingApprovals > 0)
                    <span style="background:rgba(239,68,68,0.2); color:#FCA5A5; font-size:0.72rem;
                                 padding:0.15rem 0.5rem; border-radius:999px; margin-left:0.4rem;">
                        {{ $pendingApprovals }}
                    </span>
                @endif
            </p>
            <a href="{{ route('approval.index') }}"
               style="font-size:0.78rem; color:#94A3B8; text-decoration:none; font-weight:500;">
                View all <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
            </a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Net Pay</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingPayrolls as $payroll)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.5rem;">
                            <div style="width:28px; height:28px; background:#1E293B; border-radius:8px;
                                        display:flex; align-items:center; justify-content:center;
                                        font-size:0.7rem; color:#60A5FA; font-weight:700; flex-shrink:0;">
                                {{ strtoupper(substr($payroll->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-size:0.85rem; font-weight:500;">{{ $payroll->employee->full_name }}</p>
                                <p style="font-size:0.72rem; color:#9CA3AF;">{{ $payroll->employee->job_title }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <strong style="color:#10B981; font-size:0.85rem;">
                            ₱{{ number_format($payroll->net_pay, 2) }}
                        </strong>
                    </td>
                    <td>
                        <a href="{{ route('approval.index') }}"
                           style="background:#EFF6FF; color:#1E3A8A; padding:0.3rem 0.7rem;
                                  border-radius:6px; font-size:0.75rem; font-weight:600;
                                  text-decoration:none; display:inline-flex; align-items:center; gap:0.3rem;">
                            <i class="fa-solid fa-eye"></i> Review
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center; color:#6B7280; padding:2rem;">
                        <i class="fa-solid fa-circle-check" style="font-size:1.5rem; color:#D1D5DB; display:block; margin-bottom:0.5rem;"></i>
                        All payrolls reviewed!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function updateClock() {
        const now = new Date();
        document.getElementById('live-time').textContent =
            now.toLocaleTimeString('en-PH', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    }
    setInterval(updateClock, 1000);
    updateClock();

    new Chart(document.getElementById('payrollChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($payrollLabels) !!},
            datasets: [{
                label: 'Net Pay Released (₱)',
                data: {!! json_encode($payrollData) !!},
                backgroundColor: 'rgba(59,130,246,0.15)',
                borderColor: '#3B82F6',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => ' ₱' + ctx.parsed.y.toLocaleString() } } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: val => '₱' + val.toLocaleString(), font: { size: 11 } } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });

    new Chart(document.getElementById('growthChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($growthLabels) !!},
            datasets: [{ label: 'Employees', data: {!! json_encode($growthData) !!}, borderColor: '#10B981', backgroundColor: 'rgba(16,185,129,0.08)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#10B981' }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });

    new Chart(document.getElementById('attendanceChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($attendanceLabels) !!},
            datasets: [{ label: 'Attendance', data: {!! json_encode($attendanceChartData) !!}, borderColor: '#F59E0B', backgroundColor: 'rgba(245,158,11,0.08)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#F59E0B' }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 11 } }, grid: { color: 'rgba(0,0,0,0.04)' } },
                x: { grid: { display: false }, ticks: { font: { size: 11 } } }
            }
        }
    });
</script>

@endsection