<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Attendance;
use App\Models\Payroll;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        return $this->employeeDashboard($user);
    }

    // ── ADMIN DASHBOARD ──────────────────────────────────────
    private function adminDashboard()
    {
        $totalEmployees   = Employee::count();
        $activeEmployees  = Employee::where('status', 'active')->count();
        $attendanceToday  = Attendance::where('date', Carbon::today()->toDateString())->count();
        $pendingApprovals = Payroll::where('status', 'pending')->count();
        $totalNetPay      = Payroll::where('status', 'approved')->sum('net_pay');

        // Recent attendance today
        $recentAttendance = Attendance::with('employee')
            ->where('date', Carbon::today()->toDateString())
            ->orderBy('time_in', 'desc')
            ->take(5)
            ->get();

        // Pending payrolls for quick action
        $pendingPayrolls = Payroll::with('employee')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // ── CHART 1: Monthly payroll (current year) ──────────
        $payrollLabels = [];
        $payrollData   = [];
        for ($m = 1; $m <= 12; $m++) {
            $payrollLabels[] = Carbon::create(null, $m)->format('M');
            $payrollData[]   = Payroll::where('status', 'approved')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', $m)
                ->sum('net_pay');
        }

        // ── CHART 2: Employee growth (current year) ──────────
        $growthLabels = [];
        $growthData   = [];
        for ($m = 1; $m <= 12; $m++) {
            $growthLabels[] = Carbon::create(null, $m)->format('M');
            $growthData[]   = Employee::whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', '<=', $m)
                ->count();
        }

        // ── CHART 3: Daily attendance — last 14 days ─────────
        $attendanceLabels    = [];
        $attendanceChartData = [];
        for ($d = 13; $d >= 0; $d--) {
            $date = Carbon::today()->subDays($d);
            $attendanceLabels[]    = $date->format('M d');
            $attendanceChartData[] = Attendance::where('date', $date->toDateString())->count();
        }

        return view('dashboard.admin', compact(
            'totalEmployees',
            'activeEmployees',
            'attendanceToday',
            'pendingApprovals',
            'totalNetPay',
            'recentAttendance',
            'pendingPayrolls',
            'payrollLabels',
            'payrollData',
            'growthLabels',
            'growthData',
            'attendanceLabels',
            'attendanceChartData'
        ));
    }

    // ── EMPLOYEE DASHBOARD ────────────────────────────────────
    private function employeeDashboard($user)
    {
        $employee = $user->employee;

        $totalAttendance = 0;
        $totalHours      = 0;
        $approvedPayslips = 0;
        $latestPay       = null;

        if ($employee) {
            $totalAttendance  = Attendance::where('employee_id', $employee->id)->count();
            $totalHours       = Attendance::where('employee_id', $employee->id)->sum('hours_worked');
            $approvedPayslips = Payroll::where('employee_id', $employee->id)
                ->where('status', 'approved')->count();
            $latestPay        = Payroll::where('employee_id', $employee->id)
                ->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->value('net_pay');
        }

        return view('dashboard.employee', compact(
            'employee',
            'totalAttendance',
            'totalHours',
            'approvedPayslips',
            'latestPay'
        ));
    }
}