@extends('front.layouts.app')

@section('title', 'Cleaning Services | Cleanway Service Limited')
@section('description', 'Explore home, business, Airbnb and specialist cleaning services available across Auckland, Hamilton, Palmerston North and Christchurch.')

@section('content')
    @includeIf('front.components.services.hero')

    @includeIf('front.components.services.areas')

    @includeIf('front.components.services.catalogue')

    @includeIf('front.components.services.promise')
@endsection
