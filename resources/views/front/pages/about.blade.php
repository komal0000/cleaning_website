@extends('front.layouts.app')

@section('title', 'About Cleanway Service Limited')
@section('description', 'Meet the thinking behind Cleanway and the clear four-step standard used to plan, prepare, clean and verify each service.')

@section('content')
    @includeIf('front.components.about.main')

    @includeIf('front.components.about.story')

    @includeIf('front.components.about.values')

    @includeIf('front.components.about.standard')

    @includeIf('front.components.about.team-cta')
@endsection
