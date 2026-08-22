@extends('admin.layouts.app')

@section('title', 'Create User')
@section('page-title', 'Users')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Create New User',
        'description' => 'Add a new admin user to the system.',
    ])

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required placeholder="Enter full name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="Enter email address">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="role">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required placeholder="Enter secure password">
                            <div class="form-text">At least 8 characters with uppercase, lowercase, number, and special character.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Confirm password">
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-light">Back to Users</a>
                            <button type="submit" class="btn btn-primary"><i data-lucide="user-plus"></i> Create User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">Password Requirements</div>
                <div class="card-body">
                    <ul class="mb-0 ps-3 text-muted" style="line-height: 1.9; font-size: .88rem;">
                        <li><strong>At least 8 characters</strong></li>
                        <li><strong>One uppercase letter</strong> (A-Z)</li>
                        <li><strong>One lowercase letter</strong> (a-z)</li>
                        <li><strong>One number</strong> (0-9)</li>
                        <li><strong>One special character</strong> (@$!%*?&amp;)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
