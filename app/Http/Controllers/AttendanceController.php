<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // ── ADMIN: View all attendance records ───────────────────
    public function index(Request $request)
    {
        $query = Attendance::with('employee')->orderBy('date', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('employee', function ($q) use ($search) {
                $q->where('first_name', 'LIKE', '%' . $search . '%')
                  ->orWhere('last_name',  'LIKE', '%' . $search . '%');
            });
        }

        if ($request->filled('date')) {
            $query->where('date', $request->date);
        }

        $attendance = $query->get();

        return view('attendance.index', compact('attendance'));
    }

    // ── EMPLOYEE: Show time in/out page ──────────────────────
    public function show(Request $request)
    {
        $employee = auth()->user()->employee;
        $today    = Carbon::today()->toDateString();

        $record = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        // ── Compute time-based button states (Controller does logic) ──
        $now            = Carbon::now();
        $allowedTimeIn  = Carbon::today()->setTime(7, 30, 0);  // 7:30 AM
        $canTimeIn      = $now->greaterThanOrEqualTo($allowedTimeIn);

       // Time out available at 4:00 PM fixed (not based on hours worked)
        $canTimeOut    = false;
        $allowedTimeOut = Carbon::today()->setTime(15, 30, 0); // 3:30 PM (30 min grace before 4PM)

        if ($record && $record->time_in && !$record->time_out) {
            $canTimeOut = $now->greaterThanOrEqualTo($allowedTimeOut);
        }

        // How long until 3:30 PM
        $minutesLeft = max(0, $now->diffInMinutes($allowedTimeOut, false));
        $hoursLeft   = floor($minutesLeft / 60);
        $minsLeft    = $minutesLeft % 60;
        // Build history query with filters
        $query = Attendance::where('employee_id', $employee->id);

        if ($request->filled('month')) {
            $query->whereMonth('date', $request->month);
        }
        if ($request->filled('year')) {
            $query->whereYear('date', $request->year);
        }
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        $sort = $request->get('sort', 'date');
        $dir  = $request->get('dir', 'desc');

        if ($sort === 'hours') {
            $query->orderBy('hours_worked', $dir);
        } else {
            $query->orderBy('date', $dir);
        }

        $history = $query->get();

        $years = Attendance::where('employee_id', $employee->id)
            ->selectRaw('YEAR(date) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->toArray();

        if (!in_array(Carbon::now()->year, $years)) {
            array_unshift($years, Carbon::now()->year);
        }

        return view('attendance.show', compact(
            'employee', 'record', 'today', 'history', 'years',
            'canTimeIn', 'canTimeOut', 'hoursLeft', 'minsLeft'
        ));
    }

    // ── EMPLOYEE: Time In ────────────────────────────────────
    public function timeIn()
    {
        $employee = auth()->user()->employee;
        $today    = Carbon::today()->toDateString();
        $now      = Carbon::now();

        // ── Block inactive employees ─────────────────────────
        if ($employee->status === 'inactive') {
            return redirect()->route('attendance.show')
                ->with('error', 'Your account is inactive. You cannot log attendance.');
        }

        // ── Enforce 7:30 AM rule ─────────────────────────────
        $allowedTimeIn = Carbon::today()->setTime(7, 30, 0);
        if ($now->lessThan($allowedTimeIn)) {
            return redirect()->route('attendance.show')
                ->with('error', 'Time In is only available from 7:30 AM onwards.');
        }

        // ── Prevent duplicate time in ────────────────────────
        $existing = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if ($existing) {
            return redirect()->route('attendance.show')
                ->with('error', 'You have already timed in today.');
        }

        Attendance::create([
            'employee_id'  => $employee->id,
            'date'         => $today,
            'time_in'      => $now->toTimeString(),
            'hours_worked' => 0,
            'is_overtime'  => false,
        ]);

        return redirect()->route('attendance.show')
            ->with('success', 'Time in recorded at ' . $now->format('h:i A') . '!');
    }

    // ── EMPLOYEE: Time Out ───────────────────────────────────
    public function timeOut()
{
    $employee = auth()->user()->employee;
    $today    = Carbon::today()->toDateString();
    $now      = Carbon::now();

    // Block before 3:30 PM
    if ($now->lt(Carbon::today()->setTime(15, 30))) {
        return redirect()->route('attendance.show')
            ->with('error', 'Time out is only available from 3:30 PM.');
    }

    $record = Attendance::where('employee_id', $employee->id)
        ->where('date', $today)
        ->first();

    if (!$record) {
        return redirect()->route('attendance.show')
            ->with('error', 'You have not timed in yet.');
    }

    if ($record->time_out) {
        return redirect()->route('attendance.show')
            ->with('error', 'You have already timed out today.');
    }

    // ── CORRECT computation ──────────────────────────────────
    $timeIn      = Carbon::parse($record->time_in);
    $hoursWorked = round($timeIn->diffInMinutes($now) / 60, 2);

    $record->update([
        'time_out'     => $now->toTimeString(),
        'hours_worked' => $hoursWorked,
    ]);

    return redirect()->route('attendance.show')
        ->with('success', 'Time out recorded! Hours worked: ' . $hoursWorked . 'h');
}
    // ── EMPLOYEE: Toggle Overtime Flag ───────────────────────
    public function toggleOvertime()
    {
        $employee = auth()->user()->employee;
        $today    = Carbon::today()->toDateString();

        $record = Attendance::where('employee_id', $employee->id)
            ->where('date', $today)
            ->first();

        if (!$record) {
            return redirect()->route('attendance.show')
                ->with('error', 'You must time in first before declaring overtime.');
        }

        if ($record->time_out) {
            return redirect()->route('attendance.show')
                ->with('error', 'Your shift is already complete. Overtime cannot be changed.');
        }

        // ── Toggle overtime flag ──────────────────────────────
        $record->update([
            'is_overtime' => !$record->is_overtime,
        ]);

        $message = $record->is_overtime
            ? 'Overtime declared! Your extra hours will be paid at 1.5x rate.'
            : 'Overtime cancelled.';

        return redirect()->route('attendance.show')
            ->with('success', $message);
    }
}