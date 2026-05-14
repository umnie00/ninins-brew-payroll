<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Employee;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollController extends Controller
{
    // ── LIST all payroll records ─────────────────────────────
    public function index()
    {
        $payrolls = Payroll::with('employee')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payroll.index', compact('payrolls'));
    }

    // ── SHOW generate form ───────────────────────────────────
    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('first_name')->get();
        return view('payroll.create', compact('employees'));
    }

    // ── COMPUTE & SAVE payroll (ALL logic here — MVC rule) ───
    public function store(Request $request)
    {
        $request->validate([
            'employee_id'  => 'required|exists:employees,id',
            'period_start' => 'required|date',
            'period_end'   => 'required|date|after_or_equal:period_start',
        ]);

        $employee = Employee::findOrFail($request->employee_id);

        // ── Check: inactive employees cannot receive payroll ─
        if ($employee->status === 'inactive') {
            return back()->with('error', 'Cannot generate payroll for an inactive employee.');
        }

        // ── Check: no duplicate payroll for same period ──────
        $existing = Payroll::where('employee_id', $employee->id)
            ->where('period_start', $request->period_start)
            ->where('period_end',   $request->period_end)
            ->first();

        if ($existing) {
            return back()->with('error', 'Payroll for this employee and period already exists.');
        }

        // ── Get all attendance records within the period ─────
        $attendances = Attendance::where('employee_id', $employee->id)
            ->whereBetween('date', [$request->period_start, $request->period_end])
            ->get();

        // ── COMPUTATION (Controller does all math — MVC rule) ─
        $totalHours    = $attendances->sum('hours_worked');
        $regularDays   = $attendances->count();

        // Overtime = hours beyond 8 per day, at 1.5x rate
        $overtimeHours = 0;
        foreach ($attendances as $record) {
            if ($record->hours_worked > 8) {
                $overtimeHours += $record->hours_worked - 8;
            }
        }

        $regularHours  = $totalHours - $overtimeHours;
        $hourlyRate    = $employee->hourly_rate;

        $grossPay      = $regularHours  * $hourlyRate;
        $overtimePay   = $overtimeHours * $hourlyRate * 1.5;
        $taxAmount     = ($grossPay + $overtimePay) * 0.10;   // 10% tax
        $netPay        = ($grossPay + $overtimePay) - $taxAmount;

        // ── Save to database ─────────────────────────────────
        Payroll::create([
            'employee_id'    => $employee->id,
            'period_start'   => $request->period_start,
            'period_end'     => $request->period_end,
            'total_hours'    => round($totalHours,    2),
            'overtime_hours' => round($overtimeHours, 2),
            'hourly_rate'    => $hourlyRate,
            'gross_pay'      => round($grossPay,      2),
            'overtime_pay'   => round($overtimePay,   2),
            'tax_amount'     => round($taxAmount,     2),
            'net_pay'        => round($netPay,        2),
            'status'         => 'pending',
        ]);

        return redirect()->route('payroll.index')
            ->with('success', 'Payroll generated successfully for ' . $employee->full_name . '.');
    }

    // ── VIEW single payroll detail ───────────────────────────
    public function show(Payroll $payroll)
    {
        return view('payroll.show', compact('payroll'));
    }

    // ── DELETE payroll record ────────────────────────────────
    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('payroll.index')
            ->with('success', 'Payroll record deleted.');
    }
}