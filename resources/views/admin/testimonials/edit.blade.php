@extends('admin.layouts.app')

@section('title', 'Edit Testimonial')
@section('page-title', 'Testimonials')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Edit Testimonial',
        'description' => $testimonial->name,
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('testimonials.update', $testimonial->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-4">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $testimonial->name) }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="position">Location</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $testimonial->position) }}" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="service">Service</label>
                        <input type="text" id="service" name="service" value="{{ old('service', $testimonial->service) }}" class="form-control">
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="message">Message</label>
                        <textarea id="message" name="message" rows="4" class="form-control" required>{{ old('message', $testimonial->message) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="photo">Photo</label>
                        <input type="file" id="photo" name="photo" class="dropify" accept="image/*" data-height="140"
                            @if($testimonial->photo) data-default-file="{{ asset($testimonial->photo) }}" @endif>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('testimonials.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
