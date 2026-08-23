@extends('admin.layouts.app')

@section('title', 'Employees')
@section('page-title', 'Employees')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Employees',
        'description' => 'Manage employee access credentials and status.',
        'actions' => '<a href="' . route('admin.employees.create') . '" class="btn btn-primary"><i data-lucide="plus"></i> Add Employee</a>',
    ])

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Reset</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $employee)
                        <tr>
                            <td class="fw-semibold">{{ $employee->name }}</td>
                            <td><span class="badge bg-secondary">{{ $employee->employee_code }}</span></td>
                            <td>{{ $employee->email ?: 'Not set' }}</td>
                            <td>
                                <span class="badge {{ $employee->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $employee->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('admin.employees.reset-password', $employee) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light" {{ $employee->hasValidEmail() ? '' : 'disabled' }}>
                                        <i data-lucide="mail"></i> Email New Password
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-sm btn-light"><i data-lucide="pencil"></i> Edit</a>
                                    <form method="POST" action="{{ route('admin.employees.destroy', $employee) }}" onsubmit="return confirm('Delete this employee?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2"></i> Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="admin-empty">
                                    <i data-lucide="id-card"></i>
                                    <h3>No employees found</h3>
                                    <p>Add an employee to give them panel access.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($employees->hasPages())
            <div class="card-body d-flex justify-content-center border-top">
                {{ $employees->links() }}
            </div>
        @endif
    </div>
@endsection
