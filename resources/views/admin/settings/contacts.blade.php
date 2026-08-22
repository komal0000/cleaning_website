@extends('admin.layouts.app')

@section('title', 'Contact Details')
@section('page-title', 'Settings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Contact Details',
        'description' => 'Phone, email, address, social links, and map information shown on the contact page.',
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.settings.contact') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label" for="contact_email">Email</label>
                        <input type="text" class="form-control" id="contact_email" name="contact_email"
                            value="{{ old('contact_email', $setting->contact_email ?? '') }}" placeholder="contact@yoursite.com">
                        @error('contact_email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="contact_phone">Phone</label>
                        <input type="text" class="form-control" id="contact_phone" name="contact_phone"
                            value="{{ old('contact_phone', $setting->contact_phone ?? '') }}" placeholder="+1 (555) 123-4567">
                        @error('contact_phone')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="contact_address">Address</label>
                        <textarea class="form-control" id="contact_address" name="contact_address" rows="3"
                            placeholder="Your business address">{{ old('contact_address', $setting->contact_address ?? '') }}</textarea>
                        @error('contact_address')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="contact_facebook">Facebook</label>
                        <input type="text" class="form-control" id="contact_facebook" name="contact_facebook"
                            value="{{ old('contact_facebook', $setting->contact_facebook ?? '') }}" placeholder="https://facebook.com/yourpage">
                        @error('contact_facebook')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="contact_service">Service Areas</label>
                        <input type="text" class="form-control" id="contact_service" name="contact_service"
                            value="{{ old('service_areas', $setting->contact_service ?? '') }}" placeholder="City, State, Country">
                        @error('contact_service')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="contact_hours">Official Hours</label>
                        <input type="text" class="form-control" id="contact_hours" name="contact_hours"
                            value="{{ old('contact_hours', $setting->contact_hours ?? '') }}" placeholder="Mon-Fri: 9am - 5pm">
                        @error('contact_hours')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="contact_why_choose_us">Why Choose Us</label>
                        <textarea class="form-control" id="contact_why_choose_us" name="contact_why_choose_us" rows="3"
                            placeholder="Why customers should choose your services">{{ old('contact_why_choose_us', $setting->contact_why_choose_us ?? '') }}</textarea>
                        @error('contact_why_choose_us')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="contact_map">Map Embed URL</label>
                        <input type="text" class="form-control" id="contact_map" name="contact_map"
                            value="{{ old('contact_map', $setting->contact_map ?? '') }}" placeholder="Google Maps embed URL">
                        @error('contact_map')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="contact_map_path">Map Image Path</label>
                        <input type="text" class="form-control" id="contact_map_path" name="contact_map_path"
                            value="{{ old('contact_map_path', $setting->contact_map_path ?? '') }}" placeholder="/images/map.jpg or URL to map image">
                        @error('contact_map_path')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Path to an image file (e.g. /images/map.jpg) or a direct URL shown on the contact page.</div>
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
