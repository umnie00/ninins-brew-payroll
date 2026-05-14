@extends('layouts.app')
@section('title', 'My Profile')

@section('content')

@if(!$employee)
    <div class="alert alert-warning">
        Your profile is not set up yet. Please contact your admin.
    </div>
@else

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">My Profile</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-user-circle" style="color:#3B82F6; margin-right:4px;"></i>
            Your personal and employment information
        </p>
    </div>
</div>

{{-- TWO COLUMN LAYOUT --}}
<div style="display:grid; grid-template-columns:260px 1fr; gap:1.5rem; align-items:start;">

    {{-- LEFT: Profile Card + Summary --}}
    <div style="display:flex; flex-direction:column; gap:1rem; position:sticky; top:0; align-self:start;">

        {{-- Avatar Card --}}
        <div style="background:linear-gradient(135deg,#1E3A8A,#1E293B); border-radius:12px; padding:1.5rem; color:white; text-align:center;">
            <div style="width:70px; height:70px; background:linear-gradient(135deg,#3B82F6,#1E3A8A);
                        border-radius:16px; display:flex; align-items:center; justify-content:center;
                        font-size:1.8rem; font-weight:700; color:white; margin:0 auto 1rem;">
                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
            </div>
            <p style="font-weight:700; font-size:1.1rem; margin-bottom:0.25rem;">{{ $employee->full_name }}</p>
            <p style="font-size:0.85rem; color:#94A3B8; margin-bottom:0.75rem;">{{ $employee->job_title }}</p>
            <span class="badge badge-{{ $employee->status }}" style="font-size:0.8rem; padding:0.3rem 0.9rem;">
                {{ ucfirst($employee->status) }}
            </span>
        </div>

        {{-- Summary Card --}}
        <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
            <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                      color:#94A3B8; margin-bottom:1rem; font-weight:600;">
                <i class="fa-solid fa-chart-simple" style="margin-right:4px;"></i>
                My Summary
            </p>
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.82rem; color:#94A3B8;">Attendance Days</span>
                    <strong style="color:#60A5FA;">{{ $totalAttendance }}</strong>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.82rem; color:#94A3B8;">Total Hours</span>
                    <strong style="color:#10B981;">{{ $totalHours }}h</strong>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.82rem; color:#94A3B8;">Approved Payslips</span>
                    <strong style="color:#F59E0B;">{{ $approvedPayslips }}</strong>
                </div>
                <div style="border-top:1px solid rgba(255,255,255,0.1); padding-top:0.75rem;
                            display:flex; justify-content:space-between; align-items:center;">
                    <span style="font-size:0.82rem; color:#94A3B8;">Latest Net Pay</span>
                    @if($latestPay)
                        <strong style="color:#10B981;">₱{{ number_format($latestPay, 2) }}</strong>
                    @else
                        <span style="font-size:0.82rem; color:#64748B;">No payslip yet</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT: Info Cards --}}
    <div style="display:flex; flex-direction:column; gap:1rem;">

        {{-- PERSONAL INFORMATION --}}
        <div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">
            <div style="background:#1E293B; padding:1rem 1.5rem;">
                <p style="font-weight:700; font-size:0.9rem; color:white;">
                    <i class="fa-solid fa-user" style="color:#60A5FA; margin-right:6px;"></i>
                    Personal Information
                </p>
            </div>
            <div style="padding:1.25rem 1.5rem;">
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem;">
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Full Name</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:600;">{{ $employee->full_name }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Email</p>
                        <p style="font-size:0.9rem; color:#6B7280;">{{ $employee->email }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Phone</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">{{ $employee->phone ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Address</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">{{ $employee->address ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Date of Birth</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">
                            {{ $employee->date_of_birth ? \Carbon\Carbon::parse($employee->date_of_birth)->format('F d, Y') : '—' }}
                        </p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Gender</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">{{ $employee->gender ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- EMPLOYMENT DETAILS + EMERGENCY CONTACT side by side --}}
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

            {{-- EMPLOYMENT --}}
            <div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">
                <div style="background:#1E293B; padding:1rem 1.5rem;">
                    <p style="font-weight:700; font-size:0.9rem; color:white;">
                        <i class="fa-solid fa-briefcase" style="color:#60A5FA; margin-right:6px;"></i>
                        Employment Details
                    </p>
                </div>
                <div style="padding:1.25rem 1.5rem; display:flex; flex-direction:column; gap:1rem;">
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Job Title</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:600;">{{ $employee->job_title }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Department</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">{{ $employee->department }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Hourly Rate</p>
                        @if($employee->hourly_rate > 0)
                            <p style="font-size:0.9rem; font-weight:700; color:#10B981;">₱{{ number_format($employee->hourly_rate, 2) }}/hr</p>
                        @else
                            <p style="font-size:0.85rem; color:#F59E0B; font-weight:500;">
                                <i class="fa-solid fa-clock" style="margin-right:3px;"></i>Pending — Admin will set this
                            </p>
                        @endif
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Status</p>
                        <span class="badge badge-{{ $employee->status }}">{{ ucfirst($employee->status) }}</span>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Hired Date</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">
                            {{ \Carbon\Carbon::parse($employee->hired_date)->format('F d, Y') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- EMERGENCY CONTACT --}}
            <div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">
                <div style="background:#1E293B; padding:1rem 1.5rem;">
                    <p style="font-weight:700; font-size:0.9rem; color:white;">
                        <i class="fa-solid fa-phone-volume" style="color:#EF4444; margin-right:6px;"></i>
                        Emergency Contact
                    </p>
                </div>
                <div style="padding:1.25rem 1.5rem; display:flex; flex-direction:column; gap:1rem;">
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Name</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:600;">{{ $employee->emergency_name ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Relationship</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">{{ $employee->emergency_relationship ?? '—' }}</p>
                    </div>
                    <div>
                        <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#9CA3AF; margin-bottom:0.3rem;">Contact Number</p>
                        <p style="font-size:0.9rem; color:#111827; font-weight:500;">{{ $employee->emergency_phone ?? '—' }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endif
@endsection