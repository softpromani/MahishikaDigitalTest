<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Mahishika Digital CMS</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --brand-primary: #0f172a;
            --brand-accent: #2563eb;
            --brand-accent-hover: #1d4ed8;
        }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            padding: 1.5rem;
        }
        [data-bs-theme="dark"] body {
            background: linear-gradient(135deg, #060911 0%, #0f172a 100%);
            color: #f1f5f9;
        }
        .login-card {
            width: 100%;
            max-width: 440px;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 20px 40px -15px rgba(15, 23, 42, 0.15);
            overflow: hidden;
            transition: all 0.3s ease;
        }
        [data-bs-theme="dark"] .login-card {
            background: #0b1120;
            border-color: rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7);
        }
        .brand-badge {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb 0%, #7c3aed 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.5rem;
            box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
        }
        .form-control {
            padding: 0.75rem 1rem;
            border-radius: 8px;
            border: 1px solid rgba(0,0,0,0.12);
            font-size: 0.95rem;
        }
        [data-bs-theme="dark"] .form-control {
            background-color: #111a2e;
            border-color: rgba(255, 255, 255, 0.1);
            color: #f8fafc;
        }
        .form-control:focus {
            border-color: var(--brand-accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25);
        }
        .btn-login {
            background: var(--brand-accent);
            color: #ffffff;
            font-weight: 600;
            padding: 0.8rem;
            border-radius: 8px;
            border: none;
            width: 100%;
            transition: all 0.2s ease;
        }
        .btn-login:hover {
            background: var(--brand-accent-hover);
            color: #ffffff;
            transform: translateY(-1px);
        }
        .demo-credentials-box {
            background: rgba(37, 99, 235, 0.06);
            border: 1px dashed rgba(37, 99, 235, 0.3);
            border-radius: 10px;
            padding: 0.9rem;
            font-size: 0.84rem;
        }
        [data-bs-theme="dark"] .demo-credentials-box {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="p-4 p-sm-5">
            <!-- Header & Logo -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-3">
                    <span class="brand-badge">
                        <i class="bi bi-cpu-fill"></i>
                    </span>
                    <div>
                        <h1 class="h5 fw-bold mb-0">Mahishika CMS</h1>
                        <span class="text-secondary small">Agency Portal Login</span>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary py-1 px-2" id="themeBtn" aria-label="Toggle theme">
                    <i class="bi bi-moon-stars" id="themeIcon"></i>
                </button>
            </div>

            <!-- Flash Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show small d-flex align-items-center mb-3" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show small mb-3" role="alert">
                    <div class="fw-semibold mb-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Authentication failed:</div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- 1-Click Demo Fill Box -->
            <div class="demo-credentials-box mb-4">
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <span class="fw-bold text-primary"><i class="bi bi-key-fill me-1"></i> Demo Credentials:</span>
                    <button type="button" class="btn btn-xs btn-primary py-0 px-2 fw-semibold" style="font-size: 0.75rem;" onclick="fillCredentials('admin@mahishika.digital', 'password123')">
                        1-Click Fill
                    </button>
                </div>
                <div class="d-flex flex-column text-muted" style="font-size: 0.8rem;">
                    <span>Email: <code class="user-select-all">admin@mahishika.digital</code></span>
                    <span>Password: <code class="user-select-all">password123</code></span>
                </div>
            </div>

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="emailInput" class="form-label fw-semibold small">Admin Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0 text-muted">
                            <i class="bi bi-envelope"></i>
                        </span>
                        <input type="email" 
                               name="email" 
                               id="emailInput" 
                               class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" 
                               placeholder="admin@mahishika.digital" 
                               value="{{ old('email', 'admin@mahishika.digital') }}" 
                               required 
                               autocomplete="email" 
                               autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label for="passwordInput" class="form-label fw-semibold small mb-0">Password</label>
                        <span class="text-muted small" style="font-size: 0.75rem;">Default: password123</span>
                    </div>
                    <div class="input-group">
                        <span class="input-group-text bg-body-tertiary border-end-0 text-muted">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" 
                               name="password" 
                               id="passwordInput" 
                               class="form-control border-start-0 border-end-0 ps-0 @error('password') is-invalid @enderror" 
                               placeholder="••••••••••••" 
                               value="password123"
                               required 
                               autocomplete="current-password">
                        <button type="button" class="input-group-text bg-body-tertiary border-start-0 text-muted" onclick="togglePasswordVisibility()" aria-label="Toggle password view">
                            <i class="bi bi-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="rememberCheck" class="form-check-input" checked>
                        <label for="rememberCheck" class="form-check-label small text-secondary">Remember session</label>
                    </div>
                    <a href="#" class="small text-decoration-none text-muted" onclick="alert('For security testing, please use the 1-Click Fill demo credentials.'); return false;">
                        Forgot password?
                    </a>
                </div>

                <button type="submit" class="btn btn-login mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to Admin Portal
                </button>
            </form>

            <div class="text-center pt-2 border-top">
                <a href="{{ route('home') }}" class="small text-decoration-none text-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Return to Public Website
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function fillCredentials(email, pwd) {
            document.getElementById('emailInput').value = email;
            document.getElementById('passwordInput').value = pwd;
        }

        function togglePasswordVisibility() {
            const pwd = document.getElementById('passwordInput');
            const icon = document.getElementById('passwordToggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pwd.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Theme Toggle
        const html = document.documentElement;
        const themeBtn = document.getElementById('themeBtn');
        const themeIcon = document.getElementById('themeIcon');
        const savedTheme = localStorage.getItem('mahishika_admin_theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(savedTheme);

        themeBtn?.addEventListener('click', () => {
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            localStorage.setItem('mahishika_admin_theme', next);
        });

        function applyTheme(theme) {
            html.setAttribute('data-bs-theme', theme);
            if (themeIcon) {
                themeIcon.className = theme === 'dark' ? 'bi bi-sun-fill text-warning' : 'bi bi-moon-stars';
            }
        }
    </script>
</body>
</html>
