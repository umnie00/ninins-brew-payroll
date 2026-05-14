<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    // ── READ — Show all employees ────────────────────────────
   public function index(Request $request)
{
    $query = Employee::query();

    // Search by name, email, or job title
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('first_name',  'like', "%{$search}%")
              ->orWhere('last_name',  'like', "%{$search}%")
              ->orWhere('email',      'like', "%{$search}%")
              ->orWhere('job_title',  'like', "%{$search}%");
        });
    }

    // Department filter
    if ($request->filled('department')) {
        $query->where('department', $request->department);
    }

    // Status filter
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $employees = $query->orderBy('first_name')->get();

    return view('employees.index', compact('employees'));
}

    // ── EDIT — Show the edit form ────────────────────────────
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    // ── UPDATE — Save job details filled in by admin ─────────
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name'  => 'required|string|max:100',
            'last_name'   => 'required|string|max:100',
            'email'       => 'required|email|unique:employees,email,' . $employee->id,
            'phone'       => 'nullable|string|max:20',
            'job_title'   => 'required|string|max:100',
            'department'  => 'required|string|max:100',
            'hourly_rate' => 'required|numeric|min:0',
            'status'      => 'required|in:active,inactive',
            'hired_date'  => 'required|date',
        ]);

        $employee->update($request->all());

        return redirect()->route('employees.index')
            ->with('success', 'Employee details updated successfully.');
    }

    // ── DESTROY — Delete employee ────────────────────────────
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee removed successfully.');
    }
}