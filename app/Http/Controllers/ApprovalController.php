<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\PayrollApproval;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ApprovalController extends Controller
{
    // ── LIST all payroll pending approval ────────────────────
    public function index()
    {
        $pending  = Payroll::with('employee')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        $processed = Payroll::with(['employee', 'approval.approvedBy'])
            ->whereIn('status', ['approved', 'rejected'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('approval.index', compact('pending', 'processed'));
    }

    // ── APPROVE a payroll record ─────────────────────────────
    public function approve(Request $request, Payroll $payroll)
    {
        // ── All logic in Controller — MVC rule ───────────────
        $payroll->update(['status' => 'approved']);

        PayrollApproval::create([
            'payroll_id'  => $payroll->id,
            'approved_by' => auth()->id(),
            'status'      => 'approved',
            'remarks'     => $request->remarks ?? null,
            'acted_at'    => Carbon::now(),
        ]);

        return redirect()->route('approval.index')
            ->with('success', 'Payroll approved for ' . $payroll->employee->full_name . '.');
    }

    // ── REJECT a payroll record ──────────────────────────────
    public function reject(Request $request, Payroll $payroll)
    {
        $request->validate([
            'remarks' => 'required|string|max:255',
        ]);

        $payroll->update(['status' => 'rejected']);

        PayrollApproval::create([
            'payroll_id'  => $payroll->id,
            'approved_by' => auth()->id(),
            'status'      => 'rejected',
            'remarks'     => $request->remarks,
            'acted_at'    => Carbon::now(),
        ]);

        return redirect()->route('approval.index')
            ->with('success', 'Payroll rejected for ' . $payroll->employee->full_name . '.');
    }
}