@extends('front.layouts.app')

@section('title', 'Cleaning Services | Cleanway Service Limited')
@section('description', 'Explore home, business, Airbnb and specialist cleaning services available across Auckland, Hamilton, Palmerston North and Christchurch.')

@section('content')
    @include('front.components.services.hero')

    @include('front.components.services.areas')

    @include('front.components.services.catalogue')

    @include('front.components.services.promise')
@endsection
