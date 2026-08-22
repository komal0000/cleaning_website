<?php

namespace App\Http\Middleware;

use App\Models\Employee;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEmployeeAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        $employeeId = $request->session()->get('employee_id');

        if (!$employeeId) {
            return redirect()->route('employee.login');
        }

        $employee = Employee::find($employeeId);

        if (!$employee || !$employee->is_active) {
            $request->session()->forget('employee_id');

            return redirect()->route('employee.login')
                ->withErrors(['employee_code' => 'Your employee session is no longer valid.']);
        }

        $request->attributes->set('employee', $employee);

        return $next($request);
    }
}
