@extends('layouts.app')
@section('title', 'Add Employee')

@section('content')
    <div class="page-header">
        <h1 class="page-title">Add New Employee</h1>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0; padding-left:1.2rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card card-body">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Job Title</label>
                    <select name="job_title" class="form-control">
                        <option value="">-- Select --</option>
                        @foreach(['Head Cook','Line Cook','Kitchen Assistant','Head Barista','Barista','Cashier','Service Crew','Cleaner','Dishwasher','Stock Keeper'] as $title)
                            <option value="{{ $title }}" {{ old('job_title') == $title ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-control">
                        <option value="">-- Select --</option>
                        @foreach(['Kitchen','Bar','Front of House','Operations'] as $dept)
                            <option value="{{ $dept }}" {{ old('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Hourly Rate (₱)</label>
                    <input type="number" name="hourly_rate" step="0.01" value="{{ old('hourly_rate') }}" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Hired Date</label>
                <input type="date" name="hired_date" value="{{ old('hired_date') }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Employee</button>
        </form>
    </div>
@endsection