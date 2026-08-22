@extends('admin.layouts.app')

@section('title', 'Testimonials Page Settings')
@section('page-title', 'Settings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Testimonials Page Settings',
        'description' => 'Page title, description, and call-to-action section.',
    ])

    <form action="{{ route('admin.settings.testimonials.update') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Main Section</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="main_title">Main Title</label>
                    <input type="text" class="form-control" id="main_title" name="main_title"
                        value="{{ old('main_title', $setting->testimonials['main_title'] ?? 'What Our Clients') }}"
                        placeholder="What Our Clients" required>
                    @error('main_title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="main_title_highlight">Title Highlight</label>
                    <input type="text" class="form-control" id="main_title_highlight" name="main_title_highlight"
                        value="{{ old('main_title_highlight', $setting->testimonials['main_title_highlight'] ?? 'Say About Us') }}"
                        placeholder="Say About Us" required>
                    @error('main_title_highlight')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="subtitle">Subtitle / Description</label>
                    <textarea class="form-control" id="subtitle" name="subtitle" rows="4"
                        placeholder="Don't just take our word for it. Here's what our satisfied customers have to say..." required>{{ old('subtitle', $setting->testimonials['subtitle'] ?? '') }}</textarea>
                    @error('subtitle')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Call-to-Action Section</div>
            <div class="card-body">
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" name="show_cta" id="show_cta" value="1" {{ old('show_cta', $setting->testimonials['show_cta'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="show_cta">Show Call-to-Action Section</label>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="cta_title">CTA Title</label>
                    <input type="text" class="form-control" id="cta_title" name="cta_title"
                        value="{{ old('cta_title', $setting->testimonials['cta_title'] ?? 'Join Over 1000+ Happy Customers') }}"
                        placeholder="Join Over 1000+ Happy Customers" required>
                    @error('cta_title')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="cta_description">CTA Description</label>
                    <textarea class="form-control" id="cta_description" name="cta_description" rows="3"
                        placeholder="Experience the difference professional cleaning can make..." required>{{ old('cta_description', $setting->testimonials['cta_description'] ?? '') }}</textarea>
                    @error('cta_description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <label class="form-label" for="cta_button_text">Button Text</label>
                    <input type="text" class="form-control" id="cta_button_text" name="cta_button_text"
                        value="{{ old('cta_button_text', $setting->testimonials['cta_button_text'] ?? 'Get Your Free Quote') }}"
                        placeholder="Get Your Free Quote" required>
                    @error('cta_button_text')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        @if($setting && $setting->testimonials)
        <div class="card mb-4">
            <div class="card-header">Current Preview</div>
            <div class="card-body">
                <div class="border rounded p-4 text-center mb-3">
                    <h4 class="mb-2">
                        {{ $setting->testimonials['main_title'] ?? '' }}
                        <span class="d-block" style="color: var(--blue);">{{ $setting->testimonials['main_title_highlight'] ?? '' }}</span>
                    </h4>
                    <p class="text-muted mb-0">{{ $setting->testimonials['subtitle'] ?? '' }}</p>
                </div>

                @if($setting->testimonials['show_cta'] ?? false)
                <div class="rounded p-4 text-center" style="background: var(--ink); color: var(--white);">
                    <h5 class="mb-2" style="color: var(--white);">{{ $setting->testimonials['cta_title'] ?? '' }}</h5>
                    <p class="mb-3" style="color: #b9cbd8;">{{ $setting->testimonials['cta_description'] ?? '' }}</p>
                    <span class="badge" style="background: var(--lime); color: var(--ink); font-size: .8rem; padding: 8px 16px;">{{ $setting->testimonials['cta_button_text'] ?? '' }}</span>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save"></i> Update Testimonial Settings
            </button>
        </div>
    </form>
@endsection
