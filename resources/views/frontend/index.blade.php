@extends('frontend.layouts.front')

@section('title','My Bazar')

@section('content')

    @include('frontend._banner')

    @include('frontend._service')

    @include('frontend._discount')

    @include('frontend._categories')

    @include('frontend._ad-poster')

    @include('frontend._product-tab')

    @include('frontend._offer-count')

    @include('frontend._products')

    @include('frontend._brand-logo')

    @include('frontend._popup')

@stop
