@extends('admin.layouts.app')

@section('title', 'Edit Team Member')
@section('page-title', 'Team Members')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Edit Team Member',
        'description' => $team->name,
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('teams.update', $team->id) }}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $team->name) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="position">Position</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $team->position) }}" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="photo">Photo</label>
                        <input type="file" id="photo" name="photo" class="dropify" accept="image/*"
                            @if($team->photo) data-default-file="{{ asset($team->photo) }}" @endif>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="bio">Bio</label>
                        <textarea id="bio" name="bio" class="form-control" rows="4">{{ old('bio', $team->bio) }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="phone">Phone <span class="form-text d-inline">(separate using | if multiple)</span></label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $team->phone) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="email">Email <span class="form-text d-inline">(separate using | if multiple)</span></label>
                        <input type="text" id="email" name="email" class="form-control" value="{{ old('email', $team->email) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="experienced">Experienced In <span class="form-text d-inline">(separate using | if multiple)</span></label>
                        <input type="text" id="experienced" name="experienced" class="form-control" required value="{{ old('experienced', $team->experienced) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('teams.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Save Changes</button>
                </div>
            </form>
        </div>
    </div>
@endsection
