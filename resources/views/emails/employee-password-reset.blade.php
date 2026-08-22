<p>Hello {{ $employee->name }},</p>

@if($initiatedByAdmin)
<p>An administrator has reset your employee password.</p>
@else
<p>Your employee password reset request has been completed.</p>
@endif

<p>Your new employee password is: <strong>{{ $newPassword }}</strong></p>
<p>Use your employee code together with this password to access your panel.</p>
