<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;

class PayslipController extends Controller
{
    // ── EMPLOYEE: View own approved payslips ─────────────────
   public function index(Request $request)
{
    $employee = auth()->user()->employee;

    $query = Payroll::where('employee_id', $employee->id)
        ->where('status', 'approved');

    // Month + Year filter
    if ($request->filled('month')) {
        $query->whereMonth('period_start', $request->month);
    }
    if ($request->filled('year')) {
        $query->whereYear('period_start', $request->year);
    }

    // Date range filter
    if ($request->filled('date_from')) {
        $query->where('period_start', '>=', $request->date_from);
    }
    if ($request->filled('date_to')) {
        $query->where('period_end', '<=', $request->date_to);
    }

    $payslips = $query->orderBy('period_start', 'desc')->get();

    // Years for dropdown
    $years = Payroll::where('employee_id', $employee->id)
        ->where('status', 'approved')
        ->selectRaw('YEAR(period_start) as year')
        ->distinct()
        ->orderBy('year', 'desc')
        ->pluck('year')
        ->toArray();

    if (!in_array(\Carbon\Carbon::now()->year, $years)) {
        array_unshift($years, \Carbon\Carbon::now()->year);
    }

    return view('payslip.index', compact('payslips', 'employee', 'years'));
}

    // ── EMPLOYEE: View single payslip detail ─────────────────
    public function show(Payroll $payroll)
    {
        $employee = auth()->user()->employee;

        // Security check — employee can only view their own payslip
        if ($payroll->employee_id !== $employee->id) {
            return redirect()->route('payslip.index')
                ->with('error', 'You are not authorized to view this payslip.');
        }

        // Must be approved to be viewable
        if ($payroll->status !== 'approved') {
            return redirect()->route('payslip.index')
                ->with('error', 'This payslip is not yet approved.');
        }

        return view('payslip.show', compact('payroll', 'employee'));
    }
}