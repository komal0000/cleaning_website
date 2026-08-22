@extends('front.layouts.app')

@section('title', 'Page Not Found | Cleanway Service Limited')
@section('description', 'The Cleanway page you requested could not be found.')

@section('content')
    @includeIf('front.components.404.main')
@endsection
