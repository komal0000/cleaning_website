@extends('admin.layouts.app')

@section('title', 'Public Site Content')
@section('page-title', 'Settings')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Public Site Content',
        'description' => 'Edit public copy, links, and image paths. Each section has safe defaults, so incomplete values never leave the site blank.',
    ])

    <form method="POST" action="{{ route('admin.settings.site-content.update') }}" id="site-content-form">
        @csrf
        <input type="hidden" name="content_json" id="content-json">

        @foreach ($content as $section => $values)
            <details class="admin-section mb-3" {{ $section === 'global' ? 'open' : '' }}>
                <summary class="text-capitalize">{{ $section }} content</summary>
                <div class="admin-section-body">
                    <textarea class="form-control font-monospace content-section" data-section="{{ $section }}" rows="{{ $section === 'global' ? 24 : 32 }}">{{ json_encode($values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</textarea>
                </div>
            </details>
        @endforeach

        <div class="card mb-4">
            <div class="card-body">
                <label class="form-label" for="site-content-image">Upload an image</label>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <input class="form-control" style="max-width: 420px" type="file" id="site-content-image" accept="image/*">
                    <button class="btn btn-outline-primary btn-sm" type="button" id="upload-site-content-image">Upload image</button>
                </div>
                <small class="text-muted d-block mt-2" id="site-content-image-result">Upload an image, then paste its returned path into the relevant section’s image field.</small>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" type="submit">
                <i data-lucide="save"></i> Save public content
            </button>
        </div>
    </form>

@push('scripts')
<script>
(() => {
    const form = document.getElementById('site-content-form');
    const output = document.getElementById('content-json');
    const result = document.getElementById('site-content-image-result');

    form.addEventListener('submit', (event) => {
        const content = {};
        try {
            document.querySelectorAll('.content-section').forEach((field) => {
                content[field.dataset.section] = JSON.parse(field.value);
            });
            output.value = JSON.stringify(content);
        } catch (error) {
            event.preventDefault();
            result.textContent = `Fix the JSON in the highlighted section: ${error.message}`;
            result.className = 'text-danger d-block mt-2';
        }
    });

    document.getElementById('upload-site-content-image').addEventListener('click', async () => {
        const input = document.getElementById('site-content-image');
        if (!input.files[0]) return;
        const data = new FormData();
        data.append('_token', '{{ csrf_token() }}');
        data.append('image', input.files[0]);
        const response = await fetch('{{ route('admin.settings.site-content.upload') }}', { method: 'POST', body: data });
        const payload = await response.json();
        result.textContent = payload.path ? `Uploaded: ${payload.path}` : 'Image upload failed.';
        result.className = payload.path ? 'text-success d-block mt-2' : 'text-danger d-block mt-2';
    });
})();
</script>
@endpush
@endsection
