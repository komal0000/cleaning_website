@extends('admin.layouts.app')

@section('title', 'Career Applications')
@section('page-title', 'Applications')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Career Applications',
        'description' => 'Applications submitted through the careers page.',
        'actions' => '<span class="badge bg-primary align-self-center">' . $applications->count() . ' Applications</span>',
    ])

    <div class="card">
        @if($applications->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Applicant</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Experience</th>
                            <th>Resume</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr>
                            <td><small class="text-muted">{{ $loop->iteration }}</small></td>
                            <td class="fw-semibold">{{ $application->full_name }}</td>
                            <td>
                                <a href="mailto:{{ $application->email }}" class="text-decoration-none">
                                    {{ $application->email }}
                                </a>
                            </td>
                            <td>
                                <a href="tel:{{ $application->phone }}" class="text-decoration-none">
                                    {{ $application->phone }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $application->position }}</span>
                            </td>
                            <td>
                                @if($application->experience)
                                    {{ $application->experience }}
                                @else
                                    <span class="text-muted">Not specified</span>
                                @endif
                            </td>
                            <td>
                                @if($application->resume_path)
                                    <a href="{{ route('admin.career-applications.download-resume', $application->id) }}"
                                       class="btn btn-sm btn-light" title="Download Resume">
                                        <i data-lucide="download"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">No resume</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.career-applications.show', $application->id) }}"
                                       class="btn btn-sm btn-light" title="View Details">
                                        <i data-lucide="eye"></i>
                                    </a>
                                    <form action="{{ route('admin.career-applications.destroy', $application->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Are you sure you want to delete this application?')"
                                                class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="admin-empty">
                <i data-lucide="file-text"></i>
                <h3>No applications yet</h3>
                <p>Career applications will appear here when submitted from the frontend.</p>
            </div>
        @endif
    </div>
@endsection
