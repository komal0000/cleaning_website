<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8fafc;
            font-family: "Segoe UI", sans-serif;
        }

        .shell {
            max-width: 1180px;
            margin: 32px auto;
            padding: 0 16px;
        }

        .hero {
            background: linear-gradient(135deg, #0f766e, #155e75 55%, #1d4ed8);
            color: #fff;
            border-radius: 28px;
            padding: 28px;
            box-shadow: 0 24px 50px rgba(15, 23, 42, 0.18);
        }

        .card-panel {
            background: #fff;
            border-radius: 22px;
            padding: 24px;
            box-shadow: 0 18px 40px rgba(148, 163, 184, 0.16);
            height: 100%;
        }
    </style>
</head>
<body>
    <div class="shell">
        <div class="hero d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center mb-4">
            <div>
                <div class="small text-white-50 mb-1">SIGNED IN</div>
                <h1 class="h2 mb-2">{{ $employee->name }}</h1>
                <div class="text-white-50">Employee code: {{ $employee->employee_code }}</div>
                <div class="mt-2">
                    @if($openAttendanceRecord)
                        <span class="badge text-bg-warning">Open shift since {{ $openAttendanceRecord->clock_in_at->format('M d, Y H:i') }}</span>
                    @else
                        <span class="badge text-bg-success">No open shift</span>
                    @endif
                </div>
            </div>
            <form method="POST" action="{{ route('employee.logout') }}">
                @csrf
                <button type="submit" class="btn btn-light">Logout</button>
            </form>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="card-panel">
                    @if($openAttendanceRecord)
                        <h2 class="h4 mb-3">Clock Out</h2>
                        <p class="text-muted">Close your active shift using the current server time.</p>
                        <form method="POST" action="{{ route('employee.clock-out') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="employee_password" maxlength="6" inputmode="numeric" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Clock Out</button>
                        </form>
                    @else
                        <h2 class="h4 mb-3">Clock In</h2>
                        <p class="text-muted">Server time will be used when you submit this punch.</p>
                        <form method="POST" action="{{ route('employee.clock-in') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="employee_password" maxlength="6" inputmode="numeric" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Clock In</button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-panel">
                    <h2 class="h4 mb-3">Current Shift</h2>
                    @if($openAttendanceRecord)
                        <p class="text-muted mb-2">You are currently checked in.</p>
                        <div class="fw-semibold">{{ $openAttendanceRecord->clock_in_at->format('M d, Y H:i') }}</div>
                        <div class="small text-muted mt-2">Only clock out is available until this shift is closed.</div>
                    @else
                        <p class="text-muted mb-2">You are currently checked out.</p>
                        <div class="fw-semibold">Ready for a new shift</div>
                        <div class="small text-muted mt-2">Only clock in is available right now.</div>
                    @endif
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-panel">
                    <h2 class="h4 mb-3">Password Reset</h2>
                    <p class="text-muted">A new password will be emailed immediately after confirmation.</p>
                    <form method="POST" action="{{ route('employee.reset-password') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="employee_password" maxlength="6" inputmode="numeric" class="form-control" required {{ $canResetPassword ? '' : 'disabled' }}>
                        </div>
                        <button type="submit" class="btn btn-dark w-100" {{ $canResetPassword ? '' : 'disabled' }}>Email New Password</button>
                    </form>
                    @unless($canResetPassword)
                        <div class="small text-danger mt-2">Reset is disabled because your email is missing or invalid.</div>
                    @endunless
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card-panel">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="h4 mb-0">Recent Attendance</h2>
                        <span class="text-muted small">Latest 10 records</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Clock In</th>
                                    <th>Clock Out</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceRecords as $record)
                                    <tr>
                                        <td>{{ $record->clock_in_at->format('M d, Y H:i') }}</td>
                                        <td>{{ $record->clock_out_at?->format('M d, Y H:i') ?? 'Open' }}</td>
                                        <td>
                                            <span class="badge {{ $record->clock_out_at ? 'text-bg-secondary' : 'text-bg-warning' }}">
                                                {{ $record->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No attendance records yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-panel">
                    <h2 class="h4 mb-3">Employee Code</h2>
                    <p class="text-muted mb-2">Your employee code can only be changed by an administrator.</p>
                    <div class="fw-semibold">{{ $employee->employee_code }}</div>
                    <div class="small text-muted mt-2">Contact admin if your code needs to be updated.</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
