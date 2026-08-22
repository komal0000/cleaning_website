@extends('admin.layouts.app')

@section('title', 'Attendance')
@section('page-title', 'Attendance')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Attendance Logs',
        'description' => 'Filter, review, and export employee attendance.',
        'actions' => '<a href="' . route('admin.attendance.export', request()->query()) . '" class="btn btn-primary"><i data-lucide="download"></i> Export CSV</a>',
    ])

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.attendance.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Employee</label>
                    <select name="employee_id" class="form-select">
                        <option value="">All employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ (string) ($filters['employee_id'] ?? '') === (string) $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }} ({{ $employee->employee_code }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">From</label>
                    <input type="date" name="date_from" class="form-control" value="{{ $filters['date_from'] ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">To</label>
                    <input type="date" name="date_to" class="form-control" value="{{ $filters['date_to'] ?? '' }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Apply</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Code</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                        <tr>
                            <td class="fw-semibold">{{ $record->employee->name }}</td>
                            <td><span class="badge bg-secondary">{{ $record->employee->employee_code }}</span></td>
                            <td>{{ $record->clock_in_at->format('M d, Y H:i') }}</td>
                            <td>{{ $record->clock_out_at?->format('M d, Y H:i') ?? 'Open' }}</td>
                            <td><span class="badge bg-info">{{ $record->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="admin-empty">
                                    <i data-lucide="clock"></i>
                                    <h3>No attendance records found</h3>
                                    <p>Try adjusting the filters above.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($records->hasPages())
            <div class="card-body d-flex justify-content-center border-top">
                {{ $records->links() }}
            </div>
        @endif
    </div>
@endsection
