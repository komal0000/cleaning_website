@extends('admin.layouts.app')

@section('title', 'Team Page Settings')
@section('page-title', 'Settings')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Team Page Settings',
        'description' => 'Hero copy and section text shown on the public team page.',
    ])

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.settings.team') }}">
                @csrf

                <div class="row g-4">
                    <div class="col-12">
                        <label class="form-label" for="title1">Team Title</label>
                        <input type="text" class="form-control" id="title1" name="title1"
                            value="{{ $aboutSetting['title1'] ?? '' }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="subtitle1">Team Subtitle</label>
                        <textarea class="form-control" id="subtitle1" name="subtitle1" rows="3">{{ $aboutSetting['subtitle1'] ?? '' }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="title2">Company Title</label>
                        <input type="text" class="form-control" id="title2" name="title2"
                            value="{{ $aboutSetting['title2'] ?? '' }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="subtitle2">Company Description</label>
                        <textarea class="form-control" id="subtitle2" name="subtitle2" rows="4">{{ $aboutSetting['subtitle2'] ?? '' }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="service_area">Service Area</label>
                        <input type="text" class="form-control" id="service_area" name="service_area"
                            value="{{ $aboutSetting['service_area'] ?? '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="expert_team">Expert Team Description</label>
                        <input type="text" class="form-control" id="expert_team" name="expert_team"
                            value="{{ $aboutSetting['expert_team'] ?? '' }}">
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i data-lucide="save"></i> Update Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
