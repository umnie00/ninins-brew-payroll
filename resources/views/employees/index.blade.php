@extends('layouts.app')
@section('title', 'Employees')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">Employees</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-users" style="color:#3B82F6; margin-right:4px;"></i>
            Manage all staff members
        </p>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem; margin-bottom:1.5rem;">

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Total Staff
                </p>
                <p style="font-size:1.8rem; font-weight:700;">{{ $employees->count() }}</p>
            </div>
            <div style="background:rgba(59,130,246,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-users" style="color:#60A5FA; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Active
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#10B981;">
                    {{ $employees->where('status','active')->count() }}
                </p>
            </div>
            <div style="background:rgba(16,185,129,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-user-check" style="color:#10B981; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Inactive
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#EF4444;">
                    {{ $employees->where('status','inactive')->count() }}
                </p>
            </div>
            <div style="background:rgba(239,68,68,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-user-xmark" style="color:#EF4444; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Departments
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#60A5FA;">
                    {{ $employees->pluck('department')->unique()->count() }}
                </p>
            </div>
            <div style="background:rgba(96,165,250,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-building" style="color:#60A5FA; font-size:1rem;"></i>
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
        Filter Employees
    </p>
    <form method="GET" action="{{ route('employees.index') }}"
          style="display:flex; gap:1rem; align-items:flex-end; flex-wrap:wrap;">

        <div class="form-group" style="margin:0; flex:2; min-width:200px;">
            <label class="form-label">Search</label>
            <div style="position:relative;">
                <i class="fa-solid fa-magnifying-glass"
                   style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%);
                          color:#9CA3AF; font-size:0.82rem;"></i>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       style="padding-left:2.25rem;"
                       placeholder="Name, email, or job title...">
            </div>
        </div>

        <div class="form-group" style="margin:0; flex:1; min-width:150px;">
            <label class="form-label">Department</label>
            <select name="department" class="form-control">
                <option value="">-- All Departments --</option>
                @foreach(['Kitchen', 'Bar', 'Front of House', 'Operations'] as $dept)
                    <option value="{{ $dept }}"
                        {{ request('department') == $dept ? 'selected' : '' }}>
                        {{ $dept }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="margin:0; flex:1; min-width:130px;">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">-- All Status --</option>
                <option value="active"   {{ request('status') == 'active'   ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div style="display:flex; gap:0.5rem;">
            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        </div>
    </form>
</div>

{{-- RESULTS COUNT --}}
@if(request('search') || request('department') || request('status'))
    <p style="font-size:0.875rem; color:#6B7280; margin-bottom:1rem;">
        Showing <strong>{{ $employees->count() }}</strong> result(s)
        @if(request('search'))
            for "<strong>{{ request('search') }}</strong>"
        @endif
    </p>
@endif

{{-- EMPLOYEES TABLE --}}
<div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">

    <div style="padding:1rem 1.5rem; background:#1E293B;
                display:flex; justify-content:space-between; align-items:center;">
        <p style="font-weight:700; font-size:0.9rem; color:white;">
            <i class="fa-solid fa-table-list" style="color:#60A5FA; margin-right:6px;"></i>
            Employee Directory
        </p>
        <span style="font-size:0.78rem; color:#94A3B8;">
            {{ $employees->count() }} employee(s)
        </span>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Employee</th>
                    <th>Email</th>
                    <th>Job Title</th>
                    <th>Department</th>
                    <th>Hourly Rate</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td style="color:#9CA3AF; font-size:0.82rem;">{{ $loop->iteration }}</td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <div style="width:36px; height:36px; background:#1E293B;
                                        border-radius:10px; display:flex; align-items:center;
                                        justify-content:center; font-size:0.85rem;
                                        font-weight:700; color:#60A5FA; flex-shrink:0;">
                                {{ strtoupper(substr($employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight:600; font-size:0.875rem; color:#111827;">
                                    {{ $employee->full_name }}
                                </p>
                                <p style="font-size:0.75rem; color:#9CA3AF;">
                                    Hired {{ \Carbon\Carbon::parse($employee->hired_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td style="font-size:0.875rem; color:#6B7280;">
                        {{ $employee->email }}
                    </td>
                    <td>
                        <span style="font-size:0.82rem; background:#F8FAFC; padding:0.25rem 0.6rem;
                                     border-radius:6px; color:#374151; font-weight:500;">
                            {{ $employee->job_title }}
                        </span>
                    </td>
                    <td style="font-size:0.875rem; color:#374151;">
                        {{ $employee->department }}
                    </td>
                    <td>
                        @if($employee->hourly_rate > 0)
                            <span style="font-weight:600; color:#10B981; font-size:0.875rem;">
                                ₱{{ number_format($employee->hourly_rate, 2) }}
                            </span>
                            <span style="font-size:0.72rem; color:#9CA3AF;">/hr</span>
                        @else
                            <span style="font-size:0.82rem; color:#F59E0B; font-weight:500;">
                                <i class="fa-solid fa-clock" style="margin-right:3px;"></i>
                                Pending
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $employee->status }}">
                            @if($employee->status === 'active')
                                <i class="fa-solid fa-circle" style="font-size:0.5rem; margin-right:4px;"></i>
                            @else
                                <i class="fa-solid fa-circle-minus" style="font-size:0.5rem; margin-right:4px;"></i>
                            @endif
                            {{ ucfirst($employee->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('employees.edit', $employee->id) }}"
                               style="background:#EFF6FF; color:#1E3A8A; padding:0.3rem 0.7rem;
                                      border-radius:6px; font-size:0.78rem; font-weight:600;
                                      text-decoration:none; display:inline-flex;
                                      align-items:center; gap:0.3rem;">
                                <i class="fa-solid fa-pen"></i> Edit
                            </a>
                            <form action="{{ route('employees.destroy', $employee->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Delete {{ $employee->full_name }}?')">
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
                    <td colspan="8" style="text-align:center; color:#6B7280; padding:3rem;">
                        <i class="fa-solid fa-users" style="font-size:2rem; color:#D1D5DB;
                                  display:block; margin-bottom:0.75rem;"></i>
                        @if(request('search') || request('department') || request('status'))
                            No employees found matching your search.
                        @else
                            No employees yet.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection