@extends('admin.layouts.app')

@section('title', 'Services')
@section('page-title', 'Services')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Services',
        'description' => 'Services listed on the public website.',
        'actions' => '<a href="' . route('services.create') . '" class="btn btn-primary"><i data-lucide="plus"></i> Add New Service</a>',
    ])

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Icon</th>
                        <th>Logo</th>
                        <th>Feature Image</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Features</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr>
                        <td><span class="badge bg-secondary">{{ $service->position }}</span></td>
                        <td><i data-lucide="{{ $service->icon }}"></i></td>
                        <td>
                            @if($service->logo)
                                <img src="{{ asset($service->logo) }}" alt="Logo" class="table-thumb">
                            @else
                                <span class="text-muted small">No logo</span>
                            @endif
                        </td>
                        <td>
                            @if($service->feature_image)
                                <img src="{{ asset($service->feature_image) }}" alt="Feature Image" class="table-thumb">
                            @else
                                <span class="text-muted small">No image</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $service->title }}</td>
                        <td>{{ Str::limit($service->description, 50) }}</td>
                        <td>{{ Str::limit($service->features, 50) }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('services.edit', $service->id) }}" class="btn btn-sm btn-light"><i data-lucide="pencil"></i> Edit</a>
                                <form action="{{ route('services.destroy', $service->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this service?')" class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="admin-empty">
                                <i data-lucide="spray-can"></i>
                                <h3>No services yet</h3>
                                <p>Add your first service to list it on the website.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
