@extends('admin.layouts.app')

@section('title', 'Edit Career')
@section('page-title', 'Careers')

@section('content')
    @includeIf('admin.partials.page-header', [
        'title' => 'Edit Career',
        'description' => $career->title,
    ])

    <div class="card">
        <div class="card-body">
            <form action="{{ route('careers.update', $career->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $career->title) }}" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="location">Location</label>
                        <input type="text" id="location" name="location" value="{{ old('location', $career->location) }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label" for="deadline">Deadline</label>
                        <input type="date" id="deadline" name="deadline" class="form-control" value="{{ old('deadline', $career->deadline) }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="description">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control" required>{{ old('description', $career->description) }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="requirement">Requirements <span class="form-text d-inline">(use | between requirements)</span></label>
                        <textarea id="requirement" name="requirement" rows="4" class="form-control" required>{{ old('requirement', $career->requirement) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('careers.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i data-lucide="save"></i> Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
