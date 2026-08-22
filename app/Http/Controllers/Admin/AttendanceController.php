<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceRecord;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        [$records, $employees] = $this->buildQuery($request);

        return view('admin.attendance.index', [
            'records' => $records->paginate(20)->withQueryString(),
            'employees' => $employees,
            'filters' => $request->only(['employee_id', 'date_from', 'date_to']),
        ]);
    }

    public function export(Request $request)
    {
        [$records] = $this->buildQuery($request);

        $filename = 'attendance-' . now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($records) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Employee', 'Code', 'Clock In', 'Clock Out', 'Status']);

            foreach ($records->get() as $record) {
                fputcsv($handle, [
                    $record->employee->name,
                    $record->employee->employee_code,
                    optional($record->clock_in_at)->format('Y-m-d H:i:s'),
                    optional($record->clock_out_at)->format('Y-m-d H:i:s'),
                    $record->status,
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    protected function buildQuery(Request $request): array
    {
        $records = AttendanceRecord::with('employee')
            ->orderByDesc('clock_in_at');

        if ($request->filled('employee_id')) {
            $records->where('employee_id', $request->integer('employee_id'));
        }

        if ($request->filled('date_from')) {
            $records->where('clock_in_at', '>=', Carbon::parse($request->string('date_from')->toString())->startOfDay());
        }

        if ($request->filled('date_to')) {
            $records->where('clock_in_at', '<=', Carbon::parse($request->string('date_to')->toString())->endOfDay());
        }

        return [$records, Employee::orderBy('name')->get()];
    }
}
