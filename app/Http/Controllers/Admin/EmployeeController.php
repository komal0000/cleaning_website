<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\EmployeePanelController;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        $employees = Employee::orderBy('name')->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    public function create(): View
    {
        return view('admin.employees.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employee_code' => ['required', 'digits:4', 'unique:employees,employee_code'],
            'employee_password' => ['required', 'digits:6', 'confirmed'],
            'email' => ['nullable', 'email', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Employee::create([
            'name' => $data['name'],
            'employee_code' => $data['employee_code'],
            'employee_password' => Hash::make($data['employee_password']),
            'email' => $data['email'] ?: null,
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        return redirect()->route('admin.employees.index')->with('success', 'Employee created successfully.');
    }

    public function edit(Employee $employee): View
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'employee_code' => ['required', 'digits:4', Rule::unique('employees', 'employee_code')->ignore($employee->id)],
            'email' => ['nullable', 'email', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
            'employee_password' => ['nullable', 'digits:6', 'confirmed'],
        ]);

        $employee->update([
            'name' => $data['name'],
            'employee_code' => $data['employee_code'],
            'email' => $data['email'] ?: null,
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);

        if (!empty($data['employee_password'])) {
            $employee->update([
                'employee_password' => Hash::make($data['employee_password']),
            ]);
        }

        return redirect()->route('admin.employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function resetPassword(Employee $employee, EmployeePanelController $employeePanelController): RedirectResponse
    {
        if (!$employee->hasValidEmail()) {
            return back()->withErrors(['reset_password' => 'Employee must have a valid email before resetting password by email.']);
        }

        $newPassword = $employeePanelController->generatePassword();

        $employee->update([
            'employee_password' => Hash::make($newPassword),
        ]);

        $employeePanelController->sendPasswordResetEmail($employee, $newPassword, true);

        return redirect()->route('admin.employees.index')->with('success', 'A new employee password has been emailed successfully.');
    }
}
