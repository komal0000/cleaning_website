@extends('front.layouts.app')

@section('title', $gallery->title . ' | Cleanway Results')
@section('description', Str::limit($gallery->description ?: 'A Cleanway project result with before and after context.', 155))

@section('content')
    @includeIf('front.components.gallery-detail.main')
@endsection
