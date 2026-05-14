<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Ninin's Brew Payroll</title>
    @vite(['resources/css/app.css'])
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Segoe UI',sans-serif; background:#0F172A; color:#111827; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .auth-wrapper { width:100%; display:flex; align-items:center; justify-content:center; padding:2rem 1rem; }
        .auth-card { background:white; padding:2.5rem; border-radius:16px; box-shadow:0 20px 60px rgba(0,0,0,0.4); width:100%; max-width:400px; }
        .auth-logo { text-align:center; margin-bottom:2rem; }
        .auth-logo .icon { width:56px; height:56px; background:linear-gradient(135deg,#3B82F6,#1E3A8A); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem; font-size:1.5rem; }
        .auth-logo h1 { font-size:1.4rem; font-weight:700; color:#1E3A8A; }
        .auth-logo p  { font-size:0.85rem; color:#6B7280; margin-top:0.25rem; }
        .form-group   { margin-bottom:1.1rem; }
        .form-label   { display:block; font-size:0.875rem; font-weight:500; color:#374151; margin-bottom:0.35rem; }
        .form-control { width:100%; padding:0.6rem 0.75rem; border:1px solid #E5E7EB; border-radius:8px; font-size:0.875rem; box-sizing:border-box; background:#F9FAFB; transition:all 0.2s; }
        .form-control:focus { outline:none; border-color:#3B82F6; box-shadow:0 0 0 3px rgba(59,130,246,0.15); background:white; }
        .btn-block { width:100%; padding:0.7rem; background:linear-gradient(135deg,#1E3A8A,#3B82F6); color:white; border:none; border-radius:8px; font-size:0.95rem; font-weight:600; cursor:pointer; margin-top:0.5rem; transition:opacity 0.2s; letter-spacing:0.01em; }
        .btn-block:hover { opacity:0.9; }
        .auth-footer { text-align:center; font-size:0.85rem; margin-top:1.5rem; color:#6B7280; }
        .auth-footer a { color:#1E3A8A; font-weight:600; text-decoration:none; }
        .auth-footer a:hover { text-decoration:underline; }
        .alert-error { background:#FEE2E2; color:#991B1B; border-left:4px solid #EF4444; padding:0.75rem 1rem; border-radius:8px; font-size:0.875rem; margin-bottom:1.25rem; }
        .divider { text-align:center; font-size:0.75rem; color:#9CA3AF; margin:1.25rem 0 0; }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-card">
            <div class="auth-logo">
                <div class="icon">💼</div>
                <h1>Ninin's Brew</h1>
                <p>Payroll Management System</p>
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

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control" required autofocus placeholder="you@example.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control" required placeholder="••••••••">
                </div>
                <button type="submit" class="btn-block">Login</button>
            </form>

            <div class="divider">— or —</div>
            <div class="auth-footer">
                No account yet? <a href="{{ route('register') }}">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>