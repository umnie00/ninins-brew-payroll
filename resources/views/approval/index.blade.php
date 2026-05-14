@extends('layouts.app')
@section('title', 'Payroll Approval')

@section('content')

{{-- PAGE HEADER --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:1.5rem;">
    <div>
        <h1 class="page-title">Payroll Approval</h1>
        <p style="color:#6B7280; font-size:0.875rem; margin-top:0.2rem;">
            <i class="fa-solid fa-circle-check" style="color:#3B82F6; margin-right:4px;"></i>
            Review and action pending payroll records
        </p>
    </div>
</div>

{{-- SUMMARY CARDS --}}
<div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1rem; margin-bottom:1.5rem;">

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Pending
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#F59E0B;">
                    {{ $pending->count() }}
                </p>
            </div>
            <div style="background:rgba(245,158,11,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-hourglass-half" style="color:#F59E0B; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Approved
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#10B981;">
                    {{ $processed->where('status','approved')->count() }}
                </p>
            </div>
            <div style="background:rgba(16,185,129,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-circle-check" style="color:#10B981; font-size:1rem;"></i>
            </div>
        </div>
    </div>

    <div style="background:#1E293B; border-radius:12px; padding:1.25rem; color:white;">
        <div style="display:flex; justify-content:space-between; align-items:flex-start;">
            <div>
                <p style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.05em; color:#94A3B8; margin-bottom:0.5rem;">
                    Rejected
                </p>
                <p style="font-size:1.8rem; font-weight:700; color:#EF4444;">
                    {{ $processed->where('status','rejected')->count() }}
                </p>
            </div>
            <div style="background:rgba(239,68,68,0.2); border-radius:10px; width:38px; height:38px;
                        display:flex; align-items:center; justify-content:center;">
                <i class="fa-solid fa-circle-xmark" style="color:#EF4444; font-size:1rem;"></i>
            </div>
        </div>
    </div>

</div>

{{-- PENDING APPROVALS --}}
<div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07);
            overflow:hidden; margin-bottom:1.5rem;">

    <div style="padding:1rem 1.5rem; background:#1E293B;
                display:flex; justify-content:space-between; align-items:center;">
        <p style="font-weight:700; font-size:0.9rem; color:white;">
            <i class="fa-solid fa-hourglass-half" style="color:#F59E0B; margin-right:6px;"></i>
            Pending Approval
            @if($pending->count() > 0)
                <span style="background:rgba(245,158,11,0.2); color:#F59E0B;
                             font-size:0.72rem; padding:0.15rem 0.5rem;
                             border-radius:999px; margin-left:0.4rem;">
                    {{ $pending->count() }} waiting
                </span>
            @endif
        </p>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Period</th>
                    <th>Gross Pay</th>
                    <th>Net Pay</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pending as $payroll)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <div style="width:32px; height:32px; background:#1E293B;
                                        border-radius:8px; display:flex; align-items:center;
                                        justify-content:center; font-size:0.75rem;
                                        font-weight:700; color:#60A5FA; flex-shrink:0;">
                                {{ strtoupper(substr($payroll->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight:600; font-size:0.875rem; color:#111827;">
                                    {{ $payroll->employee->full_name }}
                                </p>
                                <p style="font-size:0.75rem; color:#9CA3AF;">
                                    {{ $payroll->employee->job_title }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:0.82rem; background:#F8FAFC; padding:0.25rem 0.6rem;
                                     border-radius:6px; color:#374151; font-weight:500;">
                            {{ \Carbon\Carbon::parse($payroll->period_start)->format('M d') }}
                            –
                            {{ \Carbon\Carbon::parse($payroll->period_end)->format('M d, Y') }}
                        </span>
                    </td>
                    <td style="color:#374151; font-weight:500;">
                        ₱{{ number_format($payroll->gross_pay + $payroll->overtime_pay, 2) }}
                    </td>
                    <td>
                        <strong style="color:#10B981; font-size:0.95rem;">
                            ₱{{ number_format($payroll->net_pay, 2) }}
                        </strong>
                    </td>
                    <td>
                        <div style="display:flex; flex-direction:column; gap:0.5rem;">
                            {{-- APPROVE --}}
                            <form action="{{ route('approval.approve', $payroll->id) }}"
                                  method="POST">
                                @csrf
                                <button type="submit"
                                        onclick="return confirm('Approve this payroll?')"
                                        style="background:#ECFDF5; color:#065F46; border:1px solid #A7F3D0;
                                               padding:0.35rem 0.85rem; border-radius:6px; font-size:0.8rem;
                                               font-weight:600; cursor:pointer; width:100%;
                                               display:flex; align-items:center; gap:0.4rem;">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                            </form>

                            {{-- REJECT TOGGLE --}}
                            <button type="button"
                                    onclick="toggleReject({{ $payroll->id }})"
                                    style="background:#FEF2F2; color:#991B1B; border:1px solid #FECACA;
                                           padding:0.35rem 0.85rem; border-radius:6px; font-size:0.8rem;
                                           font-weight:600; cursor:pointer; width:100%;
                                           display:flex; align-items:center; gap:0.4rem;">
                                <i class="fa-solid fa-xmark"></i> Reject
                            </button>

                            {{-- REJECT FORM (hidden) --}}
                            <div id="reject-{{ $payroll->id }}" style="display:none;">
                                <form action="{{ route('approval.reject', $payroll->id) }}" method="POST">
                                    @csrf
                                    <input type="text" name="remarks"
                                           placeholder="Reason for rejection..."
                                           class="form-control"
                                           style="margin-bottom:0.4rem; font-size:0.82rem;" required>
                                    <button type="submit"
                                            style="background:#EF4444; color:white; border:none;
                                                   padding:0.35rem 0.85rem; border-radius:6px;
                                                   font-size:0.8rem; font-weight:600; cursor:pointer;
                                                   width:100%; display:flex; align-items:center; gap:0.4rem;">
                                        <i class="fa-solid fa-triangle-exclamation"></i> Confirm Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center; color:#6B7280; padding:2.5rem;">
                        <i class="fa-solid fa-circle-check" style="font-size:2rem; color:#D1D5DB; display:block; margin-bottom:0.75rem;"></i>
                        No payroll pending approval — all caught up! 🎉
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- PROCESSED RECORDS --}}
<div style="background:white; border-radius:12px; box-shadow:0 1px 4px rgba(0,0,0,0.07); overflow:hidden;">

    <div style="padding:1rem 1.5rem; background:#1E293B;
                display:flex; justify-content:space-between; align-items:center;">
        <p style="font-weight:700; font-size:0.9rem; color:white;">
            <i class="fa-solid fa-clipboard-list" style="color:#60A5FA; margin-right:6px;"></i>
            Processed Records
        </p>
        <span style="font-size:0.78rem; color:#94A3B8;">
            {{ $processed->count() }} record(s)
        </span>
    </div>

    <div class="table-wrapper">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Period</th>
                    <th>Net Pay</th>
                    <th>Status</th>
                    <th>Actioned By</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                @forelse($processed as $payroll)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.6rem;">
                            <div style="width:32px; height:32px; background:#1E293B;
                                        border-radius:8px; display:flex; align-items:center;
                                        justify-content:center; font-size:0.75rem;
                                        font-weight:700; color:#60A5FA; flex-shrink:0;">
                                {{ strtoupper(substr($payroll->employee->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="font-weight:600; font-size:0.875rem; color:#111827;">
                                    {{ $payroll->employee->full_name }}
                                </p>
                                <p style="font-size:0.75rem; color:#9CA3AF;">
                                    {{ $payroll->employee->job_title }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span style="font-size:0.82rem; background:#F8FAFC; padding:0.25rem 0.6rem;
                                     border-radius:6px; color:#374151; font-weight:500;">
                            {{ \Carbon\Carbon::parse($payroll->period_start)->format('M d') }}
                            –
                            {{ \Carbon\Carbon::parse($payroll->period_end)->format('M d, Y') }}
                        </span>
                    </td>
                    <td>
                        <strong style="color:#10B981; font-size:0.95rem;">
                            ₱{{ number_format($payroll->net_pay, 2) }}
                        </strong>
                    </td>
                    <td>
                        <span class="badge badge-{{ $payroll->status }}">
                            @if($payroll->status === 'approved')
                                <i class="fa-solid fa-check" style="margin-right:3px;"></i>
                            @else
                                <i class="fa-solid fa-xmark" style="margin-right:3px;"></i>
                            @endif
                            {{ ucfirst($payroll->status) }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; align-items:center; gap:0.4rem; font-size:0.82rem;">
                            <i class="fa-solid fa-user-shield" style="color:#9CA3AF; font-size:0.75rem;"></i>
                            {{ $payroll->approval?->approvedBy?->name ?? '—' }}
                        </div>
                    </td>
                    <td>
                        @if($payroll->approval?->remarks)
                            <span style="font-size:0.82rem; color:#6B7280; background:#F8FAFC;
                                         padding:0.2rem 0.5rem; border-radius:4px;">
                                {{ $payroll->approval->remarks }}
                            </span>
                        @else
                            <span style="color:#D1D5DB;">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; color:#6B7280; padding:2.5rem;">
                        <i class="fa-solid fa-folder-open" style="font-size:2rem; color:#D1D5DB; display:block; margin-bottom:0.75rem;"></i>
                        No processed records yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleReject(id) {
        const div = document.getElementById('reject-' + id);
        div.style.display = div.style.display === 'none' ? 'block' : 'none';
    }
</script>

@endsection