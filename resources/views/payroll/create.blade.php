@extends('layouts.app')
@section('title', 'Generate Payroll')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Generate Payroll</h1>
        <a href="{{ route('payroll.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="card card-body" style="max-width:560px;">

        <p style="color:#6B7280; font-size:0.875rem; margin-bottom:1.5rem;">
            Select an employee and pay period. The system will automatically
            calculate their pay based on logged attendance.
        </p>

        <form action="{{ route('payroll.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Employee</label>
                <select name="employee_id" class="form-control" required>
                    <option value="">-- Select Employee --</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->full_name }} — {{ $employee->job_title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Period Start</label>
                    <input type="date" name="period_start"
                           value="{{ old('period_start') }}"
                           class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Period End</label>
                    <input type="date" name="period_end"
                           value="{{ old('period_end') }}"
                           class="form-control" required>
                </div>
            </div>

            <div class="alert alert-info" style="margin-bottom:1.25rem;">
                💡 <strong>Bi-monthly periods:</strong><br>
                1st period: 1st – 15th of the month<br>
                2nd period: 16th – end of the month
            </div>

            <button type="submit" class="btn btn-primary">Generate Payroll</button>
        </form>
    </div>
@endsection