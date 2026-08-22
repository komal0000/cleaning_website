@extends('admin.layouts.app')

@section('title', 'Gallery')
@section('page-title', 'Gallery')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Gallery Management',
        'description' => 'Before/after photos shown on the public gallery page.',
        'actions' => '<a href="' . route('galleries.create') . '" class="btn btn-primary"><i data-lucide="plus"></i> Add Gallery Item</a>',
    ])

    <div class="card">
        @if ($galleries->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Before</th>
                            <th>After</th>
                            <th>Title</th>
                            <th>Service</th>
                            <th>Location</th>
                            <th>Featured</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($galleries as $gallery)
                            <tr>
                                <td>
                                    @if ($gallery->firstBeforeImage)
                                        <img src="{{ asset($gallery->firstBeforeImage->image_path) }}" alt="Before" class="table-thumb">
                                        @if ($gallery->beforeImages->count() > 1)
                                            <small class="text-muted d-block">+{{ $gallery->beforeImages->count() - 1 }} more</small>
                                        @endif
                                    @else
                                        <span class="text-muted small">No image</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($gallery->firstAfterImage)
                                        <img src="{{ asset($gallery->firstAfterImage->image_path) }}" alt="After" class="table-thumb">
                                        @if ($gallery->afterImages->count() > 1)
                                            <small class="text-muted d-block">+{{ $gallery->afterImages->count() - 1 }} more</small>
                                        @endif
                                    @else
                                        <span class="text-muted small">No image</span>
                                    @endif
                                </td>
                                <td class="fw-semibold">{{ $gallery->title }}</td>
                                <td>{{ $gallery->service->name ?? 'N/A' }}</td>
                                <td>{{ $gallery->location ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $gallery->is_featured ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $gallery->is_featured ? 'Featured' : 'Regular' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $gallery->status ? 'bg-success' : 'bg-danger' }}">
                                        {{ $gallery->status ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a href="{{ route('galleries.show', $gallery->id) }}" class="btn btn-sm btn-light"><i data-lucide="eye"></i> Detail</a>
                                        <a href="{{ route('galleries.edit', $gallery->id) }}" class="btn btn-sm btn-light"><i data-lucide="pencil"></i> Edit</a>
                                        <form action="{{ route('galleries.destroy', $gallery->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this gallery item?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i data-lucide="trash-2"></i> Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-body d-flex justify-content-center border-top">
                {{ $galleries->links() }}
            </div>
        @else
            <div class="admin-empty">
                <i data-lucide="image"></i>
                <h3>No gallery items found</h3>
                <p class="mb-3">Add before/after photos to showcase your work.</p>
                <a href="{{ route('galleries.create') }}" class="btn btn-primary"><i data-lucide="plus"></i> Add First Gallery Item</a>
            </div>
        @endif
    </div>
@endsection
