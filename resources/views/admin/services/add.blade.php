@extends('admin.layouts.app')

@section('title', 'Add Service')
@section('page-title', 'Services')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Add Service',
        'description' => 'Create a new service for the public website.',
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-8">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="position">Position</label>
                        <input type="number" id="position" name="position" class="form-control" min="0" value="{{ old('position', 0) }}" required>
                        <div class="form-text">Displayed in ascending order (0, 1, 2, ...).</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="icon">Icon <span class="form-text d-inline">(Lucide icon name, e.g. <code>broom</code>)</span></label>
                        <input type="text" id="icon" name="icon" class="form-control" value="{{ old('icon') }}">
                        <div class="form-text">See <a href="https://lucide.dev/icons/" target="_blank" rel="noopener">Lucide Icons</a> for available icon names.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="logo">Logo Image</label>
                        <input type="file" id="logo" name="logo" class="dropify" accept="image/*" data-height="160">
                        <div class="form-text">Optional logo for this service.</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="feature_image">Feature Image</label>
                        <input type="file" id="feature_image" name="feature_image" class="dropify" accept="image/*" data-height="160">
                        <div class="form-text">Optional feature image for this service.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="features">Features <span class="form-text d-inline">(use | between features)</span></label>
                        <textarea id="features" name="features" class="form-control" rows="4">{{ old('features') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('services.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection
