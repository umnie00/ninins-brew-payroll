@extends('layouts.app')
@section('title', 'Edit Employee')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">Edit Employee</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-pen" style="color:#3B82F6; margin-right:4px;"></i>
            Updating profile for <strong>{{ $employee->full_name }}</strong>
        </p>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
</div>

@if($errors->any())
    <div class="alert alert-error" style="margin-bottom:1.5rem;">
        <i class="fa-solid fa-circle-exclamation"></i>
        <ul style="margin:0; padding-left:1.2rem;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- TWO COLUMN LAYOUT --}}
<div style="display:grid; grid-template-columns:280px 1fr; gap:1.5rem; align-items:start;">

    {{-- LEFT: Employee Identity Card --}}
    <div style="display:flex; flex-direction:column; gap:1rem; position:sticky; top:0; align-self:start;">

        {{-- Avatar Card --}}
        <div style="background:#1E293B; border-radius:12px; padding:1.5rem; color:white; text-align:center;">
            <div style="width:70px; height:70px; background:linear-gradient(135deg,#3B82F6,#1E3A8A);
                        border-radius:16px; display:flex; align-items:center; justify-content:center;
                        font-size:1.8rem; font-weight:700; color:white; margin:0 auto 1rem;">
                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
            </div>
            <p style="font-weight:700; font-size:1rem; margin-bottom:0.25rem;">
                {{ $employee->full_name }}
            </p>
            <p style="font-size:0.82rem; color:#94A3B8; margin-bottom:1rem;">
                {{ $employee->job_title }}
            </p>
            <span class="badge badge-{{ $employee->status }}" style="font-size:0.8rem; padding:0.3rem 0.9rem;">
                {{ ucfirst($employee->status) }}
            </span>
        </div>

        {{-- Quick Info --}}
        <div style="background:white; border-radius:12px; padding:1.25rem;
                    box-shadow:0 1px 4px rgba(0,0,0,0.07);">
            <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                      color:#6B7280; margin-bottom:1rem; font-weight:600;">
                <i class="fa-solid fa-circle-info" style="margin-right:4px;"></i>
                Current Info
            </p>
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                <div>
                    <p style="font-size:0.72rem; color:#9CA3AF; margin-bottom:0.15rem;">Email</p>
                    <p style="font-size:0.82rem; color:#374151; font-weight:500;">{{ $employee->email }}</p>
                </div>
                <div>
                    <p style="font-size:0.72rem; color:#9CA3AF; margin-bottom:0.15rem;">Department</p>
                    <p style="font-size:0.82rem; color:#374151; font-weight:500;">{{ $employee->department }}</p>
                </div>
                <div>
                    <p style="font-size:0.72rem; color:#9CA3AF; margin-bottom:0.15rem;">Hourly Rate</p>
                    <p style="font-size:0.82rem; font-weight:600;
                              color:{{ $employee->hourly_rate > 0 ? '#10B981' : '#F59E0B' }};">
                        @if($employee->hourly_rate > 0)
                            ₱{{ number_format($employee->hourly_rate, 2) }}/hr
                        @else
                            Not set yet
                        @endif
                    </p>
                </div>
                <div>
                    <p style="font-size:0.72rem; color:#9CA3AF; margin-bottom:0.15rem;">Hired Date</p>
                    <p style="font-size:0.82rem; color:#374151; font-weight:500;">
                        {{ \Carbon\Carbon::parse($employee->hired_date)->format('M d, Y') }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- RIGHT: Edit Form --}}
    <div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">

        {{-- Form Header --}}
        <div style="background:#1E293B; padding:1.25rem 1.5rem;">
            <p style="font-weight:700; font-size:0.9rem; color:white;">
                <i class="fa-solid fa-pen-to-square" style="color:#60A5FA; margin-right:6px;"></i>
                Edit Details
            </p>
            <p style="font-size:0.78rem; color:#94A3B8; margin-top:0.2rem;">
                Changes will be saved immediately after clicking Update
            </p>
        </div>

        <div style="padding:1.5rem;">
            <form action="{{ route('employees.update', $employee->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- PERSONAL INFO --}}
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                          color:#94A3B8; margin-bottom:1rem; font-weight:600; padding-bottom:0.5rem;
                          border-bottom:1px solid #F1F5F9;">
                    <i class="fa-solid fa-user" style="margin-right:4px;"></i>
                    Personal Information
                </p>

                <div class="form-grid-2" style="margin-bottom:0;">
                    <div class="form-group">
                        <label class="form-label">First Name</label>
                        <input type="text" name="first_name"
                               value="{{ old('first_name', $employee->first_name) }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name"
                               value="{{ old('last_name', $employee->last_name) }}"
                               class="form-control" required>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $employee->email) }}"
                               class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $employee->phone) }}"
                               class="form-control">
                    </div>
                </div>

                {{-- JOB INFO --}}
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                          color:#94A3B8; margin-bottom:1rem; font-weight:600; padding-bottom:0.5rem;
                          border-bottom:1px solid #F1F5F9; margin-top:0.5rem;">
                    <i class="fa-solid fa-briefcase" style="margin-right:4px;"></i>
                    Job Information
                </p>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Job Title</label>
                        <select name="job_title" class="form-control">
                            @foreach(['Head Cook','Line Cook','Kitchen Assistant',
                                      'Head Barista','Barista','Cashier',
                                      'Service Crew','Cleaner','Dishwasher','Stock Keeper'] as $title)
                                <option value="{{ $title }}"
                                    {{ old('job_title', $employee->job_title) == $title ? 'selected' : '' }}>
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-control">
                            @foreach(['Kitchen','Bar','Front of House','Operations'] as $dept)
                                <option value="{{ $dept }}"
                                    {{ old('department', $employee->department) == $dept ? 'selected' : '' }}>
                                    {{ $dept }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- PAYROLL INFO --}}
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em;
                          color:#94A3B8; margin-bottom:1rem; font-weight:600; padding-bottom:0.5rem;
                          border-bottom:1px solid #F1F5F9; margin-top:0.5rem;">
                    <i class="fa-solid fa-peso-sign" style="margin-right:4px;"></i>
                    Payroll & Status
                </p>

                <div class="form-grid-2">
                    <div class="form-group">
                        <label class="form-label">Hourly Rate (₱)</label>
                        <div style="position:relative;">
                            <span style="position:absolute; left:0.75rem; top:50%;
                                         transform:translateY(-50%); color:#9CA3AF; font-size:0.85rem;">
                                ₱
                            </span>
                            <input type="number" name="hourly_rate" step="0.01"
                                   value="{{ old('hourly_rate', $employee->hourly_rate) }}"
                                   class="form-control" style="padding-left:1.75rem;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control">
                            <option value="active"
                                {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="inactive"
                                {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>
                                Inactive
                            </option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Hired Date</label>
                    <input type="date" name="hired_date"
                           value="{{ old('hired_date', $employee->hired_date) }}"
                           class="form-control">
                </div>

                {{-- SUBMIT --}}
                <div style="display:flex; gap:0.75rem; margin-top:0.5rem;">
                    <button type="submit" class="btn btn-primary" style="flex:1; justify-content:center;">
                        <i class="fa-solid fa-floppy-disk"></i> Update Employee
                    </button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary"
                       style="justify-content:center;">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@endsection