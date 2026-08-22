@extends('front.layouts.app')

@section('title', 'Careers at Cleanway Service Limited')
@section('description', 'Explore roles currently published by Cleanway Service Limited and apply through a clear mobile-friendly form.')

@section('content')
    @includeIf('front.components.career.hero')

    @includeIf('front.components.career.roles')

    @includeIf('front.components.career.apply')
@endsection

@includeIf('front.components.career.scripts')
