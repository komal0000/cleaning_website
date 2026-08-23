@extends('admin.layouts.app')

@section('title', 'Team Members')
@section('page-title', 'Team Members')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Team Members',
        'description' => 'People shown on the public team page.',
        'actions' => '<a href="' . route('teams.create') . '" class="btn btn-primary"><i data-lucide="plus"></i> Add New</a>',
    ])

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Bio</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Experienced in</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teams as $team)
                    <tr>
                        <td>
                            @if($team->photo)
                                <img src="{{ asset($team->photo) }}" alt="{{ $team->name }}" class="table-thumb">
                            @else
                                <span class="text-muted small">No photo</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $team->name }}</td>
                        <td>{{ $team->position }}</td>
                        <td>{{ Str::limit($team->bio, 50) }}</td>
                        <td>{{ str_replace('|', ', ', $team->phone) }}</td>
                        <td>{{ str_replace('|', ', ', $team->email) }}</td>
                        <td>{{ str_replace('|', ', ', $team->experienced) }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-sm btn-light"><i data-lucide="pencil"></i> Edit</a>
                                <form action="{{ route('teams.destroy', $team->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this member?')" class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="admin-empty">
                                <i data-lucide="users"></i>
                                <h3>No team members yet</h3>
                                <p>Add your first team member to show them on the team page.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
