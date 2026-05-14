<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "Ninin's Brew Payroll")</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', sans-serif; background: #F9FAFB; color: #111827; }

        /* ── NAVBAR ── */
        .navbar {
            background: linear-gradient(135deg, #1E3A8A 0%, #1e4db7 100%);
            color: white;
            padding: 0 1.5rem;
            height: 56px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.25);
        }
        .navbar-brand {
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }
        .navbar-brand .brand-icon {
            background: rgba(255,255,255,0.15);
            border-radius: 8px;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        .navbar-user {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 0.875rem;
        }
        .navbar-user-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            opacity: 0.9;
        }
        .navbar-user-info .avatar {
            width: 30px;
            height: 30px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
        }
        .logout-btn {
            background: rgba(255,255,255,0.15);
            color: white;
            border: 1px solid rgba(255,255,255,0.25);
            padding: 0.35rem 0.9rem;
            border-radius: 6px;
            font-size: 0.8rem;
            cursor: pointer;
            font-weight: 500;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .logout-btn:hover { background: rgba(255,255,255,0.25); }

        /* ── LAYOUT ── */
     .app-wrapper {
    display: flex;
    height: calc(100vh - 56px);
    overflow: hidden;
}

        /* ── SIDEBAR ── */
 .sidebar {
    width: 240px;
    background: linear-gradient(180deg, #1E3A8A 0%, #172e6e 100%);
    color: white;
    padding: 1.25rem 0.85rem;
    display: flex;
    flex-direction: column;
    gap: 0.15rem;
    flex-shrink: 0;
    box-shadow: 2px 0 12px rgba(0,0,0,0.15);
    height: 100%;
    overflow-y: auto;
}
        .sidebar-label {
            font-size: 0.62rem;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            color: #93C5FD;
            margin: 1rem 0 0.5rem 0.75rem;
            font-weight: 600;
        }
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            padding: 0.6rem 0.85rem;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #BFDBFE;
            text-decoration: none;
            transition: background 0.2s, color 0.2s, transform 0.1s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(2px);
        }
        .sidebar a.active {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
            color: white;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(59,130,246,0.4);
        }
        .sidebar a .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .sidebar hr {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.08);
            margin: 0.75rem 0;
        }

        /* ── USER CARD (bottom of sidebar) ── */
        .sidebar-user-card {
            margin-top: auto;
            padding: 0.85rem;
            background: rgba(255,255,255,0.07);
            border-radius: 10px;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-user-card .su-label {
            font-size: 0.62rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #93C5FD;
            margin-bottom: 0.4rem;
        }
        .sidebar-user-card .su-name {
            font-size: 0.85rem;
            color: white;
            font-weight: 600;
            margin-bottom: 0.25rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-card .su-role {
            font-size: 0.75rem;
            color: #BFDBFE;
            display: flex;
            align-items: center;
            gap: 0.35rem;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
        flex: 1;
        padding: 2rem;
        min-width: 0;
        height: 100%;
        overflow-y: auto;
    }

        /* ── PAGE HEADER ── */
        .page-header  { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .page-title   { font-size: 1.5rem; font-weight: 700; color: #111827; }

        /* ── CARDS ── */
        .card      { background: white; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.07); overflow: hidden; }
        .card-body { padding: 1.5rem; }

        /* ── STAT CARDS ── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card { background: white; border-radius: 10px; padding: 1.25rem 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,0.07); border-left: 4px solid #3B82F6; }
        .stat-card.green  { border-left-color: #10B981; }
        .stat-card.yellow { border-left-color: #F59E0B; }
        .stat-card.red    { border-left-color: #EF4444; }
        .stat-card.purple { border-left-color: #8B5CF6; }
        .stat-label { font-size: 0.78rem; color: #6B7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.4rem; }
        .stat-value { font-size: 1.6rem; font-weight: 700; color: #111827; }

        /* ── BUTTONS ── */
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.1rem; border-radius: 6px; font-size: 0.875rem; font-weight: 500; cursor: pointer; border: none; text-decoration: none; transition: background 0.2s, opacity 0.2s; }
        .btn-primary   { background: #1E3A8A; color: white; }
        .btn-primary:hover   { background: #2D4EAA; color: white; }
        .btn-secondary { background: #E5E7EB; color: #111827; }
        .btn-secondary:hover { background: #D1D5DB; }
        .btn-success   { background: #10B981; color: white; }
        .btn-success:hover   { background: #059669; color: white; }
        .btn-danger    { background: none; border: none; color: #DC2626; font-size: 0.8rem; cursor: pointer; padding: 0; }
        .btn-danger:hover    { text-decoration: underline; }
        .btn-edit      { color: #2563EB; font-size: 0.8rem; text-decoration: none; }
        .btn-edit:hover      { text-decoration: underline; }

        /* ── TABLES ── */
        .table-wrapper { overflow-x: auto; }
        table.data-table { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
        table.data-table thead { background: #F3F4F6; color: #6B7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
        table.data-table th,
        table.data-table td  { padding: 0.75rem 1rem; text-align: left; border-bottom: 1px solid #E5E7EB; }
        table.data-table tbody tr:hover { background: #F9FAFB; }
        .actions { display: flex; gap: 0.75rem; align-items: center; }

        /* ── BADGES ── */
        .badge          { display: inline-block; padding: 0.2rem 0.65rem; border-radius: 999px; font-size: 0.72rem; font-weight: 500; }
        .badge-active   { background: #D1FAE5; color: #065F46; }
        .badge-inactive { background: #F3F4F6; color: #6B7280; }
        .badge-pending  { background: #FEF3C7; color: #92400E; }
        .badge-approved { background: #D1FAE5; color: #065F46; }
        .badge-rejected { background: #FEE2E2; color: #991B1B; }
        .badge-completed { background: #D1FAE5; color: #065F46; }
        .badge-ongoing  { background: #EDE9FE; color: #5B21B6; }

        /* ── FORMS ── */
        .form-group   { margin-bottom: 1.25rem; }
        .form-label   { display: block; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.4rem; color: #374151; }
        .form-control {
            width: 100%; padding: 0.5rem 0.75rem;
            border: 1px solid #D1D5DB; border-radius: 6px;
            font-size: 0.875rem; background: white;
            box-sizing: border-box; color: #111827;
            transition: border-color 0.2s;
        }
        .form-control:focus { outline: none; border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.15); }
        .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; }

        /* ── ALERTS ── */
        .alert         { padding: 0.75rem 1rem; border-radius: 6px; font-size: 0.875rem; margin-bottom: 1.25rem; border-left: 4px solid transparent; display: flex; align-items: center; gap: 0.5rem; }
        .alert-success { background: #D1FAE5; color: #065F46; border-left-color: #10B981; }
        .alert-error   { background: #FEE2E2; color: #991B1B; border-left-color: #EF4444; }
        .alert-warning { background: #FEF3C7; color: #92400E; border-left-color: #F59E0B; }
        .alert-info    { background: #DBEAFE; color: #1E40AF; border-left-color: #3B82F6; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="navbar-brand">
            <div class="brand-icon">
                <i class="fa-solid fa-mug-hot"></i>
            </div>
            Ninin's Brew Payroll
        </div>
        <div class="navbar-user">
            <div class="navbar-user-info">
                <div class="avatar">
                    <i class="fa-solid fa-user"></i>
                </div>
                <span>{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    {{-- WRAPPER --}}
    <div class="app-wrapper">

        {{-- SIDEBAR --}}
        <aside class="sidebar">

            @if(auth()->user()->isAdmin())
                <p class="sidebar-label">Main</p>

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
                    Dashboard
                </a>

                <p class="sidebar-label">Management</p>

                <a href="{{ route('employees.index') }}"
                   class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                    Employees
                </a>

                <a href="{{ route('attendance.index') }}"
                   class="{{ request()->routeIs('attendance.index') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
                    Attendance
                </a>

                <p class="sidebar-label">Payroll</p>

                <a href="{{ route('payroll.index') }}"
                   class="{{ request()->routeIs('payroll.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-money-bill-wave"></i></span>
                    Payroll
                </a>

                <a href="{{ route('approval.index') }}"
                   class="{{ request()->routeIs('approval.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-circle-check"></i></span>
                    Approval
                </a>

                <hr>

            @else
                <p class="sidebar-label">My Menu</p>

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
                    Dashboard
                </a>

                <a href="{{ route('attendance.show') }}"
                   class="{{ request()->routeIs('attendance.show') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-clock"></i></span>
                    My Attendance
                </a>

                <a href="{{ route('payslip.index') }}"
                   class="{{ request()->routeIs('payslip.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                    My Payslip
                </a>

                <hr>
            @endif

            {{-- USER CARD AT BOTTOM --}}
            <div class="sidebar-user-card">
                <div class="su-label">Logged in as</div>
                <div class="su-name">{{ auth()->user()->name }}</div>
                <div class="su-role">
                    <i class="fa-solid fa-{{ auth()->user()->isAdmin() ? 'shield-halved' : 'id-badge' }}"></i>
                    {{ ucfirst(auth()->user()->role) }}
                </div>
            </div>

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="main-content">

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</body>
</html>