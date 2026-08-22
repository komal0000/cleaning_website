@extends('front.layouts.app')

@section('title', 'Results | Cleanway Service Limited')
@section('description', 'Explore real Cleanway project stories with before and after photography, service information and location context where available.')

@section('content')
    @includeIf('front.components.gallery.header')

    @includeIf('front.components.gallery.main')

    @includeIf('front.components.gallery.cta')
@endsection
