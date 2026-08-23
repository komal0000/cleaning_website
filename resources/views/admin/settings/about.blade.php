@extends('admin.layouts.app')

@section('title', 'About Page Settings')
@section('page-title', 'Settings')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'About Page Settings',
        'description' => 'Hero section, statistics, values, and company story.',
    ])

    <form action="{{ route('admin.settings.about') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-body">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="use_image_in_about" id="use_image_in_about" value="1" {{ old('use_image_in_about', $useImageInAbout ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="use_image_in_about">Use Images in About Section</label>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">About Image List</div>
            <div class="card-body">
                <div class="row align-items-center g-3 mb-4">
                    <div class="col-auto">
                        <label class="form-label mb-0" for="about_image_per_line">Image Layout</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="about_image_per_line" name="about_image_per_line">
                            <option value="1" {{ (old('about_image_per_line', $aboutImagePerLine ?? 1) == 1) ? 'selected' : '' }}>Single (1 per line)</option>
                            <option value="2" {{ (old('about_image_per_line', $aboutImagePerLine ?? 1) == 2) ? 'selected' : '' }}>2x (2 per line)</option>
                            <option value="3" {{ (old('about_image_per_line', $aboutImagePerLine ?? 1) == 3) ? 'selected' : '' }}>3x (3 per line)</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <input type="file" id="about-image-upload" accept="image/*" class="form-control" style="max-width: 320px;">
                    <button type="button" class="btn btn-primary btn-sm" id="upload-about-image">Upload Image</button>
                    <span id="about-image-upload-status" class="small text-muted"></span>
                </div>

                <div id="about-image-list-container" class="mb-3">
                    @php $aboutImageList = old('about_image_list', $aboutImageList ?? []); @endphp
                    @foreach($aboutImageList as $idx => $img)
                        <div class="about-image-item d-flex align-items-center gap-2 mb-2">
                            <img src="{{ $img }}" alt="About Image" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;">
                            <input type="text" class="form-control" name="about_image_list[]" value="{{ $img }}" placeholder="Image URL...">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-about-image">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" id="add-about-image">
                    <i data-lucide="plus"></i> Add Image URL
                </button>
                <p class="form-text mt-2 mb-0">Paste image URLs or upload images and paste their links here.</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Hero Section</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="hero_title">Hero Title</label>
                    <input type="text" class="form-control" id="hero_title" name="hero_title"
                        value="{{ old('hero_title', $aboutData['hero_title'] ?? '') }}" placeholder="Why Choose Cleanway Service?">
                </div>
                <div>
                    <label class="form-label" for="hero_subtitle">Hero Subtitle</label>
                    <textarea class="form-control" id="hero_subtitle" name="hero_subtitle" rows="4"
                        placeholder="Describe your company's experience and commitment...">{{ old('hero_subtitle', $aboutData['hero_subtitle'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Statistics</div>
            <div class="card-body">
                <div id="stats-container">
                    @foreach($aboutData['stats'] ?? [] as $index => $stat)
                    <div class="stat-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Number/Value</label>
                                <input type="text" class="form-control" name="stats[{{ $index }}][number]" value="{{ $stat['number'] ?? '' }}" placeholder="15+" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Label</label>
                                <input type="text" class="form-control" name="stats[{{ $index }}][label]" value="{{ $stat['label'] ?? '' }}" placeholder="Years Experience" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Icon</label>
                                <select class="form-select" name="stats[{{ $index }}][icon]" required>
                                    <option value="calendar" {{ ($stat['icon'] ?? '') == 'calendar' ? 'selected' : '' }}>Calendar</option>
                                    <option value="users" {{ ($stat['icon'] ?? '') == 'users' ? 'selected' : '' }}>Users</option>
                                    <option value="user-check" {{ ($stat['icon'] ?? '') == 'user-check' ? 'selected' : '' }}>User Check</option>
                                    <option value="clock" {{ ($stat['icon'] ?? '') == 'clock' ? 'selected' : '' }}>Clock</option>
                                    <option value="star" {{ ($stat['icon'] ?? '') == 'star' ? 'selected' : '' }}>Star</option>
                                    <option value="award" {{ ($stat['icon'] ?? '') == 'award' ? 'selected' : '' }}>Award</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-stat">Remove</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-stat">
                    <i data-lucide="plus"></i> Add Statistic
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Key Features</div>
            <div class="card-body">
                <div id="features-container">
                    @foreach($aboutData['features'] ?? [] as $index => $feature)
                    <div class="feature-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label">Feature Title</label>
                                <input type="text" class="form-control" name="features[{{ $index }}][title]" value="{{ $feature['title'] ?? '' }}" placeholder="Fully Licensed & Insured" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Icon</label>
                                <select class="form-select" name="features[{{ $index }}][icon]" required>
                                    <option value="shield" {{ ($feature['icon'] ?? '') == 'shield' ? 'selected' : '' }}>Shield</option>
                                    <option value="user-check" {{ ($feature['icon'] ?? '') == 'user-check' ? 'selected' : '' }}>User Check</option>
                                    <option value="leaf" {{ ($feature['icon'] ?? '') == 'leaf' ? 'selected' : '' }}>Leaf</option>
                                    <option value="check-circle" {{ ($feature['icon'] ?? '') == 'check-circle' ? 'selected' : '' }}>Check Circle</option>
                                    <option value="calendar" {{ ($feature['icon'] ?? '') == 'calendar' ? 'selected' : '' }}>Calendar</option>
                                    <option value="dollar-sign" {{ ($feature['icon'] ?? '') == 'dollar-sign' ? 'selected' : '' }}>Dollar Sign</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-feature">Remove</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature">
                    <i data-lucide="plus"></i> Add Feature
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Company Values</div>
            <div class="card-body">
                <div id="values-container">
                    @foreach($aboutData['values'] ?? [] as $index => $value)
                    <div class="value-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">Value Title</label>
                                <input type="text" class="form-control" name="values[{{ $index }}][title]" value="{{ $value['title'] ?? '' }}" placeholder="Customer First" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label">Description</label>
                                <textarea class="form-control" rows="2" name="values[{{ $index }}][description]" placeholder="Your satisfaction is our top priority..." required>{{ $value['description'] ?? '' }}</textarea>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Icon</label>
                                <select class="form-select" name="values[{{ $index }}][icon]" required>
                                    <option value="heart" {{ ($value['icon'] ?? '') == 'heart' ? 'selected' : '' }}>Heart</option>
                                    <option value="award" {{ ($value['icon'] ?? '') == 'award' ? 'selected' : '' }}>Award</option>
                                    <option value="shield" {{ ($value['icon'] ?? '') == 'shield' ? 'selected' : '' }}>Shield</option>
                                    <option value="leaf" {{ ($value['icon'] ?? '') == 'leaf' ? 'selected' : '' }}>Leaf</option>
                                    <option value="star" {{ ($value['icon'] ?? '') == 'star' ? 'selected' : '' }}>Star</option>
                                    <option value="users" {{ ($value['icon'] ?? '') == 'users' ? 'selected' : '' }}>Users</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-value">Remove</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-value">
                    <i data-lucide="plus"></i> Add Value
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Company Story</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="story_title">Story Title</label>
                    <input type="text" class="form-control" id="story_title" name="story[title]"
                        value="{{ old('story.title', $aboutData['story']['title'] ?? '') }}" placeholder="Our Story & Mission">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="story_subtitle">Story Subtitle</label>
                    <input type="text" class="form-control" id="story_subtitle" name="story[subtitle]"
                        value="{{ old('story.subtitle', $aboutData['story']['subtitle'] ?? '') }}" placeholder="Founded in 2009, Cleanway Service Limited began with a simple mission">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="story_paragraph1">Paragraph 1</label>
                    <textarea class="form-control" id="story_paragraph1" name="story[paragraph1]" rows="4"
                        placeholder="Founded in 2009, Cleanway Service Limited began with a simple mission...">{{ old('story.paragraph1', $aboutData['story']['paragraph1'] ?? '') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="story_paragraph2">Paragraph 2</label>
                    <textarea class="form-control" id="story_paragraph2" name="story[paragraph2]" rows="4"
                        placeholder="Our founder, Bipan Bhandari, recognized the need...">{{ old('story.paragraph2', $aboutData['story']['paragraph2'] ?? '') }}</textarea>
                </div>
                <div>
                    <label class="form-label" for="story_paragraph3">Paragraph 3</label>
                    <textarea class="form-control" id="story_paragraph3" name="story[paragraph3]" rows="4"
                        placeholder="Today, we serve residential and commercial clients...">{{ old('story.paragraph3', $aboutData['story']['paragraph3'] ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save"></i> Update About Page Settings
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
let statIndex = {{ count($aboutData['stats'] ?? []) }};
let featureIndex = {{ count($aboutData['features'] ?? []) }};
let valueIndex = {{ count($aboutData['values'] ?? []) }};

document.getElementById('add-stat').addEventListener('click', function() {
    const container = document.getElementById('stats-container');
    const newItem = document.createElement('div');
    newItem.className = 'stat-item border rounded p-3 mb-3';
    newItem.innerHTML = `
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Number/Value</label>
                <input type="text" class="form-control" name="stats[${statIndex}][number]" placeholder="15+" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Label</label>
                <input type="text" class="form-control" name="stats[${statIndex}][label]" placeholder="Years Experience" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Icon</label>
                <select class="form-select" name="stats[${statIndex}][icon]" required>
                    <option value="calendar">Calendar</option>
                    <option value="users">Users</option>
                    <option value="user-check">User Check</option>
                    <option value="clock">Clock</option>
                    <option value="star">Star</option>
                    <option value="award">Award</option>
                </select>
            </div>
            <div class="col-md-2 text-md-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-stat">Remove</button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
    statIndex++;
});

document.getElementById('add-feature').addEventListener('click', function() {
    const container = document.getElementById('features-container');
    const newItem = document.createElement('div');
    newItem.className = 'feature-item border rounded p-3 mb-3';
    newItem.innerHTML = `
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label class="form-label">Feature Title</label>
                <input type="text" class="form-control" name="features[${featureIndex}][title]" placeholder="Fully Licensed & Insured" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Icon</label>
                <select class="form-select" name="features[${featureIndex}][icon]" required>
                    <option value="shield">Shield</option>
                    <option value="user-check">User Check</option>
                    <option value="leaf">Leaf</option>
                    <option value="check-circle">Check Circle</option>
                    <option value="calendar">Calendar</option>
                    <option value="dollar-sign">Dollar Sign</option>
                </select>
            </div>
            <div class="col-md-2 text-md-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-feature">Remove</button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
    featureIndex++;
});

document.getElementById('add-value').addEventListener('click', function() {
    const container = document.getElementById('values-container');
    const newItem = document.createElement('div');
    newItem.className = 'value-item border rounded p-3 mb-3';
    newItem.innerHTML = `
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Value Title</label>
                <input type="text" class="form-control" name="values[${valueIndex}][title]" placeholder="Customer First" required>
            </div>
            <div class="col-md-5">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="2" name="values[${valueIndex}][description]" placeholder="Your satisfaction is our top priority..." required></textarea>
            </div>
            <div class="col-md-2">
                <label class="form-label">Icon</label>
                <select class="form-select" name="values[${valueIndex}][icon]" required>
                    <option value="heart">Heart</option>
                    <option value="award">Award</option>
                    <option value="shield">Shield</option>
                    <option value="leaf">Leaf</option>
                    <option value="star">Star</option>
                    <option value="users">Users</option>
                </select>
            </div>
            <div class="col-md-2 text-md-end">
                <button type="button" class="btn btn-outline-danger btn-sm remove-value">Remove</button>
            </div>
        </div>
    `;
    container.appendChild(newItem);
    valueIndex++;
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-stat')) {
        e.target.closest('.stat-item').remove();
    }
    if (e.target.classList.contains('remove-feature')) {
        e.target.closest('.feature-item').remove();
    }
    if (e.target.classList.contains('remove-value')) {
        e.target.closest('.value-item').remove();
    }
    if (e.target.classList.contains('remove-about-image')) {
        e.target.closest('.about-image-item').remove();
    }
});

document.getElementById('add-about-image').addEventListener('click', function() {
    const container = document.getElementById('about-image-list-container');
    const newItem = document.createElement('div');
    newItem.className = 'about-image-item d-flex align-items-center gap-2 mb-2';
    newItem.innerHTML = `
        <img src="" alt="About Image" class="rounded border" style="width: 60px; height: 60px; object-fit: cover; display: none;">
        <input type="text" class="form-control" name="about_image_list[]" placeholder="Image URL...">
        <button type="button" class="btn btn-outline-danger btn-sm remove-about-image">Remove</button>
    `;
    container.appendChild(newItem);
});

const uploadBtn = document.getElementById('upload-about-image');
const uploadInput = document.getElementById('about-image-upload');
const uploadStatus = document.getElementById('about-image-upload-status');

uploadBtn.addEventListener('click', function() {
    const file = uploadInput.files[0];
    if (!file) {
        uploadStatus.textContent = 'Please select an image.';
        uploadStatus.className = 'small text-danger';
        return;
    }
    uploadStatus.textContent = 'Uploading...';
    uploadStatus.className = 'small text-muted';
    const formData = new FormData();
    formData.append('image', file);
    formData.append('_token', '{{ csrf_token() }}');
    fetch("{{ route('admin.settings.about.uploadImage') }}", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.url) {
            const container = document.getElementById('about-image-list-container');
            const newItem = document.createElement('div');
            newItem.className = 'about-image-item d-flex align-items-center gap-2 mb-2';
            newItem.innerHTML = `
                <img src="${data.url}" alt="About Image" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;">
                <input type="text" class="form-control" name="about_image_list[]" value="${data.url}" placeholder="Image URL...">
                <button type="button" class="btn btn-outline-danger btn-sm remove-about-image">Remove</button>
            `;
            container.appendChild(newItem);
            uploadStatus.textContent = 'Image uploaded!';
            uploadStatus.className = 'small text-success';
            uploadInput.value = '';
        } else {
            uploadStatus.textContent = data.message || 'Upload failed.';
            uploadStatus.className = 'small text-danger';
        }
    })
    .catch(() => {
        uploadStatus.textContent = 'Upload failed.';
        uploadStatus.className = 'small text-danger';
    });
});
</script>
@endpush
