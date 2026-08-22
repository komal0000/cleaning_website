<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRecord;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmployeePanelController extends Controller
{
    public function index(Request $request): View
    {
        /** @var Employee $employee */
        $employee = $request->attributes->get('employee');

        $attendanceRecords = $employee->attendanceRecords()
            ->latest('clock_in_at')
            ->limit(10)
            ->get();

        return view('employee.panel.index', [
            'employee' => $employee,
            'attendanceRecords' => $attendanceRecords,
            'openAttendanceRecord' => $employee->openAttendanceRecord(),
            'canResetPassword' => $employee->hasValidEmail(),
        ]);
    }

    public function clockIn(Request $request): RedirectResponse
    {
        $employee = $this->validateTransaction($request);

        if ($employee->openAttendanceRecord()) {
            return back()->withErrors(['clock_in' => 'You already have an open shift. Please clock out first.']);
        }

        AttendanceRecord::create([
            'employee_id' => $employee->id,
            'clock_in_at' => now(),
        ]);

        return redirect()->route('employee.panel')->with('success', 'Clock-in recorded successfully.');
    }

    public function clockOut(Request $request): RedirectResponse
    {
        $employee = $this->validateTransaction($request);
        $openRecord = $employee->openAttendanceRecord();

        if (!$openRecord) {
            return back()->withErrors(['clock_out' => 'There is no open shift to clock out from.']);
        }

        $openRecord->update([
            'clock_out_at' => now(),
        ]);

        return redirect()->route('employee.panel')->with('success', 'Clock-out recorded successfully.');
    }

    public function requestPasswordReset(Request $request): RedirectResponse
    {
        $employee = $this->validateTransaction($request);

        if (!$employee->hasValidEmail()) {
            return back()->withErrors(['reset_password' => 'A valid email is required for password reset.']);
        }

        $newPassword = $this->generatePassword();

        $employee->update([
            'employee_password' => Hash::make($newPassword),
        ]);

        $this->sendPasswordResetEmail($employee, $newPassword, false);

        return redirect()->route('employee.panel')->with('success', 'A new password has been emailed to you.');
    }

    protected function validateTransaction(Request $request, array $rules = []): Employee
    {
        $data = $request->validate(array_merge([
            'employee_password' => ['required', 'digits:6'],
        ], $rules));

        /** @var Employee $employee */
        $employee = $request->attributes->get('employee');

        if (!Hash::check($data['employee_password'], $employee->employee_password)) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'employee_password' => 'Password confirmation failed.',
            ]);
        }

        return $employee;
    }

    public function generatePassword(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function sendPasswordResetEmail(Employee $employee, string $newPassword, bool $initiatedByAdmin): void
    {
        Mail::send('emails.employee-password-reset', [
            'employee' => $employee,
            'newPassword' => $newPassword,
            'initiatedByAdmin' => $initiatedByAdmin,
        ], function ($message) use ($employee, $initiatedByAdmin) {
            $message->to($employee->email);
            $message->subject($initiatedByAdmin
                ? 'Your employee password has been reset'
                : 'Your new employee password');
        });
    }
}
