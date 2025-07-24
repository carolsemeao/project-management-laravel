@extends('home.home_master')

@section('title', 'Startseite')
@section('maincontent')
    @include('home.layout.hero')
    <!-- end hero -->
    @include('home.layout.features')
    <!-- end content -->
    @include('home.layout.clarify')
    <!-- end content -->
    @include('home.layout.get_all')
    <!-- end content -->
    @include('home.layout.usability')
    <!-- end video -->
    @include('home.layout.testimonials')
    <!-- end testimonial -->
    @include('home.layout.faq')
    <!-- end faq -->
    @include('home.layout.cta')
    <!-- end cta -->
@endsection