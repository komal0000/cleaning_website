<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Cleanway</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Manrope:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --ink: #0b2440;
            --ink-deep: #071a2f;
            --blue: #0c87d1;
            --blue-dark: #086eae;
            --aqua: #54d6e7;
            --cloud: #f5fafc;
            --sand: #f3ede3;
            --lime: #bdeb75;
            --white: #ffffff;
            --text: #172332;
            --muted: #526579;
            --border: #d5e1e7;
            --danger: #d64545;
            --danger-soft: #fdecec;
            --success: #1e9e62;
            --success-soft: #e7f6ee;
            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 22px;
            --shadow-soft: 0 20px 45px rgba(11, 36, 64, 0.08);
            --shadow-card: 0 24px 60px -10px rgba(7, 26, 47, 0.18), 0 10px 24px -8px rgba(7, 26, 47, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background-color: #081a30;
            background-image: 
                radial-gradient(at 15% 15%, rgba(12, 135, 209, 0.28) 0px, transparent 50%),
                radial-gradient(at 85% 85%, rgba(84, 214, 231, 0.22) 0px, transparent 50%),
                radial-gradient(at 50% 50%, rgba(189, 235, 117, 0.08) 0px, transparent 65%),
                linear-gradient(145deg, #071a2f 0%, #0b2440 50%, #0f3054 100%);
            font-family: "Inter", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            font-size: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Subtle ambient decor */
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(12, 135, 209, 0.15) 0%, rgba(84, 214, 231, 0) 70%);
            top: -200px;
            right: -150px;
            pointer-events: none;
            border-radius: 50%;
        }

        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(189, 235, 117, 0.12) 0%, rgba(189, 235, 117, 0) 70%);
            bottom: -150px;
            left: -150px;
            pointer-events: none;
            border-radius: 50%;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
        }

        .auth-card {
            background: var(--white);
            border-radius: var(--radius-lg);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: var(--shadow-card);
            overflow: hidden;
            position: relative;
        }

        /* Top accent line matching Cleanway brand theme */
        .auth-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--lime) 0%, var(--aqua) 50%, var(--blue) 100%);
        }

        .auth-card-body {
            padding: 38px 36px 32px;
        }

        /* Header branding */
        .auth-header {
            text-align: center;
            margin-bottom: 28px;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            background: var(--cloud);
            border: 1px solid var(--border);
            border-radius: 999px;
            color: var(--muted);
            font-size: 0.76rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            margin-bottom: 14px;
        }

        .brand-badge svg {
            width: 14px;
            height: 14px;
            color: var(--blue);
        }

        .brand-logo-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 12px;
            text-decoration: none;
        }

        .brand-mark {
            display: grid;
            width: 44px;
            height: 44px;
            place-items: center;
            color: var(--ink);
            background: var(--lime);
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(189, 235, 117, 0.4);
            flex-shrink: 0;
        }

        .brand-mark svg {
            width: 24px;
            height: 24px;
        }

        .brand-text {
            color: var(--ink);
            font-family: "Manrope", sans-serif;
            font-size: 1.35rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.1;
            text-align: left;
        }

        .brand-subtext {
            display: block;
            color: var(--muted);
            font-family: "Inter", sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .auth-title {
            color: var(--ink);
            font-family: "Manrope", sans-serif;
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
        }

        .auth-subtitle {
            color: var(--muted);
            font-size: 0.88rem;
            margin-bottom: 0;
            line-height: 1.45;
        }

        /* Form elements */
        .form-label {
            display: block;
            margin-bottom: 6px;
            color: var(--ink);
            font-size: 0.83rem;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        .input-group-custom {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-left {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            transition: color 0.15s ease;
        }

        .input-icon-left svg {
            width: 17px;
            height: 17px;
        }

        .form-control-custom {
            width: 100%;
            height: 48px;
            padding: 10px 14px 10px 42px;
            color: var(--text);
            background: var(--cloud);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            font-size: 0.92rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .form-control-custom.has-toggle {
            padding-right: 44px;
        }

        .form-control-custom:focus {
            background: var(--white);
            border-color: var(--aqua);
            box-shadow: 0 0 0 3.5px rgba(84, 214, 231, 0.25);
            outline: none;
            color: var(--ink);
        }

        .form-control-custom:focus + .input-icon-left,
        .input-group-custom:focus-within .input-icon-left {
            color: var(--blue);
        }

        .form-control-custom::placeholder {
            color: #9ab0c2;
            font-weight: 400;
        }

        .password-toggle-btn {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 5;
            transition: color 0.15s ease;
        }

        .password-toggle-btn:hover {
            color: var(--ink);
        }

        .password-toggle-btn svg {
            width: 17px;
            height: 17px;
        }

        /* Checkbox & Alignment */
        .form-remember-wrap {
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }

        .custom-check-label {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding: 0;
            color: var(--muted);
            font-size: 0.86rem;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
            line-height: 1;
        }

        .custom-check-input {
            appearance: none;
            -webkit-appearance: none;
            width: 18px;
            height: 18px;
            min-width: 18px;
            min-height: 18px;
            margin: 0 !important;
            padding: 0;
            border: 1.5px solid var(--border);
            border-radius: 5px;
            background-color: var(--cloud);
            cursor: pointer;
            display: inline-grid;
            place-content: center;
            flex-shrink: 0;
            position: relative;
            top: 0;
            transition: all 0.15s ease;
        }

        .custom-check-input::after {
            content: "";
            width: 9px;
            height: 9px;
            transform: scale(0);
            transition: 120ms transform ease-in-out;
            box-shadow: inset 1em 1em var(--white);
            clip-path: polygon(14% 44%, 0 65%, 50% 100%, 100% 16%, 80% 0%, 43% 62%);
        }

        .custom-check-input:checked {
            background-color: var(--blue);
            border-color: var(--blue);
        }

        .custom-check-input:checked::after {
            transform: scale(1);
        }

        .custom-check-input:focus {
            border-color: var(--aqua);
            box-shadow: 0 0 0 3px rgba(84, 214, 231, 0.25);
            outline: none;
        }

        .custom-check-label:hover .custom-check-input {
            border-color: var(--blue);
        }

        /* Submit Button */
        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 48px;
            padding: 10px 20px;
            color: var(--white);
            background: linear-gradient(135deg, var(--blue) 0%, var(--blue-dark) 100%);
            border: 1px solid var(--blue-dark);
            border-radius: var(--radius-sm);
            font-family: "Manrope", "Inter", sans-serif;
            font-size: 0.95rem;
            font-weight: 800;
            letter-spacing: -0.01em;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(12, 135, 209, 0.25);
            transition: all 0.2s ease;
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #1098e8 0%, var(--blue) 100%);
            transform: translateY(-1.5px);
            box-shadow: 0 10px 22px rgba(12, 135, 209, 0.35);
            color: var(--white);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(12, 135, 209, 0.2);
        }

        .btn-submit svg {
            width: 18px;
            height: 18px;
            transition: transform 0.15s ease;
        }

        .btn-submit:hover svg {
            transform: translateX(3px);
        }

        /* Alerts */
        .alert-custom-danger {
            background: var(--danger-soft);
            border: 1px solid #f7c5c5;
            color: var(--danger);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .alert-custom-danger svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .field-error-text {
            color: var(--danger);
            font-size: 0.78rem;
            font-weight: 600;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Auth card footer divider */
        .auth-divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 22px 0 18px;
            color: #a0b2c1;
            font-size: 0.72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .auth-divider::before,
        .auth-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--border);
        }

        .auth-divider span {
            padding: 0 10px;
        }

        /* Secondary actions */
        .employee-portal-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            background: var(--cloud);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--ink);
            text-decoration: none;
            font-size: 0.84rem;
            font-weight: 600;
            transition: all 0.15s ease;
        }

        .employee-portal-btn:hover {
            background: #eaf3f8;
            border-color: var(--aqua);
            color: var(--blue-dark);
        }

        .employee-portal-btn .icon-box {
            display: grid;
            width: 28px;
            height: 28px;
            place-items: center;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--blue);
            margin-right: 10px;
        }

        .employee-portal-btn .icon-box svg {
            width: 14px;
            height: 14px;
        }

        .auth-footer {
            margin-top: 24px;
            text-align: center;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #92abbd;
            text-decoration: none;
            font-size: 0.82rem;
            font-weight: 600;
            transition: color 0.15s ease;
        }

        .back-link:hover {
            color: var(--white);
        }

        .back-link svg {
            width: 14px;
            height: 14px;
        }

        .footer-copy {
            margin-top: 14px;
            color: #60798e;
            font-size: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-card-body">
                <!-- Header -->
                <div class="auth-header">
                    <div class="brand-badge">
                        <i data-lucide="shield-check"></i>
                        <span>Secure Management</span>
                    </div>

                    <div>
                        <a href="{{ url('/') }}" class="brand-logo-wrap">
                            <span class="brand-mark">
                                <i data-lucide="sparkles"></i>
                            </span>
                            <span class="brand-text">
                                Cleanway
                                <span class="brand-subtext">Admin Portal</span>
                            </span>
                        </a>
                    </div>

                    <h1 class="auth-title">Welcome back</h1>
                    <p class="auth-subtitle">Sign in to manage services, teams, bookings, and site operations.</p>
                </div>

                <!-- Global Errors -->
                @if ($errors->any())
                    <div class="alert-custom-danger">
                        <i data-lucide="alert-circle"></i>
                        <div>
                            @if ($errors->count() == 1)
                                {{ $errors->first() }}
                            @else
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" novalidate>
                    @csrf

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <div class="input-group-custom">
                            <span class="input-icon-left">
                                <i data-lucide="mail"></i>
                            </span>
                            <input type="email" 
                                   class="form-control-custom @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autocomplete="email" 
                                   autofocus
                                   placeholder="admin@cleanway.co.nz">
                        </div>
                        @error('email')
                            <div class="field-error-text">
                                <i data-lucide="alert-triangle" style="width: 13px; height: 13px;"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="password" class="form-label mb-0">Password</label>
                        </div>
                        <div class="input-group-custom">
                            <span class="input-icon-left">
                                <i data-lucide="lock"></i>
                            </span>
                            <input type="password" 
                                   class="form-control-custom has-toggle @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••••••">
                            <button type="button" class="password-toggle-btn" id="passwordToggleBtn" aria-label="Toggle password visibility" tabindex="-1">
                                <i data-lucide="eye" id="passwordToggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="field-error-text">
                                <i data-lucide="alert-triangle" style="width: 13px; height: 13px;"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="form-remember-wrap mb-4">
                        <label class="custom-check-label" for="remember">
                            <input class="custom-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>Keep me signed in</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-submit">
                        <span>Sign In to Dashboard</span>
                        <i data-lucide="arrow-right"></i>
                    </button>
                </form>

                <!-- Divider & Portals -->
                <div class="auth-divider">
                    <span>Other portals</span>
                </div>

                <a href="{{ route('employee.login') }}" class="employee-portal-btn">
                    <div class="d-flex align-items-center">
                        <div class="icon-box">
                            <i data-lucide="id-card"></i>
                        </div>
                        <span>Employee Attendance Access</span>
                    </div>
                    <i data-lucide="chevron-right" style="width: 16px; height: 16px; color: var(--muted);"></i>
                </a>
            </div>
        </div>

        <!-- Back to Website Footer -->
        <div class="auth-footer">
            <a href="{{ url('/') }}" class="back-link">
                <i data-lucide="arrow-left"></i>
                <span>Return to Cleanway Website</span>
            </a>
            <div class="footer-copy">
                &copy; {{ date('Y') }} Cleanway Service Limited. All rights reserved.
            </div>
        </div>
    </div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Toggle password visibility
        const passwordInput = document.getElementById('password');
        const passwordToggleBtn = document.getElementById('passwordToggleBtn');
        const passwordToggleIcon = document.getElementById('passwordToggleIcon');

        if (passwordToggleBtn && passwordInput) {
            passwordToggleBtn.addEventListener('click', function () {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                
                // Replace icon
                if (isPassword) {
                    passwordToggleIcon.setAttribute('data-lucide', 'eye-off');
                } else {
                    passwordToggleIcon.setAttribute('data-lucide', 'eye');
                }
                lucide.createIcons();
            });
        }
    </script>
</body>
</html>
