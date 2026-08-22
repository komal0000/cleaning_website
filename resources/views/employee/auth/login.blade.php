<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at top left, rgba(14, 165, 233, 0.28), transparent 35%),
                radial-gradient(circle at bottom right, rgba(16, 185, 129, 0.2), transparent 30%),
                linear-gradient(135deg, #0f172a, #1e293b 55%, #334155);
            font-family: "Segoe UI", sans-serif;
        }

        .panel-card {
            width: min(100%, 430px);
            background: rgba(255, 255, 255, 0.97);
            border-radius: 24px;
            box-shadow: 0 28px 60px rgba(15, 23, 42, 0.32);
            padding: 36px;
        }

        .hero-chip {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.04em;
        }
    </style>
</head>
<body>
    <div class="panel-card">
        <div class="mb-4">
            <span class="hero-chip">EMPLOYEE ACCESS</span>
            <h1 class="mt-3 mb-2 fw-bold">Attendance Panel</h1>
            <p class="text-muted mb-0">Sign in with your 4-digit code and 6-digit password.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('employee.login.submit') }}">
            @csrf
            <div class="mb-3">
                <label for="employee_code" class="form-label">Employee Code</label>
                <input id="employee_code" name="employee_code" type="text" inputmode="numeric" maxlength="4" class="form-control form-control-lg" value="{{ old('employee_code') }}" required>
            </div>
            <div class="mb-4">
                <label for="employee_password" class="form-label">Password</label>
                <input id="employee_password" name="employee_password" type="password" inputmode="numeric" maxlength="6" class="form-control form-control-lg" required>
            </div>
            <button type="submit" class="btn btn-dark btn-lg w-100">Open Employee Panel</button>
        </form>
    </div>
</body>
</html>
