@extends('front.layouts.app')

@section('title', 'Professional Cleaning Services | Cleanway Service Limited')
@section('description', 'Reliable home and commercial cleaning across Auckland, Hamilton, Palmerston North and Christchurch. Start a free Cleanway quote online.')

@section('content')
    @includeIf('front.components.hero')
    @includeIf('front.components.home.media')
@endsection
