@extends('backend.layouts.app')
@section('title','Dashboard - ')
@push('css')
    <link rel="stylesheet" href="{{asset('backend/assets/font-awesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('backend/css/nice-select.css')}}">
@endpush
@section('content')
    @push('js')
        <script src="{{asset('backend/js/jquery.nice-select.min.js')}}"></script>
        <script src="{{asset('backend/js/chart.min.js')}}"></script>
    @endpush
        @include('backend.pages.dashboard')

@endsection



