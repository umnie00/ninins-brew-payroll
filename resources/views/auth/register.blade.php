<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — Ninin's Brew Payroll</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#0F172A; color:#111827; }
        .auth-wrapper { min-height:100vh; display:flex; align-items:center; justify-content:center; padding:2rem 1rem; }
        .auth-card { background:white; padding:2.5rem; border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.4); width:100%; max-width:520px; }
        .auth-logo { text-align:center; margin-bottom:1.5rem; }
        .auth-logo .icon { width:56px; height:56px; background:linear-gradient(135deg,#3B82F6,#1E3A8A); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem; }
        .auth-logo h1 { font-size:1.4rem; font-weight:700; color:#1E3A8A; }
        .auth-logo p  { font-size:0.85rem; color:#6B7280; margin-top:0.25rem; }
        .form-group   { margin-bottom:1.1rem; }
        .form-label   { display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.35rem; }
        .form-control { width:100%; padding:0.6rem 0.75rem; border:1px solid #E5E7EB; border-radius:8px; font-size:0.875rem; box-sizing:border-box; background:#F9FAFB; transition:all 0.2s; }
        .form-control:focus { outline:none; border-color:#3B82F6; box-shadow:0 0 0 3px rgba(59,130,246,0.15); background:white; }
        .form-grid-2  { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        .section-title { font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:#94A3B8; margin:1.25rem 0 0.75rem; border-top:1px solid #F1F5F9; padding-top:1rem; font-weight:600; }
        .btn-block { width:100%; padding:0.7rem; background:linear-gradient(135deg,#1E3A8A,#3B82F6); color:white; border:none; border-radius:8px; font-size:0.95rem; font-weight:600; cursor:pointer; margin-top:0.75rem; transition:opacity 0.2s; }
        .btn-block:hover { opacity:0.9; }
        .auth-footer { text-align:center; font-size:0.85rem; margin-top:1.25rem; color:#6B7280; }
        .auth-footer a { color:#1E3A8A; font-weight:600; text-decoration:none; }
        .alert-error { background:#FEE2E2; color:#991B1B; border-left:4px solid #EF4444; padding:0.75rem 1rem; border-radius:8px; font-size:0.875rem; margin-bottom:1.25rem; }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="icon">💼</div>
            <h1>Ninin's Brew</h1>
            <p>Create your employee account</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin:0; padding-left:1.2rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <p class="section-title"><i class="fa-solid fa-user" style="margin-right:4px;"></i> Personal Information</p>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" value="{{ old('address') }}" class="form-control" required>
                </div>
            </div>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-control" required>
                        <option value="">-- Select --</option>
                        <option value="Male"   {{ old('gender') == 'Male'   ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>
            </div>

            <p class="section-title"><i class="fa-solid fa-phone-volume" style="margin-right:4px;"></i> Emergency Contact</p>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Contact Name</label>
                    <input type="text" name="emergency_name" value="{{ old('emergency_name') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Relationship</label>
                    <select name="emergency_relationship" class="form-control" required>
                        <option value="">-- Select --</option>
                        @foreach(['Parent','Spouse','Sibling','Child','Relative','Friend'] as $rel)
                            <option value="{{ $rel }}" {{ old('emergency_relationship') == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Emergency Contact Number</label>
                <input type="text" name="emergency_phone" value="{{ old('emergency_phone') }}" class="form-control" required>
            </div>

            <p class="section-title"><i class="fa-solid fa-briefcase" style="margin-right:4px;"></i> Job Information</p>
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Job Title</label>
                    <select name="job_title" id="job_title" class="form-control" required onchange="updateDept()">
                        <option value="">-- Select Job Title --</option>
                        @foreach(['Head Cook'=>'Kitchen','Line Cook'=>'Kitchen','Kitchen Assistant'=>'Kitchen','Head Barista'=>'Bar','Barista'=>'Bar','Cashier'=>'Front of House','Service Crew'=>'Front of House','Cleaner'=>'Operations','Dishwasher'=>'Operations','Stock Keeper'=>'Operations'] as $title => $dept)
                            <option value="{{ $title }}" data-dept="{{ $dept }}" {{ old('job_title') == $title ? 'selected' : '' }}>{{ $title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" id="department" value="{{ old('department') }}" class="form-control" readonly placeholder="Auto-filled">
                </div>
            </div>

            <p class="section-title"><i class="fa-solid fa-lock" style="margin-right:4px;"></i> Account Credentials</p>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn-block">Create Account</button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </div>
</div>
<script>
    function updateDept() {
        const select = document.getElementById('job_title');
        const dept = select.options[select.selectedIndex].getAttribute('data-dept') || '';
        document.getElementById('department').value = dept;
    }
    window.addEventListener('load', updateDept);
</script>
</body>
</html>