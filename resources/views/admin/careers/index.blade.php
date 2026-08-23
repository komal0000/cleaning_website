@extends('admin.layouts.app')

@section('title', 'Careers')
@section('page-title', 'Careers')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Career Opportunities',
        'description' => 'Open roles published on the careers page.',
        'actions' => '<a href="' . route('careers.create') . '" class="btn btn-primary"><i data-lucide="plus"></i> Add Career</a>',
    ])

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Location</th>
                        <th>Deadline</th>
                        <th>Description</th>
                        <th>Requirements</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($careers as $career)
                    <tr>
                        <td class="fw-semibold">{{ $career->title }}</td>
                        <td>{{ $career->location }}</td>
                        <td>{{ $career->deadline }}</td>
                        <td>{{ Str::limit($career->description, 60) }}</td>
                        <td>{{ Str::limit($career->requirement, 60) }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('careers.edit', $career->id) }}" class="btn btn-sm btn-light"><i data-lucide="pencil"></i> Edit</a>
                                <form action="{{ route('careers.destroy', $career->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this?')"><i data-lucide="trash-2"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="admin-empty">
                                <i data-lucide="briefcase"></i>
                                <h3>No open roles</h3>
                                <p>Publish a role to show it on the careers page.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
