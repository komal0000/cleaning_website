@extends('front.layouts.app')

@section('title', 'Our Team | Cleanway Service Limited')
@section('description', 'Meet the real people currently published as part of the Cleanway Service Limited team.')

@section('content')
    @includeIf('front.components.team.header')

    @includeIf('front.components.team.member')
@endsection
