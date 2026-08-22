@extends('front.layouts.app')

@section('title', 'Client Reviews | Cleanway Service Limited')
@section('description', 'Read client feedback currently published by Cleanway Service Limited, with service context where available.')

@section('content')
    @includeIf('front.components.testimonials')
@endsection
