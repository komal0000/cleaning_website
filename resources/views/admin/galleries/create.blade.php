@extends('admin.layouts.app')

@section('title', 'Add Gallery Item')
@section('page-title', 'Gallery')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Add Gallery Item',
        'description' => 'Create a new before/after showcase for the gallery page.',
    ])

    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Details</div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="service_id" class="form-label">Service <span class="text-danger">*</span></label>
                        <select class="form-select @error('service_id') is-invalid @enderror"
                                id="service_id" name="service_id" required>
                            <option value="">Select a service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                    {{ $service->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror"
                               id="location" name="location" value="{{ old('location') }}">
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="completion_date" class="form-label">Completion Date</label>
                        <input type="date" class="form-control @error('completion_date') is-invalid @enderror"
                               id="completion_date" name="completion_date" value="{{ old('completion_date') }}">
                        @error('completion_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="position" class="form-label">Position</label>
                        <input type="number" class="form-control @error('position') is-invalid @enderror"
                               id="position" name="position" value="{{ old('position', 0) }}" min="0">
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" role="switch" id="is_featured"
                                   name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="is_featured">Featured Gallery Item</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" role="switch" id="status"
                                   name="status" value="1" {{ old('status', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="status">Active Status</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">YouTube Videos</div>
            <div class="card-body">
                <div id="youtube-videos-container">
                    <div class="youtube-video-item border rounded p-3 mb-3">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <input type="url" class="form-control @error('youtube_videos.0') is-invalid @enderror"
                                       name="youtube_videos[]" placeholder="Paste YouTube video URL here">
                                @error('youtube_videos.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="video_captions[]"
                                       placeholder="Caption (optional)">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-youtube-video">
                    <i data-lucide="plus"></i> Add Another YouTube Video
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Before Images <span class="text-danger">*</span></div>
            <div class="card-body">
                <div id="before-images-container">
                    <div class="before-image-item border rounded p-3 mb-3">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <input type="file" class="form-control @error('before_images.0') is-invalid @enderror"
                                       name="before_images[]" accept="image/*" required>
                                @error('before_images.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="before_captions[]"
                                       placeholder="Caption (optional)">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-before-image">
                    <i data-lucide="plus"></i> Add Another Before Image
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">After Images <span class="text-danger">*</span></div>
            <div class="card-body">
                <div id="after-images-container">
                    <div class="after-image-item border rounded p-3 mb-3">
                        <div class="row g-3">
                            <div class="col-md-7">
                                <input type="file" class="form-control @error('after_images.0') is-invalid @enderror"
                                       name="after_images[]" accept="image/*" required>
                                @error('after_images.0')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-5">
                                <input type="text" class="form-control" name="after_captions[]"
                                       placeholder="Caption (optional)">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-after-image">
                    <i data-lucide="plus"></i> Add Another After Image
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('galleries.index') }}" class="btn btn-light">Back to Gallery</a>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save"></i> Create Gallery Item
            </button>
        </div>
    </form>
@endsection

@section('script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let beforeImageIndex = 1;
    let afterImageIndex = 1;
    let youtubeVideoIndex = 1;

    document.getElementById('add-youtube-video').addEventListener('click', function() {
        const container = document.getElementById('youtube-videos-container');
        const newItem = document.createElement('div');
        newItem.className = 'youtube-video-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3 align-items-center">
                <div class="col-md-7">
                    <input type="url" class="form-control" name="youtube_videos[]" placeholder="Paste YouTube video URL here">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="video_captions[]" placeholder="Caption (optional)">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-video">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        youtubeVideoIndex++;
    });

    document.getElementById('add-before-image').addEventListener('click', function() {
        const container = document.getElementById('before-images-container');
        const newItem = document.createElement('div');
        newItem.className = 'before-image-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3 align-items-center">
                <div class="col-md-7">
                    <input type="file" class="form-control" name="before_images[]" accept="image/*" required>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="before_captions[]" placeholder="Caption (optional)">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-image">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        beforeImageIndex++;
    });

    document.getElementById('add-after-image').addEventListener('click', function() {
        const container = document.getElementById('after-images-container');
        const newItem = document.createElement('div');
        newItem.className = 'after-image-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3 align-items-center">
                <div class="col-md-7">
                    <input type="file" class="form-control" name="after_images[]" accept="image/*" required>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="after_captions[]" placeholder="Caption (optional)">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-image">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        afterImageIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-image') || e.target.closest('.remove-image')) {
            const item = e.target.closest('.before-image-item, .after-image-item');
            item.remove();
        }
        if (e.target.classList.contains('remove-video') || e.target.closest('.remove-video')) {
            const item = e.target.closest('.youtube-video-item');
            item.remove();
        }
    });
});
</script>
@endsection
