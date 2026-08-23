@extends('admin.layouts.app')

@section('title', 'Services Page Settings')
@section('page-title', 'Settings')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Services Page Settings',
        'description' => 'Service areas and promises displayed on the public Services page.',
    ])

    <form method="POST" action="{{ route('admin.settings.services') }}">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Service Areas</div>
            <div class="card-body">
                <div id="service-areas-container">
                    @foreach($serviceAreas as $index => $area)
                    <div class="service-area-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label" for="service_areas[{{ $index }}][name]">Area Name</label>
                                <input type="text" class="form-control"
                                       name="service_areas[{{ $index }}][name]"
                                       value="{{ $area['name'] }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="service_areas[{{ $index }}][description]">Description</label>
                                <input type="text" class="form-control"
                                       name="service_areas[{{ $index }}][description]"
                                       value="{{ $area['description'] }}" required>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-service-area">Remove</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-service-area">
                    <i data-lucide="plus"></i> Add Service Area
                </button>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Our Promise</div>
            <div class="card-body">
                <div id="promise-container">
                    @foreach($ourPromise as $index => $promise)
                    <div class="promise-item border rounded p-3 mb-3">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label" for="our_promise[{{ $index }}][title]">Title</label>
                                <input type="text" class="form-control"
                                       name="our_promise[{{ $index }}][title]"
                                       value="{{ $promise['title'] }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label" for="our_promise[{{ $index }}][description]">Description</label>
                                <textarea class="form-control" rows="2"
                                          name="our_promise[{{ $index }}][description]"
                                          required>{{ $promise['description'] }}</textarea>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label" for="our_promise[{{ $index }}][icon]">Icon</label>
                                <select class="form-select" name="our_promise[{{ $index }}][icon]" required>
                                    <option value="check-circle" {{ $promise['icon'] == 'check-circle' ? 'selected' : '' }}>Check Circle</option>
                                    <option value="shield" {{ $promise['icon'] == 'shield' ? 'selected' : '' }}>Shield</option>
                                    <option value="leaf" {{ $promise['icon'] == 'leaf' ? 'selected' : '' }}>Leaf</option>
                                    <option value="clock" {{ $promise['icon'] == 'clock' ? 'selected' : '' }}>Clock</option>
                                    <option value="star" {{ $promise['icon'] == 'star' ? 'selected' : '' }}>Star</option>
                                    <option value="heart" {{ $promise['icon'] == 'heart' ? 'selected' : '' }}>Heart</option>
                                </select>
                            </div>
                            <div class="col-md-2 text-md-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-promise">Remove</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" id="add-promise">
                    <i data-lucide="plus"></i> Add Promise
                </button>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-light">Back to Settings</a>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save"></i> Update Services Settings
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let serviceAreaIndex = {{ count($serviceAreas) }};
    let promiseIndex = {{ count($ourPromise) }};

    document.getElementById('add-service-area').addEventListener('click', function() {
        const container = document.getElementById('service-areas-container');
        const newItem = document.createElement('div');
        newItem.className = 'service-area-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Area Name</label>
                    <input type="text" class="form-control"
                           name="service_areas[${serviceAreaIndex}][name]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Description</label>
                    <input type="text" class="form-control"
                           name="service_areas[${serviceAreaIndex}][description]" required>
                </div>
                <div class="col-md-2 text-md-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-service-area">Remove</button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        serviceAreaIndex++;
    });

    document.getElementById('add-promise').addEventListener('click', function() {
        const container = document.getElementById('promise-container');
        const newItem = document.createElement('div');
        newItem.className = 'promise-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Title</label>
                    <input type="text" class="form-control"
                           name="our_promise[${promiseIndex}][title]" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="2"
                              name="our_promise[${promiseIndex}][description]" required></textarea>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Icon</label>
                    <select class="form-select" name="our_promise[${promiseIndex}][icon]" required>
                        <option value="check-circle">Check Circle</option>
                        <option value="shield">Shield</option>
                        <option value="leaf">Leaf</option>
                        <option value="clock">Clock</option>
                        <option value="star">Star</option>
                        <option value="heart">Heart</option>
                    </select>
                </div>
                <div class="col-md-2 text-md-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-promise">Remove</button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        promiseIndex++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-service-area')) {
            e.target.closest('.service-area-item').remove();
        }
        if (e.target.classList.contains('remove-promise')) {
            e.target.closest('.promise-item').remove();
        }
    });
});
</script>
@endpush
