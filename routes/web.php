<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\PayslipController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // ── Admin-only routes ────────────────────────────────────
    Route::middleware(['admin'])->group(function () {

        // Employees
        Route::get('/employees',                 [EmployeeController::class, 'index']  )->name('employees.index');
        Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit']   )->name('employees.edit');
        Route::put('/employees/{employee}',      [EmployeeController::class, 'update'] )->name('employees.update');
        Route::delete('/employees/{employee}',   [EmployeeController::class, 'destroy'])->name('employees.destroy');

        // Attendance
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');

        // Payroll
        Route::get('/payroll',              [PayrollController::class, 'index']  )->name('payroll.index');
        Route::get('/payroll/create',       [PayrollController::class, 'create'] )->name('payroll.create');
        Route::post('/payroll',             [PayrollController::class, 'store']  )->name('payroll.store');
        Route::get('/payroll/{payroll}',    [PayrollController::class, 'show']   )->name('payroll.show');
        Route::delete('/payroll/{payroll}', [PayrollController::class, 'destroy'])->name('payroll.destroy');

        // Approval
        Route::get('/approval',                    [ApprovalController::class, 'index']  )->name('approval.index');
        Route::post('/approval/{payroll}/approve', [ApprovalController::class, 'approve'])->name('approval.approve');
        Route::post('/approval/{payroll}/reject',  [ApprovalController::class, 'reject'] )->name('approval.reject');
    });

   // ── Employee-only routes ─────────────────────────────────
    Route::middleware(['employee'])->group(function () {
    Route::get('/attendance/log',            [AttendanceController::class, 'show']          )->name('attendance.show');
    Route::post('/attendance/time-in',       [AttendanceController::class, 'timeIn']        )->name('attendance.timeIn');
    Route::post('/attendance/time-out',      [AttendanceController::class, 'timeOut']       )->name('attendance.timeOut');
    Route::post('/attendance/overtime',      [AttendanceController::class, 'toggleOvertime'])->name('attendance.overtime'); // ← ADD THIS

    // Payslip
    Route::get('/payslip',           [PayslipController::class, 'index'])->name('payslip.index');
    Route::get('/payslip/{payroll}', [PayslipController::class, 'show'] )->name('payslip.show');
});
});

require __DIR__.'/auth.php';