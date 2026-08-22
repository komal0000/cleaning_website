@extends('admin.layouts.app')

@section('title', $gallery->title)
@section('page-title', 'Gallery')

@section('content')
    @include('admin.partials.page-header', [
        'title' => $gallery->title,
        'description' => 'Gallery item details and media.',
        'actions' => '<a href="' . route('galleries.edit', $gallery->id) . '" class="btn btn-primary"><i data-lucide="pencil"></i> Edit Gallery</a>'
            . '<a href="' . route('galleries.index') . '" class="btn btn-light"><i data-lucide="arrow-left"></i> Back to Gallery</a>',
    ])

    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-2" style="color: var(--blue);"><i data-lucide="images"></i></div>
                    <h6 class="text-muted mb-1">Before Images</h6>
                    <h4 class="mb-0">{{ $gallery->beforeImages->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-2" style="color: var(--success);"><i data-lucide="images"></i></div>
                    <h6 class="text-muted mb-1">After Images</h6>
                    <h4 class="mb-0">{{ $gallery->afterImages->count() }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-2" style="color: var(--warning);"><i data-lucide="star"></i></div>
                    <h6 class="text-muted mb-1">Featured</h6>
                    <span class="badge {{ $gallery->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                        {{ $gallery->is_featured ? 'Yes' : 'No' }}
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card h-100">
                <div class="card-body text-center">
                    <div class="mb-2" style="color: {{ $gallery->status ? 'var(--success)' : 'var(--danger)' }};"><i data-lucide="{{ $gallery->status ? 'check-circle' : 'x-circle' }}"></i></div>
                    <h6 class="text-muted mb-1">Status</h6>
                    <span class="badge {{ $gallery->status ? 'bg-success' : 'bg-danger' }}">
                        {{ $gallery->status ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">Before Images ({{ $gallery->beforeImages->count() }})</div>
                <div class="card-body">
                    @if($gallery->beforeImages->count() > 0)
                        <div class="row g-3">
                            @foreach($gallery->beforeImages as $image)
                            <div class="col-md-6 col-sm-12">
                                <div class="position-relative overflow-hidden rounded border">
                                    <img src="{{ asset($image->image_path) }}" alt="Before Image"
                                         class="img-fluid w-100" style="height: 200px; object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal" data-bs-target="#imageModal"
                                         onclick="showImageModal('{{ asset($image->image_path) }}', '{{ $image->caption ?? 'Before Image' }}')">
                                    @if($image->caption)
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2">
                                            <small>{{ $image->caption }}</small>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-primary">Before</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="admin-empty">
                            <i data-lucide="image"></i>
                            <p>No before images available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">After Images ({{ $gallery->afterImages->count() }})</div>
                <div class="card-body">
                    @if($gallery->afterImages->count() > 0)
                        <div class="row g-3">
                            @foreach($gallery->afterImages as $image)
                            <div class="col-md-6 col-sm-12">
                                <div class="position-relative overflow-hidden rounded border">
                                    <img src="{{ asset($image->image_path) }}" alt="After Image"
                                         class="img-fluid w-100" style="height: 200px; object-fit: cover; cursor: pointer;"
                                         data-bs-toggle="modal" data-bs-target="#imageModal"
                                         onclick="showImageModal('{{ asset($image->image_path) }}', '{{ $image->caption ?? 'After Image' }}')">
                                    @if($image->caption)
                                        <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2">
                                            <small>{{ $image->caption }}</small>
                                        </div>
                                    @endif
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-success">After</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="admin-empty">
                            <i data-lucide="image"></i>
                            <p>No after images available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">Gallery Details</div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Title</dt>
                        <dd class="col-sm-8">{{ $gallery->title }}</dd>

                        <dt class="col-sm-4">Service</dt>
                        <dd class="col-sm-8">{{ $gallery->service->name ?? 'N/A' }}</dd>

                        <dt class="col-sm-4">Location</dt>
                        <dd class="col-sm-8">{{ $gallery->location ?? 'Not specified' }}</dd>

                        <dt class="col-sm-4">Completion Date</dt>
                        <dd class="col-sm-8">{{ $gallery->completion_date ? $gallery->completion_date->format('M d, Y') : 'Not specified' }}</dd>
                    </dl>
                </div>
                <div class="col-lg-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Position</dt>
                        <dd class="col-sm-8">{{ $gallery->position }}</dd>

                        <dt class="col-sm-4">Featured</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ $gallery->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                {{ $gallery->is_featured ? 'Yes' : 'No' }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Status</dt>
                        <dd class="col-sm-8">
                            <span class="badge {{ $gallery->status ? 'bg-success' : 'bg-danger' }}">
                                {{ $gallery->status ? 'Active' : 'Inactive' }}
                            </span>
                        </dd>

                        <dt class="col-sm-4">Created</dt>
                        <dd class="col-sm-8">{{ $gallery->created_at->format('M d, Y H:i') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @if($gallery->videos->count() > 0)
    <div class="card mb-4">
        <div class="card-header">YouTube Videos ({{ $gallery->videos->count() }})</div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($gallery->videos as $video)
                <div class="col-md-6 col-sm-12">
                    <div class="position-relative overflow-hidden rounded border">
                        @if($video->thumbnail_url)
                            <img src="{{ $video->thumbnail_url }}" alt="Video Thumbnail"
                                 class="img-fluid w-100" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-dark d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i class="fab fa-youtube fa-3x text-white"></i>
                            </div>
                        @endif

                        <div class="position-absolute top-50 start-50 translate-middle">
                            <a href="{{ $video->video_url }}" target="_blank" rel="noopener"
                               class="btn btn-danger btn-lg rounded-circle">
                                <i class="fas fa-play"></i>
                            </a>
                        </div>

                        @if($video->caption)
                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2">
                                <small>{{ $video->caption }}</small>
                            </div>
                        @endif

                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-danger">
                                <i class="fab fa-youtube me-1"></i>YouTube
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    @if($gallery->description)
    <div class="card">
        <div class="card-header">Description</div>
        <div class="card-body">
            <p class="mb-0" style="line-height: 1.7;">{{ $gallery->description }}</p>
        </div>
    </div>
    @endif

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <img id="modalImage" src="" alt="Image Preview" class="img-fluid w-100">
            </div>
            <div class="modal-footer border-0">
                <p id="modalCaption" class="mb-0 text-muted"></p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function showImageModal(imageSrc, caption) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalCaption').textContent = caption;
}
</script>
@endsection
