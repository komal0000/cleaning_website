@extends('admin.layouts.app')

@section('title', 'Google Maps & Reviews')
@section('page-title', 'Settings')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Google Maps & Reviews',
        'description' => 'Google Maps API key and Place ID used for the reviews integration.',
    ])

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.settings.googlemap.save') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="google_map_api_key">API Key</label>
                    <input type="text" class="form-control" id="google_map_api_key" name="google_map_api_key"
                        value="{{ old('google_map_api_key', $setting->google_map_api_key ?? '') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="google_map_place_id">Place ID</label>
                    <input type="text" class="form-control" id="google_map_place_id" name="google_map_place_id"
                        value="{{ old('google_map_place_id', $setting->google_map_place_id ?? 'ChIJ4UrE40VTDW0RAXtKyXd3fV8') }}" required>
                </div>
                <div class="mb-4">
                    <label class="form-label" for="google_review_url">
                        Google Review Public URL <span class="text-muted fw-normal">(optional, for direct review link)</span>
                    </label>
                    <input type="text" class="form-control" id="google_review_url" name="google_review_url"
                        value="{{ old('google_review_url', $setting->google_review_url ?? '') }}"
                        placeholder="https://g.page/r/xxxxxxxxxxxx/review">
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-light">Back to Settings</a>
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save"></i> Save Google Map Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">How to Get Your Google Map API Key</div>
        <div class="card-body">
            <div class="ratio ratio-16x9">
                <iframe src="https://www.youtube.com/embed/c9BDfSbAd6I?si=wVHuRwQddQlwPxLk" title="YouTube video player" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Google Review Preview</div>
        <div class="card-body">
            @includeIf('admin.template.footer.google_review')
        </div>
    </div>
@endsection
