@extends('admin.layouts.app')

@section('title', 'Home Settings')
@section('page-title', 'Settings')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Home Settings',
        'description' => 'Configure your homepage content, statistics, and featured video.',
    ])

    <form action="{{ route('admin.settings.home.update') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Homepage Content</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="home_title">Home Title</label>
                    <input type="text" class="form-control" id="home_title" name="home_title"
                        value="{{ old('home_title', $setting->home_title ?? '') }}" placeholder="Clean spaces.">
                    @error('home_title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="home_subtitle">Home Subtitle</label>
                    <input type="text" class="form-control" id="home_subtitle" name="home_subtitle"
                        value="{{ old('home_subtitle', $setting->home_subtitle ?? '') }}" placeholder="Clear minds.">
                    @error('home_subtitle')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Shown as the highlighted second line of the homepage headline.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="home_description">Home Description</label>
                    <textarea class="form-control" id="home_description" name="home_description" rows="4"
                        placeholder="Describe what makes your website special and what visitors can expect to find here...">{{ old('home_description', $setting->home_description ?? '') }}</textarea>
                    @error('home_description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="youtube_url">YouTube Video URL</label>
                    <input type="url" class="form-control" id="youtube_url" name="youtube_url"
                        value="{{ old('youtube_url', $setting->youtube_url ?? '') }}"
                        placeholder="https://www.youtube.com/watch?v=VIDEO_ID">
                    @error('youtube_url')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Enter a YouTube video URL to display on your homepage.</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Statistics Section</div>
            <div class="card-body">
                <div id="statistics-container">
                    @if($setting && $setting->statistics)
                        @foreach($setting->statistics as $index => $stat)
                            <div class="statistic-item border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h4 class="h6 mb-0">Statistic {{ $index + 1 }}</h4>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeStatistic(this)">Remove</button>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Title</label>
                                        <input type="text" class="form-control" name="statistics[{{ $index }}][title]" value="{{ $stat['title'] ?? '' }}" placeholder="5-Star">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Subtitle</label>
                                        <input type="text" class="form-control" name="statistics[{{ $index }}][subtitle]" value="{{ $stat['subtitle'] ?? '' }}" placeholder="Rating">
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Icon</label>
                                    <select class="form-select" name="statistics[{{ $index }}][icon]">
                                        <option value="star" {{ ($stat['icon'] ?? '') == 'star' ? 'selected' : '' }}>Star</option>
                                        <option value="certificate" {{ ($stat['icon'] ?? '') == 'certificate' ? 'selected' : '' }}>Certificate</option>
                                        <option value="users" {{ ($stat['icon'] ?? '') == 'users' ? 'selected' : '' }}>Users</option>
                                        <option value="clock" {{ ($stat['icon'] ?? '') == 'clock' ? 'selected' : '' }}>Clock</option>
                                        <option value="trophy" {{ ($stat['icon'] ?? '') == 'trophy' ? 'selected' : '' }}>Trophy</option>
                                        <option value="heart" {{ ($stat['icon'] ?? '') == 'heart' ? 'selected' : '' }}>Heart</option>
                                    </select>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" onclick="addStatistic()">
                    <i data-lucide="plus"></i> Add Statistic
                </button>
            </div>
        </div>

        @if($setting && ($setting->home_title || $setting->home_subtitle || $setting->home_description || $setting->youtube_url))
        <div class="card mb-4">
            <div class="card-header">Current Homepage Preview</div>
            <div class="card-body">
                @if($setting->home_title)
                    <h4 class="mb-1">{{ strip_tags($setting->home_title) }}</h4>
                @endif
                @if($setting->home_subtitle)
                    <p class="fw-semibold mb-2">{{ $setting->home_subtitle }}</p>
                @endif
                @if($setting->home_description)
                    <p class="text-muted mb-2">{{ $setting->home_description }}</p>
                @endif
                @if($setting->youtube_url)
                    <p class="mb-0 small">
                        <strong>Featured Video:</strong>
                        <a href="{{ $setting->youtube_url }}" target="_blank" rel="noopener">{{ $setting->youtube_url }}</a>
                    </p>
                @endif
            </div>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-body">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="use_image_in_home" id="use_image_in_home" value="1" {{ old('use_image_in_home', $useImageInHome ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="use_image_in_home">Use Images in Home Section</label>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Home Image List</div>
            <div class="card-body">
                <div class="row align-items-center g-3 mb-4">
                    <div class="col-auto">
                        <label class="form-label mb-0" for="home_image_per_line">Image Layout</label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="home_image_per_line" name="home_image_per_line">
                            <option value="1" {{ (old('home_image_per_line', $homeImagePerLine ?? 1) == 1) ? 'selected' : '' }}>Single (1 per line)</option>
                            <option value="2" {{ (old('home_image_per_line', $homeImagePerLine ?? 1) == 2) ? 'selected' : '' }}>2x (2 per line)</option>
                            <option value="3" {{ (old('home_image_per_line', $homeImagePerLine ?? 1) == 3) ? 'selected' : '' }}>3x (3 per line)</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                    <input type="file" id="home-image-upload" accept="image/*" class="form-control" style="max-width: 320px;">
                    <button type="button" class="btn btn-primary btn-sm" id="upload-home-image">Upload Image</button>
                    <span id="home-image-upload-status" class="small text-muted"></span>
                </div>

                <div id="home-image-list-container" class="mb-3">
                    @php $homeImageList = old('home_image_list', $homeImageList ?? []); @endphp
                    @foreach($homeImageList as $idx => $img)
                        <div class="home-image-item d-flex align-items-center gap-2 mb-2">
                            <img src="{{ $img }}" alt="Home Image" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;">
                            <input type="text" class="form-control" name="home_image_list[]" value="{{ $img }}" placeholder="Image URL...">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-home-image">Remove</button>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-outline-primary btn-sm" id="add-home-image">
                    <i data-lucide="plus"></i> Add Image URL
                </button>
                <p class="form-text mt-2 mb-0">Paste image URLs or upload images and paste their links here.</p>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save"></i> Update Home Settings
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
let statisticIndex = {{ $setting && $setting->statistics ? count($setting->statistics) : 0 }};

function addStatistic() {
    const container = document.getElementById('statistics-container');
    const newStatistic = document.createElement('div');
    newStatistic.className = 'statistic-item border rounded p-3 mb-3';

    newStatistic.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="h6 mb-0">Statistic ${statisticIndex + 1}</h4>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeStatistic(this)">Remove</button>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="statistics[${statisticIndex}][title]" placeholder="5-Star">
            </div>
            <div class="col-md-6">
                <label class="form-label">Subtitle</label>
                <input type="text" class="form-control" name="statistics[${statisticIndex}][subtitle]" placeholder="Rating">
            </div>
        </div>

        <div>
            <label class="form-label">Icon</label>
            <select class="form-select" name="statistics[${statisticIndex}][icon]">
                <option value="star">Star</option>
                <option value="certificate">Certificate</option>
                <option value="users">Users</option>
                <option value="clock">Clock</option>
                <option value="trophy">Trophy</option>
                <option value="heart">Heart</option>
            </select>
        </div>
    `;

    container.appendChild(newStatistic);
    statisticIndex++;
}

function removeStatistic(button) {
    const statisticItem = button.closest('.statistic-item');
    statisticItem.remove();

    const items = document.querySelectorAll('.statistic-item h4');
    items.forEach((item, index) => {
        item.textContent = `Statistic ${index + 1}`;
    });
}

document.getElementById('add-home-image').addEventListener('click', function() {
    const container = document.getElementById('home-image-list-container');
    const newItem = document.createElement('div');
    newItem.className = 'home-image-item d-flex align-items-center gap-2 mb-2';
    newItem.innerHTML = `
        <img src="" alt="Home Image" class="rounded border" style="width: 60px; height: 60px; object-fit: cover; display: none;">
        <input type="text" class="form-control" name="home_image_list[]" placeholder="Image URL...">
        <button type="button" class="btn btn-outline-danger btn-sm remove-home-image">Remove</button>
    `;
    container.appendChild(newItem);
});

const uploadHomeBtn = document.getElementById('upload-home-image');
const uploadHomeInput = document.getElementById('home-image-upload');
const uploadHomeStatus = document.getElementById('home-image-upload-status');

uploadHomeBtn.addEventListener('click', function() {
    const file = uploadHomeInput.files[0];
    if (!file) {
        uploadHomeStatus.textContent = 'Please select an image.';
        uploadHomeStatus.className = 'small text-danger';
        return;
    }
    uploadHomeStatus.textContent = 'Uploading...';
    uploadHomeStatus.className = 'small text-muted';
    const formData = new FormData();
    formData.append('image', file);
    formData.append('_token', '{{ csrf_token() }}');
    fetch("{{ route('admin.settings.home.uploadImage') }}", {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.url) {
            const container = document.getElementById('home-image-list-container');
            const newItem = document.createElement('div');
            newItem.className = 'home-image-item d-flex align-items-center gap-2 mb-2';
            newItem.innerHTML = `
                <img src="${data.url}" alt="Home Image" class="rounded border" style="width: 60px; height: 60px; object-fit: cover;">
                <input type="text" class="form-control" name="home_image_list[]" value="${data.url}" placeholder="Image URL...">
                <button type="button" class="btn btn-outline-danger btn-sm remove-home-image">Remove</button>
            `;
            container.appendChild(newItem);
            uploadHomeStatus.textContent = 'Image uploaded!';
            uploadHomeStatus.className = 'small text-success';
            uploadHomeInput.value = '';
        } else {
            uploadHomeStatus.textContent = data.message || 'Upload failed.';
            uploadHomeStatus.className = 'small text-danger';
        }
    })
    .catch(() => {
        uploadHomeStatus.textContent = 'Upload failed.';
        uploadHomeStatus.className = 'small text-danger';
    });
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-home-image')) {
        e.target.closest('.home-image-item').remove();
    }
});
</script>
@endpush
