@extends('admin.layouts.app')

@section('title', 'Edit Service')
@section('page-title', 'Services')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Edit Service',
        'description' => $service->title,
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-8">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $service->title) }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="position">Position</label>
                        <input type="number" id="position" name="position" value="{{ old('position', $service->position) }}" class="form-control" min="0" required>
                        <div class="form-text">Displayed in ascending order (0, 1, 2, ...).</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="icon">Icon <span class="form-text d-inline">(Lucide icon name, e.g. <code>broom</code>)</span></label>
                        <input type="text" id="icon" name="icon" value="{{ old('icon', $service->icon) }}" class="form-control">
                        <div class="form-text">See <a href="https://lucide.dev/icons/" target="_blank" rel="noopener">Lucide Icons</a> for available icon names.</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', $service->description) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="logo">Logo Image</label>
                        <input type="file" id="logo" name="logo" class="dropify" accept="image/*"
                               data-height="160"
                               @if($service->logo) data-default-file="{{ asset($service->logo) }}" @endif>
                        <div class="form-text">Upload a new logo to replace the current one (optional).</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="feature_image">Feature Image</label>
                        <input type="file" id="feature_image" name="feature_image" class="dropify" accept="image/*"
                               data-height="160"
                               @if($service->feature_image) data-default-file="{{ asset($service->feature_image) }}" @endif>
                        <div class="form-text">Upload a new feature image to replace the current one (optional).</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="features">Features <span class="form-text d-inline">(use | between features)</span></label>
                        <textarea id="features" name="features" class="form-control" rows="4">{{ old('features', $service->features) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('services.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Update Service</button>
                </div>
            </form>
        </div>
    </div>
@endsection
