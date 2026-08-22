@extends('admin.layouts.app')

@section('title', 'Change Password')
@section('page-title', 'Settings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Change Password',
        'description' => 'Update your account password for better security.',
    ])

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.settings.change-password.update') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label" for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                required placeholder="Enter your current password">
                            @error('current_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="new_password">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                required placeholder="Enter your new password (min. 8 characters)">
                            @error('new_password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                            <div class="form-text">At least 8 characters with uppercase, lowercase, number, and special character.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation"
                                required placeholder="Confirm your new password">
                            @error('new_password_confirmation')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.settings.index') }}" class="btn btn-light">Back to Settings</a>
                            <button type="submit" class="btn btn-primary">
                                <i data-lucide="key-round"></i> Update Password
                            </button>
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
                        <li>Different from your current password</li>
                        <li>Avoid using personal information</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newPasswordInput = document.querySelector('input[name="new_password"]');
    const confirmPasswordInput = document.querySelector('input[name="new_password_confirmation"]');

    if (newPasswordInput) {
        const strengthIndicator = document.createElement('div');
        strengthIndicator.style.cssText = 'margin-top: 8px; height: 4px; background: var(--border); border-radius: 2px; overflow: hidden;';
        strengthIndicator.innerHTML = '<div style="height: 100%; width: 0%; transition: width 0.3s;"></div>';
        newPasswordInput.parentNode.insertBefore(strengthIndicator, newPasswordInput.nextSibling);

        const strengthBar = strengthIndicator.querySelector('div');
        newPasswordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            let checks = 0;

            if (password.length >= 8) { strength += 20; checks++; }
            if (/[a-z]/.test(password)) { strength += 20; checks++; }
            if (/[A-Z]/.test(password)) { strength += 20; checks++; }
            if (/[0-9]/.test(password)) { strength += 20; checks++; }
            if (/[@$!%*?&]/.test(password)) { strength += 20; checks++; }

            strengthBar.style.width = strength + '%';

            if (checks < 3) {
                strengthBar.style.background = 'var(--danger)';
            } else if (checks < 5) {
                strengthBar.style.background = 'var(--warning)';
            } else {
                strengthBar.style.background = 'var(--success)';
            }
        });
    }

    if (confirmPasswordInput && newPasswordInput) {
        confirmPasswordInput.addEventListener('input', function() {
            this.style.borderColor = this.value !== newPasswordInput.value ? 'var(--danger)' : 'var(--success)';
        });
    }
});
</script>
@endpush
