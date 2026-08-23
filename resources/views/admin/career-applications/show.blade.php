@extends('admin.layouts.app')

@section('title', 'Application Details')
@section('page-title', 'Applications')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Application from ' . $careerApplication->full_name,
        'description' => 'Applied ' . $careerApplication->created_at->diffForHumans() . '.',
        'actions' => '<a href="' . route('admin.career-applications.index') . '" class="btn btn-light"><i data-lucide="arrow-left"></i> Back to Applications</a>',
    ])

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Application Details</div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-3">Full Name</dt>
                        <dd class="col-sm-9">{{ $careerApplication->full_name }}</dd>

                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9">
                            <a href="mailto:{{ $careerApplication->email }}" class="text-decoration-none">
                                {{ $careerApplication->email }}
                            </a>
                        </dd>

                        <dt class="col-sm-3">Phone</dt>
                        <dd class="col-sm-9">
                            <a href="tel:{{ $careerApplication->phone }}" class="text-decoration-none">
                                {{ $careerApplication->phone }}
                            </a>
                        </dd>

                        <dt class="col-sm-3">Position</dt>
                        <dd class="col-sm-9">
                            <span class="badge bg-info">{{ $careerApplication->position }}</span>
                        </dd>

                        <dt class="col-sm-3">Experience</dt>
                        <dd class="col-sm-9">
                            @if($careerApplication->experience)
                                {{ $careerApplication->experience }}
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Availability</dt>
                        <dd class="col-sm-9">
                            @if($careerApplication->availability)
                                {{ $careerApplication->availability }}
                            @else
                                <span class="text-muted">Not specified</span>
                            @endif
                        </dd>

                        <dt class="col-sm-3">Application Date</dt>
                        <dd class="col-sm-9">{{ $careerApplication->created_at->format('F d, Y \a\t h:i A') }}</dd>

                        @if($careerApplication->cover_letter)
                            <dt class="col-sm-3">Cover Letter</dt>
                            <dd class="col-sm-9">
                                <div class="p-3 rounded" style="background: var(--cloud);">
                                    {!! nl2br(e($careerApplication->cover_letter)) !!}
                                </div>
                            </dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Actions</div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $careerApplication->email }}" class="btn btn-primary">
                            <i data-lucide="reply"></i> Contact via Email
                        </a>

                        <a href="tel:{{ $careerApplication->phone }}" class="btn btn-success">
                            <i data-lucide="phone"></i> Call Applicant
                        </a>

                        @if($careerApplication->resume_path)
                            <a href="{{ route('admin.career-applications.download-resume', $careerApplication->id) }}"
                               class="btn btn-light">
                                <i data-lucide="download"></i> Download Resume
                            </a>
                        @endif

                        <form action="{{ route('admin.career-applications.destroy', $careerApplication->id) }}"
                              method="POST" onsubmit="return confirm('Are you sure you want to delete this application?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i data-lucide="trash-2"></i> Delete Application
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Summary</div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Name:</strong> {{ $careerApplication->full_name }}</li>
                        <li class="mb-2"><strong>Position:</strong> {{ $careerApplication->position }}</li>
                        @if($careerApplication->experience)
                            <li class="mb-2"><strong>Experience:</strong> {{ $careerApplication->experience }}</li>
                        @endif
                        <li><strong>Applied:</strong> {{ $careerApplication->created_at->diffForHumans() }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
