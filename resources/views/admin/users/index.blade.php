@extends('admin.layouts.app')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'User Management',
        'description' => 'Manage admin users and their permissions.',
        'actions' => '<a href="' . route('admin.users.create') . '" class="btn btn-primary"><i data-lucide="plus"></i> Add New User</a>',
    ])

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="text-muted">#{{ $user->id }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="admin-avatar" style="display:grid;width:34px;height:34px;place-items:center;color:var(--white);background:var(--blue);border-radius:50%;font-size:.8rem;font-weight:800;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </span>
                                <span class="fw-semibold">{{ $user->name }}</span>
                                @if($user->id === auth()->id())
                                    <span class="badge bg-success">You</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'super_admin')
                                <span class="badge bg-warning">Super Admin</span>
                            @else
                                <span class="badge bg-info">Admin</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-light"><i data-lucide="pencil"></i> Edit</a>
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2"></i> Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="admin-empty">
                                <i data-lucide="user-cog"></i>
                                <h3>No users found</h3>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="card-body d-flex justify-content-center border-top">
            {{ $users->links() }}
        </div>
        @endif
    </div>
@endsection
