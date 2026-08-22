@extends('admin.layouts.app')

@section('title', 'Edit Employee')
@section('page-title', 'Employees')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Edit Employee',
        'description' => $employee->name,
    ])

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.employees.update', $employee) }}">
                @csrf
                @method('PUT')
                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $employee->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="employee_code">Employee Code</label>
                        <input type="text" id="employee_code" name="employee_code" maxlength="4" inputmode="numeric" class="form-control" value="{{ old('employee_code', $employee->employee_code) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $employee->email) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="employee_password">New Password</label>
                        <input type="password" id="employee_password" name="employee_password" maxlength="6" inputmode="numeric" class="form-control">
                        <div class="form-text">Leave blank to keep the current password.</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="employee_password_confirmation">Confirm New Password</label>
                        <input type="password" id="employee_password_confirmation" name="employee_password_confirmation" maxlength="6" inputmode="numeric" class="form-control">
                    </div>
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" id="is_active" class="form-check-input" role="switch" {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label fw-semibold">Active employee</label>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Update Employee</button>
                </div>
            </form>
        </div>
    </div>
@endsection
