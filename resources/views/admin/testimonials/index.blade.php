@extends('admin.layouts.app')

@section('title', 'Testimonials')
@section('page-title', 'Testimonials')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Testimonials',
        'description' => 'Client reviews shown on the testimonials page.',
        'actions' => '<a href="' . route('testimonials.create') . '" class="btn btn-primary"><i data-lucide="plus"></i> Add New Testimonial</a>',
    ])

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Location</th>
                        <th>Service</th>
                        <th>Message</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                    <tr>
                        <td>
                            @if($testimonial->photo)
                                <img src="{{ asset($testimonial->photo) }}" alt="{{ $testimonial->name }}" class="table-thumb">
                            @else
                                <span class="text-muted small">No photo</span>
                            @endif
                        </td>
                        <td class="fw-semibold">{{ $testimonial->name }}</td>
                        <td>{{ $testimonial->position }}</td>
                        <td>{{ $testimonial->service }}</td>
                        <td>{{ Str::limit($testimonial->message, 60) }}</td>
                        <td>
                            <div class="table-actions">
                                <a href="{{ route('testimonials.edit', $testimonial->id) }}" class="btn btn-sm btn-light"><i data-lucide="pencil"></i> Edit</a>
                                <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this testimonial?')"><i data-lucide="trash-2"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="admin-empty">
                                <i data-lucide="star"></i>
                                <h3>No testimonials yet</h3>
                                <p>Add a client review to show it on the testimonials page.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
