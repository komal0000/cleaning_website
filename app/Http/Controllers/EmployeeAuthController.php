<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class EmployeeAuthController extends Controller
{
    public function showLoginForm(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('employee_id')) {
            return redirect()->route('employee.panel');
        }

        return view('employee.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'employee_code' => ['required', 'digits:4'],
            'employee_password' => ['required', 'digits:6'],
        ]);

        $employee = Employee::where('employee_code', $credentials['employee_code'])
            ->where('is_active', true)
            ->first();

        if (!$employee || !Hash::check($credentials['employee_password'], $employee->employee_password)) {
            return back()
                ->withErrors(['employee_code' => 'The provided employee credentials are invalid.'])
                ->onlyInput('employee_code');
        }

        $request->session()->regenerate();
        $request->session()->put('employee_id', $employee->id);

        return redirect()->route('employee.panel');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('employee_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('employee.login');
    }
}
