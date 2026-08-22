@extends('admin.layouts.app')

@section('title', 'Brand & SEO')
@section('page-title', 'Settings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Brand & SEO',
        'description' => 'Logo, meta tags, and search engine information.',
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.update.meta') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Logo</label>
                        <input type="file" name="logo" accept="image/*" class="dropify"
                            @if($setting && $setting->logo_path) data-default-file="{{ asset($setting->logo_path) }}" @endif>
                        @error('logo')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Banner Image</label>
                        <input type="file" name="banner_image" accept="image/*" class="dropify" data-max-height="120"
                            @if($setting && $setting->banner_image) data-default-file="{{ asset($setting->banner_image) }}" @endif>
                        @error('banner_image')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="logo_title">Logo Title</label>
                        <input type="text" class="form-control" id="logo_title" name="logo_title"
                            value="{{ old('logo_title', $setting->logo_title ?? '') }}"
                            placeholder="Company name to display with logo">
                        @error('logo_title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="meta_title">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title"
                            value="{{ old('meta_title', $setting->meta_title ?? '') }}" placeholder="Your website title">
                        @error('meta_title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="meta_description">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="4"
                            placeholder="Describe your website in a few sentences">{{ old('meta_description', $setting->meta_description ?? '') }}</textarea>
                        @error('meta_description')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"
                            value="{{ old('meta_keywords', $setting->meta_keywords ?? '') }}"
                            placeholder="keyword1, keyword2, keyword3">
                        @error('meta_keywords')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
