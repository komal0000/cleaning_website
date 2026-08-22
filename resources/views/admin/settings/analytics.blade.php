@extends('admin.layouts.app')

@section('title', 'Google Analytics Settings')
@section('page-title', 'Settings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Google Analytics Settings',
        'description' => 'Configure Google Analytics tracking for your website.',
    ])

    <form action="{{ route('admin.settings.analytics.update') }}" method="POST">
        @csrf

        <div class="card mb-4">
            <div class="card-header">Basic Configuration</div>
            <div class="card-body">
                <div class="mb-4">
                    <label class="form-label" for="google_analytics_measurement_id">Measurement ID</label>
                    <input type="text" class="form-control" id="google_analytics_measurement_id" name="google_analytics_measurement_id"
                        value="{{ old('google_analytics_measurement_id', $setting->google_analytics_measurement_id ?? '') }}"
                        placeholder="G-XXXXXXXXXX">
                    <div class="form-text">Find this in your Google Analytics property settings.</div>
                    @error('google_analytics_measurement_id')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="google_analytics_enabled" id="google_analytics_enabled" value="1" {{ old('google_analytics_enabled', $setting->google_analytics_enabled ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="google_analytics_enabled">Enable Google Analytics Tracking</label>
                    <div class="form-text">Turn this on to start collecting analytics data.</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Advanced Settings</div>
            <div class="card-body">
                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" name="google_analytics_debug" id="google_analytics_debug" value="1" {{ old('google_analytics_debug', $setting->google_analytics_debug ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="google_analytics_debug">Enable Debug Mode</label>
                    <div class="form-text">Enable detailed logging in the browser console for troubleshooting.</div>
                </div>

                <div class="form-check form-switch mb-4">
                    <input class="form-check-input" type="checkbox" role="switch" name="google_analytics_anonymize_ip" id="google_analytics_anonymize_ip" value="1" {{ old('google_analytics_anonymize_ip', $setting->google_analytics_anonymize_ip ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="google_analytics_anonymize_ip">Anonymize IP Addresses</label>
                    <div class="form-text">Recommended for GDPR compliance.</div>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="google_analytics_send_page_view" id="google_analytics_send_page_view" value="1" {{ old('google_analytics_send_page_view', $setting->google_analytics_send_page_view ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="google_analytics_send_page_view">Send Page View Events</label>
                    <div class="form-text">Automatically track page views.</div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Active Environments</div>
            <div class="card-body">
                <p class="form-text mt-0">Select which environments should load Google Analytics.</p>

                @php
                    $environments = ['local', 'staging', 'production'];
                    $selectedEnvironments = old('google_analytics_environments', $setting->google_analytics_environments ?? ['production']);
                @endphp

                @foreach($environments as $env)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="google_analytics_environments[]" id="env_{{ $env }}" value="{{ $env }}" {{ in_array($env, $selectedEnvironments) ? 'checked' : '' }}>
                        <label class="form-check-label text-capitalize" for="env_{{ $env }}">
                            {{ $env }}
                            @if($env === 'production')
                                <span class="badge bg-success ms-1">Recommended</span>
                            @endif
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">Current Status</div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="mb-1 fw-semibold">Current Environment</p>
                        <p class="mb-0 text-muted">{{ config('app.env') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 fw-semibold">Analytics Status</p>
                        <p class="mb-0">
                            @if(config('analytics.enabled') && config('analytics.measurement_id'))
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if(config('analytics.measurement_id'))
                    <div class="border rounded p-3 mt-3" style="background: var(--cloud);">
                        <p class="mb-1 fw-semibold small">Current Measurement ID</p>
                        <code style="color: var(--success);">{{ config('analytics.measurement_id') }}</code>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save"></i> Save Analytics Settings
            </button>
        </div>
    </form>
@endsection
